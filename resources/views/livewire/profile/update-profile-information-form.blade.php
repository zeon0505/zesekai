<section>
    <header>
        <h2 class="text-lg font-black uppercase tracking-tight text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-[10px] uppercase tracking-widest text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6" enctype="multipart/form-data">
        
        <!-- Profile Photo -->
        <div class="flex items-center gap-6">
            <div class="shrink-0 relative">
                @if ($photo)
                    <img src="{{ $photo->temporaryUrl() }}" class="object-cover w-20 h-20 rounded-full border-2 border-white/20">
                @elseif (auth()->user()->profile_photo_path)
                    <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" class="object-cover w-20 h-20 rounded-full border-2 border-white/20">
                @else
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-gray-800 to-black border-2 border-white/20 flex items-center justify-center font-bold text-xl text-white">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                
                <label for="photo" class="absolute bottom-0 right-0 bg-red-600 p-1.5 rounded-full text-white cursor-pointer hover:bg-red-700 transition shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <input type="file" id="photo" wire:model="photo" class="hidden" accept="image/*">
                </label>
            </div>
            
            <div class="flex-1">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
            </div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-400">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-400 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
