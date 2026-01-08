<div class="py-12">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Header -->
        <div class="text-center mb-16 space-y-4">
            <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tighter text-white">ZESEKAI <span class="text-red-600">PREMIUM</span></h1>
            <p class="text-gray-500 font-bold uppercase tracking-[0.3em] text-[10px]">Tingkatkan pengalaman menontonmu tanpa gangguan</p>
        </div>

        @if($activeSub)
            <div class="bg-red-600/10 border border-red-600/20 rounded-2xl p-8 mb-16 text-center">
                <i class="bi bi-star-fill text-4xl text-red-600 mb-4 inline-block"></i>
                <h2 class="text-2xl font-black text-white uppercase tracking-tighter">Status: {{ $activeSub->plan_name }}</h2>
                <p class="text-gray-400 mt-2 font-bold uppercase tracking-widest text-[10px]">Berlangganan hingga: {{ $activeSub->ends_at?->format('d M Y') }}</p>
                <p class="text-white mt-6 font-black uppercase text-[10px] tracking-[0.3em]">Terima kasih telah mendukung ZESEKAI!</p>
            </div>
        @elseif($pendingSub)
            <div class="bg-yellow-600/10 border border-yellow-600/20 rounded-2xl p-8 mb-16 text-center">
                <i class="bi bi-clock-history text-4xl text-yellow-600 mb-4 inline-block"></i>
                <h2 class="text-2xl font-black text-white uppercase tracking-tighter">Menunggu Pembayaran</h2>
                <p class="text-gray-400 mt-2 font-bold uppercase tracking-widest text-[10px]">Order ID: {{ $pendingSub->reference_id }}</p>
                <div class="mt-8 flex flex-col items-center gap-4">
                    <button wire:click="checkPayment('{{ $pendingSub->reference_id }}')" wire:loading.attr="disabled" class="bg-yellow-600 hover:bg-yellow-700 text-black px-8 py-3 rounded-xl font-black uppercase text-[10px] tracking-widest transition">
                        Konfirmasi Pembayaran Saya
                    </button>
                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">Klik tombol di atas jika Anda sudah membayar tapi status belum berubah.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 opacity-40 pointer-events-none">
                <!-- Free Plan -->
                <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-10 relative overflow-hidden flex flex-col group hover:border-white/10 transition-all duration-500">
                    <div class="relative z-10 flex-1">
                        <h3 class="text-sm font-black text-gray-500 uppercase tracking-widest mb-2">Basic</h3>
                        <div class="flex items-baseline gap-1 mb-8">
                            <span class="text-4xl font-black text-white">IDR 0</span>
                            <span class="text-gray-500 text-xs font-bold uppercase">/selamanya</span>
                        </div>

                        <ul class="space-y-4 mb-10">
                            <li class="flex items-center gap-3 text-xs font-bold text-gray-400 uppercase tracking-wide">
                                <i class="bi bi-check2 text-green-500 text-lg"></i>
                                Kualitas 720p
                            </li>
                            <li class="flex items-center gap-3 text-xs font-bold text-gray-400 uppercase tracking-wide">
                                <i class="bi bi-x-lg text-red-600 text-lg"></i>
                                Iklan (Pop-up & Banner)
                            </li>
                            <li class="flex items-center gap-3 text-xs font-bold text-gray-400 uppercase tracking-wide">
                                <i class="bi bi-x-lg text-red-600 text-lg"></i>
                                Download Anime
                            </li>
                        </ul>
                    </div>
                    <button disabled class="w-full py-4 rounded-2xl bg-white/5 text-gray-600 font-black uppercase text-[10px] tracking-widest">Plan Saat Ini</button>
                </div>

                <!-- Monthly Plan -->
                <div class="bg-[#0a0a0a] border border-red-600/20 rounded-3xl p-10 relative overflow-hidden flex flex-col group hover:border-red-600 hover:-translate-y-2 transition-all duration-500 shadow-2xl shadow-red-900/10">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-red-600/10 blur-[60px] pointer-events-none"></div>
                    <div class="relative z-10 flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-sm font-black text-red-500 uppercase tracking-widest">Monthly</h3>
                            <span class="bg-red-600 text-[8px] font-black text-white px-2 py-0.5 rounded uppercase tracking-widest">Populer</span>
                        </div>
                        <div class="flex items-baseline gap-1 mb-8">
                            <span class="text-4xl font-black text-white italic">IDR 29K</span>
                            <span class="text-gray-500 text-xs font-bold uppercase">/bulan</span>
                        </div>

                        <ul class="space-y-4 mb-10">
                            <li class="flex items-center gap-3 text-xs font-bold text-white uppercase tracking-wide">
                                <i class="bi bi-check2 text-red-600 text-lg"></i>
                                Kualitas Full HD 1080p
                            </li>
                            <li class="flex items-center gap-3 text-xs font-bold text-white uppercase tracking-wide">
                                <i class="bi bi-check2 text-red-600 text-lg"></i>
                                Tanpa Iklan Sama Sekali
                            </li>
                            <li class="flex items-center gap-3 text-xs font-bold text-white uppercase tracking-wide">
                                <i class="bi bi-check2 text-red-600 text-lg"></i>
                                Akses Semua Server Cepat
                            </li>
                            <li class="flex items-center gap-3 text-xs font-bold text-white uppercase tracking-wide">
                                <i class="bi bi-check2 text-red-600 text-lg"></i>
                                Prioritas Request Anime
                            </li>
                        </ul>
                    </div>
                    <button wire:click="subscribe('monthly')" wire:loading.attr="disabled" class="btn-gradient w-full py-4 rounded-2xl text-white font-black uppercase text-[10px] tracking-widest">Pilih Plan Bulanan</button>
                </div>

                <!-- Yearly Plan -->
                <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-10 relative overflow-hidden flex flex-col group hover:border-red-600 transition-all duration-500">
                    <div class="relative z-10 flex-1">
                        <h3 class="text-sm font-black text-gray-500 uppercase tracking-widest mb-2">Yearly (Hemat Pelajar)</h3>
                        <div class="flex items-baseline gap-1 mb-8">
                            <span class="text-4xl font-black text-white italic">IDR 249K</span>
                            <span class="text-gray-500 text-xs font-bold uppercase">/tahun</span>
                        </div>

                        <ul class="space-y-4 mb-10 text-gray-400">
                            <li class="flex items-center gap-3 text-xs font-bold uppercase tracking-wide">
                                <i class="bi bi-check2 text-gray-500 text-lg"></i>
                                Semua Fitur Bulanan
                            </li>
                            <li class="flex items-center gap-3 text-xs font-bold uppercase tracking-wide">
                                <i class="bi bi-check2 text-gray-500 text-lg"></i>
                                Hemat hingga 30%
                            </li>
                            <li class="flex items-center gap-3 text-xs font-bold uppercase tracking-wide">
                                <i class="bi bi-check2 text-gray-500 text-lg"></i>
                                Badge Khusus di Profile
                            </li>
                        </ul>
                    </div>
                    <button wire:click="subscribe('yearly')" wire:loading.attr="disabled" class="w-full py-4 rounded-2xl border border-white/10 hover:bg-white/5 text-white font-black uppercase text-[10px] tracking-widest transition">Pilih Plan Tahunan</button>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Free Plan -->
                <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-10 relative overflow-hidden flex flex-col group hover:border-white/10 transition-all duration-500">
                    <div class="relative z-10 flex-1">
                        <h3 class="text-sm font-black text-gray-500 uppercase tracking-widest mb-2">Basic</h3>
                        <div class="flex items-baseline gap-1 mb-8">
                            <span class="text-4xl font-black text-white">IDR 0</span>
                            <span class="text-gray-500 text-xs font-bold uppercase">/selamanya</span>
                        </div>

                        <ul class="space-y-4 mb-10">
                            <li class="flex items-center gap-3 text-xs font-bold text-gray-400 uppercase tracking-wide">
                                <i class="bi bi-check2 text-green-500 text-lg"></i>
                                Kualitas 720p
                            </li>
                            <li class="flex items-center gap-3 text-xs font-bold text-gray-400 uppercase tracking-wide">
                                <i class="bi bi-x-lg text-red-600 text-lg"></i>
                                Iklan (Pop-up & Banner)
                            </li>
                            <li class="flex items-center gap-3 text-xs font-bold text-gray-400 uppercase tracking-wide">
                                <i class="bi bi-x-lg text-red-600 text-lg"></i>
                                Download Anime
                            </li>
                        </ul>
                    </div>
                    <button disabled class="w-full py-4 rounded-2xl bg-white/5 text-gray-600 font-black uppercase text-[10px] tracking-widest">Plan Saat Ini</button>
                </div>

                <!-- Monthly Plan -->
                <div class="bg-[#0a0a0a] border border-red-600/20 rounded-3xl p-10 relative overflow-hidden flex flex-col group hover:border-red-600 hover:-translate-y-2 transition-all duration-500 shadow-2xl shadow-red-900/10">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-red-600/10 blur-[60px] pointer-events-none"></div>
                    <div class="relative z-10 flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-sm font-black text-red-500 uppercase tracking-widest">Monthly</h3>
                            <span class="bg-red-600 text-[8px] font-black text-white px-2 py-0.5 rounded uppercase tracking-widest">Populer</span>
                        </div>
                        <div class="flex items-baseline gap-1 mb-8">
                            <span class="text-4xl font-black text-white italic">IDR 29K</span>
                            <span class="text-gray-500 text-xs font-bold uppercase">/bulan</span>
                        </div>

                        <ul class="space-y-4 mb-10">
                            <li class="flex items-center gap-3 text-xs font-bold text-white uppercase tracking-wide">
                                <i class="bi bi-check2 text-red-600 text-lg"></i>
                                Kualitas Full HD 1080p
                            </li>
                            <li class="flex items-center gap-3 text-xs font-bold text-white uppercase tracking-wide">
                                <i class="bi bi-check2 text-red-600 text-lg"></i>
                                Tanpa Iklan Sama Sekali
                            </li>
                            <li class="flex items-center gap-3 text-xs font-bold text-white uppercase tracking-wide">
                                <i class="bi bi-check2 text-red-600 text-lg"></i>
                                Akses Semua Server Cepat
                            </li>
                            <li class="flex items-center gap-3 text-xs font-bold text-white uppercase tracking-wide">
                                <i class="bi bi-check2 text-red-600 text-lg"></i>
                                Prioritas Request Anime
                            </li>
                        </ul>
                    </div>
                    <button wire:click="subscribe('monthly')" wire:loading.attr="disabled" class="btn-gradient w-full py-4 rounded-2xl text-white font-black uppercase text-[10px] tracking-widest">Pilih Plan Bulanan</button>
                </div>

                <!-- Yearly Plan -->
                <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-10 relative overflow-hidden flex flex-col group hover:border-red-600 transition-all duration-500">
                    <div class="relative z-10 flex-1">
                        <h3 class="text-sm font-black text-gray-500 uppercase tracking-widest mb-2">Yearly (Hemat Pelajar)</h3>
                        <div class="flex items-baseline gap-1 mb-8">
                            <span class="text-4xl font-black text-white italic">IDR 249K</span>
                            <span class="text-gray-500 text-xs font-bold uppercase">/tahun</span>
                        </div>

                        <ul class="space-y-4 mb-10 text-gray-400">
                            <li class="flex items-center gap-3 text-xs font-bold uppercase tracking-wide">
                                <i class="bi bi-check2 text-gray-500 text-lg"></i>
                                Semua Fitur Bulanan
                            </li>
                            <li class="flex items-center gap-3 text-xs font-bold uppercase tracking-wide">
                                <i class="bi bi-check2 text-gray-500 text-lg"></i>
                                Hemat hingga 30%
                            </li>
                            <li class="flex items-center gap-3 text-xs font-bold uppercase tracking-wide">
                                <i class="bi bi-check2 text-gray-500 text-lg"></i>
                                Badge Khusus di Profile
                            </li>
                        </ul>
                    </div>
                    <button wire:click="subscribe('yearly')" wire:loading.attr="disabled" class="w-full py-4 rounded-2xl border border-white/10 hover:bg-white/5 text-white font-black uppercase text-[10px] tracking-widest transition">Pilih Plan Tahunan</button>
                </div>
            </div>
        @endif

        <!-- FAQ/Info -->
        <div class="mt-24 max-w-2xl mx-auto text-center">
            <h3 class="text-xl font-black uppercase tracking-tight text-white mb-6">Metode Pembayaran</h3>
            <div class="flex flex-wrap justify-center gap-8 opacity-40">
                <i class="bi bi-qr-code-scan text-4xl" title="QRIS"></i>
                <i class="bi bi-wallet2 text-3xl" title="DANA/OVO/GoPay"></i>
                <i class="bi bi-bank text-3xl" title="Transfer Bank"></i>
            </div>
            <p class="mt-8 text-xs font-bold text-gray-600 uppercase tracking-widest leading-relaxed">Setelah melakukan pembayaran, mohon hubungi Admin via WhatsApp atau Telegram dengan menyertakan bukti transfer untuk aktivasi instan.</p>
        </div>
    </div>

    @push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            console.log('Livewire Navigated - Ready for Snap');
        });

        window.addEventListener('payWithSnap', event => {
            console.log('Event payWithSnap received');
            const snapToken = event.detail[0] || event.detail;
            console.log('Token:', snapToken);
            
            if (!window.snap) {
                console.error('Midtrans Snap is not loaded!');
                alert('Gagal memuat sistem pembayaran. Silakan refresh halaman.');
                return;
            }

            window.snap.pay(snapToken, {
                onSuccess: function(result) {
                    console.log('success');
                    window.location.href = "{{ route('home') }}";
                },
                onPending: function(result) {
                    console.log('pending');
                    window.location.href = "{{ route('home') }}";
                },
                onError: function(result) {
                    console.error('Payment Error:', result);
                    alert("Pembayaran Gagal!");
                },
                onClose: function() {
                    console.log('customer closed the popup without finishing the payment');
                }
            });
        });
    </script>
    @endpush
</div>
