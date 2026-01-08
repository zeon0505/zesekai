<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <div class="w-1 h-12 bg-red-600 rounded-full"></div>
            <div>
                <h2 class="text-3xl font-black uppercase tracking-tighter text-white">Profile Settings</h2>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Manage your account information</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Update Profile Info -->
            <div class="p-8 bg-[#0a0a0a] border border-white/5 rounded-2xl shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-red-600/5 blur-[50px] -z-0"></div>
                <div class="relative z-10">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <!-- Update Password -->
            <div class="p-8 bg-[#0a0a0a] border border-white/5 rounded-2xl shadow-2xl relative overflow-hidden">
                 <div class="absolute bottom-0 left-0 w-32 h-32 bg-blue-600/5 blur-[50px] -z-0"></div>
                 <div class="relative z-10">
                    <livewire:profile.update-password-form />
                 </div>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="p-8 bg-[#0a0a0a] border border-white/5 rounded-2xl shadow-2xl relative overflow-hidden">
             <div class="relative z-10">
                <livewire:profile.delete-user-form />
             </div>
        </div>
    </div>
</div>
