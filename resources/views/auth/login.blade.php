<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ $value }}
        </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <div class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </div>

                @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 hover:text-gray-900 underline" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif
            </div>

            <div class="flex justify-end mt-4">
                <x-button class="w-1/5">
                    {{ __('Log in') }}
                </x-button>
            </div>

            <div class="mt-2">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or sign in with</span>
                    </div>
                </div>

                <div class="mt-6 flex justify-between gap-4">
                    <a href="{{ route('auth.google') }}" class="flex items-center justify-center px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-300 w-full sm:w-auto">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="h-5 w-5 mr-2">
                        <span class="text-sm font-medium text-gray-700">Google</span>
                    </a>
                    <a href="{{ route('auth.facebook') }}" class="flex items-center justify-center px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-300 w-full sm:w-auto">
                        <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" alt="Facebook" class="h-5 w-5 mr-2">
                        <span class="text-sm font-medium text-gray-700">Facebook</span>
                    </a>
                </div>

            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>