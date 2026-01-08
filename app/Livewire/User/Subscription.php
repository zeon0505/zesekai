<?php

namespace App\Livewire\User;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.user')]
class Subscription extends Component
{
    public function subscribe($plan)
    {
        \Illuminate\Support\Facades\Log::info("Method subscribe called for plan: " . $plan);
        $price = 0;
        $name = '';

        if($plan === 'monthly') {
            $price = 29000;
            $name = 'PREMIUM MONTHLY';
        } elseif($plan === 'yearly') {
            $price = 249000;
            $name = 'PREMIUM YEARLY';
        }

        $orderId = 'ZES-' . uniqid();
        \Illuminate\Support\Facades\Log::info("Order ID generated: " . $orderId);

        // Create Pending Subscription Record
        try {
            $subscription = \App\Models\Subscription::create([
                'user_id' => auth()->id(),
                'plan_name' => $name,
                'price' => $price,
                'status' => 'pending',
                'starts_at' => now(),
                'ends_at' => $plan === 'monthly' ? now()->addMonth() : now()->addYear(),
                'reference_id' => $orderId,
            ]);
            \Illuminate\Support\Facades\Log::info("Subscription record created ID: " . $subscription->id);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("DB Error: " . $e->getMessage());
            $this->dispatch('swal:alert', ['type' => 'error', 'title' => 'DB Error', 'text' => $e->getMessage()]);
            return;
        }

        // Midtrans Logic
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        if ($price <= 0) {
            $this->dispatch('swal:alert', [
                'type' => 'info',
                'title' => 'Free Plan',
                'text' => 'Paket Basic selalu aktif secara gratis.',
            ]);
            return;
        }

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $price,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'item_details' => [
                [
                    'id' => $plan,
                    'price' => $price,
                    'quantity' => 1,
                    'name' => 'Zesekai Premium ' . $name,
                ]
            ],
            'callbacks' => [
                'finish' => route('home')
            ]
        ];

        // Raw CURL Approach to avoid library issues on Local Windows
        try {
            \Illuminate\Support\Facades\Log::info("Starting Raw CURL Midtrans Request for " . $orderId);
            
            $serverKey = config('services.midtrans.server_key');
            $url = config('services.midtrans.is_production') 
                ? "https://app.midtrans.com/snap/v1/transactions" 
                : "https://app.sandbox.midtrans.com/snap/v1/transactions";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode($serverKey . ':')
            ]);
            
            // SSL Workaround & Performance
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 0); // Force fresh DNS
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            \Illuminate\Support\Facades\Log::info("Midtrans Raw Response Code: " . $httpCode);

            if ($curlError) {
                throw new \Exception("CURL Connection Error: " . $curlError);
            }

            $result = json_decode($response, true);
            
            if ($httpCode >= 400 || !isset($result['token'])) {
                \Illuminate\Support\Facades\Log::error("Midtrans API Error: " . $response);
                throw new \Exception("Midtrans API Error: " . ($result['error_messages'][0] ?? 'Unknown Error'));
            }

            $snapToken = $result['token'];
            \Illuminate\Support\Facades\Log::info("Snap Token Received via Raw CURL: " . $snapToken);
            
            $this->dispatch('payWithSnap', $snapToken);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Midtrans Error: " . $e->getMessage());
            $this->dispatch('swal:alert', [
                'type' => 'error',
                'title' => 'Payment Error',
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function forceActivate($orderId)
    {
        $subscription = \App\Models\Subscription::where('reference_id', $orderId)->first();
        if ($subscription) {
            $subscription->update(['status' => 'active']);
            
            $user = auth()->user();
            $user->is_premium = true;
            $user->subscription_ends_at = $subscription->ends_at;
            $user->save();

            $this->dispatch('swal:alert', [
                'type' => 'success',
                'title' => 'Simulasi Berhasil!',
                'text' => 'Premium kamu sudah dipaksa aktif (Mode Debug).',
            ]);
            
            return redirect()->route('home');
        }
    }

    public function checkPayment($orderId)
    {
        try {
            $serverKey = config('services.midtrans.server_key');
            $url = config('services.midtrans.is_production') 
                ? "https://api.midtrans.com/v2/{$orderId}/status" 
                : "https://api.sandbox.midtrans.com/v2/{$orderId}/status";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode($serverKey . ':')
            ]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $result = json_decode($response, true);
            $status = $result['transaction_status'] ?? '';

            if ($status === 'settlement' || $status === 'capture') {
                $subscription = \App\Models\Subscription::where('reference_id', $orderId)->first();
                if ($subscription) {
                    $subscription->update(['status' => 'active']);
                    
                    $user = auth()->user();
                    $user->is_premium = true;
                    $user->subscription_ends_at = $subscription->ends_at;
                    $user->save();

                    $this->dispatch('swal:alert', [
                        'type' => 'success',
                        'title' => 'Berhasil!',
                        'text' => 'Premium kamu sudah aktif. Silakan refresh halaman.',
                    ]);
                    
                    return redirect()->route('home');
                }
            } else {
                $this->dispatch('swal:alert', [
                    'type' => 'info',
                    'title' => 'Status: ' . ($status ?: 'Pending'),
                    'text' => 'Pembayaran belum terdeteksi. Silakan selesaikan pembayaran terlebih dahulu.',
                ]);
            }

        } catch (\Exception $e) {
            $this->dispatch('swal:alert', [
                'type' => 'error',
                'title' => 'Error',
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.user.subscription', [
            'activeSub' => \App\Models\Subscription::where('user_id', auth()->id())->where('status', 'active')->first(),
            'pendingSub' => \App\Models\Subscription::where('user_id', auth()->id())->where('status', 'pending')->latest()->first()
        ]);
    }
}
