<x-guest-layout>
    <x-auth-card>
        <h2 class="text-center font-semibold text-lg text-gray-800 pt-8 pb-5 leading-tight">ログイン</h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
            <div>
                <x-input id="email" class="block mt-1 w-full bg-gray-100 border-solid border-2 border-gray-600 text-xs leading-8 pl-3" type="email" name="email" placeholder="メールアドレス" :value="old('email')" required autofocus/>
            </div>

        <!-- Password -->
            <div class="mt-5">
                <x-input id="password" class="block mt-1 w-full bg-gray-100 border-solid border-2 border-gray-600 text-xs leading-8 pl-3"
                         type="password"
                         name="password"
                         placeholder="パスワード"
                         required autocomplete="current-password"/>
            </div>


            <div class="flex items-center mt-5">
                <x-button class="w-full flex justify-center bg-blue-700 hover:bg-blue-500">
                    {{ __('ログイン') }}
                </x-button>
            </div>
            <div class="mt-5 flex flex-col">
                @if (Route::has('password.request'))
                    <p class="text-xs text-center">アカウントをお持ちでない方はこちらから</p>
                    <a class="text-xs text-center text-blue-700 hover:text-blue-500" href="{{ route('register') }}">
                        {{ __('会員登録') }}
                    </a>

        <!-- Forgot your password?  -->
                    <p class="text-xs text-center mt-5">パスワードを忘れた方はこちらから</p>
                    <a class="text-xs text-center text-blue-700 hover:text-blue-500" href="{{ route('password.request') }}">
                        {{ __('パスワード再発行') }}
                    </a>
                @endif
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
