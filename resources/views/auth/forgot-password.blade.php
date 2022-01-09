<x-guest-layout>
    <x-auth-card>
        <h2 class="text-center font-semibold text-lg text-gray-800 pt-8 pb-5 leading-tight">パスワード再設定</h2>
        <div class="mt-4 mb-4 text-sm text-gray-900">
            {{ __('パスワードをお忘れですか？メールアドレスをお知らせいただければ、パスワードリセットメールをお送りします。') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <!-- Email Address -->
            <div>
                <x-input id="email" class="block mt-1 w-full bg-gray-100 border-solid border-2 border-gray-600 text-xs leading-8 pl-3" type="email" name="email" placeholder="メールアドレス" :value="old('email')" required autofocus/>
            </div>

            <div class="mt-5">
                <x-button class="w-full flex justify-center bg-blue-700 hover:bg-blue-500">
                    {{ __('パスワードリセットメール送信') }}
                </x-button>
            </div>
            <div class="mt-5 flex flex-col">
                <p class="text-xs text-center">アカウントをお持ちの方はこちらから</p>
                <a class="text-xs text-center text-blue-700 hover:text-blue-500" href="{{ route('login') }}">
                    {{ __('ログイン') }}
                </a>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
