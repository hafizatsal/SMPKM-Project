<x-guest-layout>
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white border border-black shadow-md rounded-lg p-8 w-full max-w-lg">
            <!-- Logo SMANSAKA -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('assets/img/logo-smansaka.png') }}" alt="Logo SMANSAKA" class="h-24 w-auto" />
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4 relative">
                    <x-input-label for="password" :value="__('Password')" />
                    <div class="flex items-center">
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <span class="absolute right-3 cursor-pointer" onclick="togglePasswordVisibility()">
                            <i id="password-eye" class="fas fa-eye"></i>
                        </span>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4 relative">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <div class="flex items-center">
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <span class="absolute right-3 cursor-pointer" onclick="toggleConfirmPasswordVisibility()">
                            <i id="confirm-password-eye" class="fas fa-eye"></i>
                        </span>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>

            <script>
                function togglePasswordVisibility() {
                    const passwordInput = document.getElementById('password');
                    const passwordEye = document.getElementById('password-eye');
                    passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
                    passwordEye.classList.toggle('fa-eye');
                    passwordEye.classList.toggle('fa-eye-slash');
                }

                function toggleConfirmPasswordVisibility() {
                    const confirmPasswordInput = document.getElementById('password_confirmation');
                    const confirmPasswordEye = document.getElementById('confirm-password-eye');
                    confirmPasswordInput.type = confirmPasswordInput.type === 'password' ? 'text' : 'password';
                    confirmPasswordEye.classList.toggle('fa-eye');
                    confirmPasswordEye.classList.toggle('fa-eye-slash');
                }
            </script>
        </div>
    </div>
</x-guest-layout>
