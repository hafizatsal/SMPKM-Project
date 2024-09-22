<x-guest-layout>
    <div class="flex justify-center items-center h-screen">
        <!-- Card Utama dengan ukuran lebih lebar -->
        <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-lg"> <!-- Ukuran card diatur -->
            
            <!-- Logo SMANSAKA -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('assets/img/logo-smansaka.png') }}" alt="Logo SMANSAKA" class="h-24 w-auto" />
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Pengecekan apakah pengguna sudah login -->
            @if(Auth::check())
                <div class="text-center mb-4">
                    <p class="text-lg font-medium">Anda sudah login sebagai {{ Auth::user()->email }}</p>
                </div>
            @else
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full h-12" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full h-12" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mb-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <!-- Tombol Log in dan Buat Akun -->
                    <div class="flex items-center justify-between mt-4">
                        <a href="/home" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-500">
                            {{ __('Masuk sebagai Tamu') }}
                        </a>

                        <div class="flex">
                            @if(App\Models\User::count() === 0)
                                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-md hover:bg-green-500 mr-2">
                                    {{ __('Buat Akun') }}
                                </a>
                            @endif

                            <x-primary-button class="h-12">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-guest-layout>
<x-guest-layout>
    <div class="flex justify-center items-center h-screen">
        <!-- Card Utama dengan ukuran lebih lebar -->
        <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-lg"> <!-- Ukuran card diatur -->
            
            <!-- Logo SMANSAKA -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('assets/img/logo-smansaka.png') }}" alt="Logo SMANSAKA" class="h-24 w-auto" />
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Pengecekan apakah pengguna sudah login -->
            @if(Auth::check())
                <div class="text-center mb-4">
                    <p class="text-lg font-medium">Anda sudah login sebagai {{ Auth::user()->email }}</p>
                </div>
            @else
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full h-12" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full h-12" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mb-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <!-- Tombol Log in dan Buat Akun -->
                    <div class="flex items-center justify-between mt-4">
                        <a href="/home" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-500">
                            {{ __('Masuk sebagai Tamu') }}
                        </a>

                        <div class="flex">
                            @if(App\Models\User::count() === 0)
                                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-md hover:bg-green-500 mr-2">
                                    {{ __('Buat Akun') }}
                                </a>
                            @endif

                            <x-primary-button class="h-12">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-guest-layout>
