<x-guest-layout>
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white shadow-md rounded-lg p-6 w-1/2 max-w-lg">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('assets/img/logo-smansaka.png') }}" alt="Logo SMANSAKA" class="h-24 w-auto" />
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="mb-4 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
