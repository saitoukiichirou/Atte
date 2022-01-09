<x-guest-layout>
    <x-auth-card>
        <h2 class="text-center font-semibold text-lg text-gray-800 pt-8 pb-5 leading-tight">パスワード再設定</h2>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-input id="email" class="block mt-1 w-full bg-gray-100 border-solid border-2 border-gray-600 text-xs leading-8 pl-3" type="email" name="email" placeholder="登録済みのメールアドレスを入力" :value="old('email', $request->email)" required autofocus/>

            </div>

            <!-- Password -->
            <div class="mt-5">
                <x-input id="password" class="block mt-1 w-full bg-gray-100 border-solid border-2 border-gray-600 text-xs leading-8 pl-3"
                         type="password"
                         name="password"
                         placeholder="新しいパスワードを入力"
                         required autocomplete="new-password"/>
            </div>

            <!-- Confirm Password -->
            <div class="mt-5">
                <x-input id="password_confirmation" class="block mt-1 w-full bg-gray-100 border-solid border-2 border-gray-600 text-xs leading-8 pl-3"
                         type="password"
                         name="password_confirmation"
                         placeholder="新しいパスワード確認をもう一度入力"
                         required/>
            </div>

            <div class="flex items-center mt-5">
                <x-button class="w-full flex justify-center bg-blue-700 hover:bg-blue-500">
                    {{ __('パスワード再設定') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
