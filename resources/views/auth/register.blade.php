<x-guest-layout>

    <x-auth-card>
        <h2 class="text-center font-semibold text-lg text-gray-800 pt-8 pb-5 leading-tight">会員登録</h2>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
            <div class="">
                <x-input id="name" class="block mt-1 w-full bg-gray-100 border-solid border-2 border-gray-600 text-xs leading-8 pl-3" type="text" name="name" placeholder="名前" :value="old('name')" required autofocus/>
            </div>

            <!-- Email Address -->
            <div class="mt-5">
                <x-input id="email" class="block mt-1 w-full bg-gray-100 border-solid border-2 border-gray-600 text-xs leading-8 pl-3" type="email" name="email" placeholder="メールアドレス" :value="old('email')" required/>
            </div>

            <!-- Password -->
            <div class="mt-5">
                <x-input id="password" class="block mt-1 w-full bg-gray-100 border-solid border-2 border-gray-600 text-xs leading-8 pl-3"
                         type="password"
                         name="password"
                         placeholder="パスワード"
                         required autocomplete="new-password"/>
            </div>

            <!-- Confirm Password -->
            <div class="mt-5">
                <x-input id="password_confirmation" class="block mt-1 w-full bg-gray-100 border-solid border-2 border-gray-600 text-xs leading-8 pl-3"
                         type="password"
                         name="password_confirmation"
                         placeholder="確認用パスワード"
                         required/>
            </div>

            <div class="flex items-center mt-5">
                <x-button class="w-full flex justify-center bg-blue-700 hover:bg-blue-500">
                    {{ __('会員登録') }}
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
