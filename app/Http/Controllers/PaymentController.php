<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function notification(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . env('MIDTRANS_SERVER_KEY'));

        if ($notification->signature_key !== $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }

        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $type = $notification->payment_type;

        $subscription = Subscription::where('reference_id', $orderId)->first();

        if (!$subscription) {
            return response(['message' => 'Subscription not found'], 404);
        }

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            // Payment success
            $subscription->update(['status' => 'active', 'payment_method' => $type]);
            
            // Activate User Premium
            $user = $subscription->user;
            $user->update([
                'is_premium' => true,
                'subscription_ends_at' => $subscription->ends_at
            ]);

            Log::info("Payment Success: " . $orderId . " for User: " . $user->name);

            return response(['message' => 'Success']);
        } elseif ($transactionStatus == 'expire' || $transactionStatus == 'cancel' || $transactionStatus == 'deny') {
            // Payment failed/expired
            $subscription->update(['status' => 'cancelled']);
        }

        return response(['message' => 'Notification handled']);
    }
}
