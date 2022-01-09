<x-guest-layout>
    <x-auth-card>
        <h2 class="text-center font-semibold text-lg text-gray-800 pt-8 pb-5 leading-tight">仮登録完了</h2>
        <div class="mt-4 mb-4 text-sm text-gray-900">
            {{ __('ご登録いただきありがとうございます！入力いただいたメールアドレス宛に送信したリンクをクリックして登録を完了してください。メールが届かない場合は、下のボタンを押していただければ再度確認メールをお送りします。') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mt-4 mb-4 font-medium text-sm text-green-600">
                {{ __('登録時に指定したメールアドレス宛に新しい確認リンクが送信されました。') }}
            </div>
        @endif

        <div class="mt-4 flex justify-center">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button class="w-full flex bg-blue-700 hover:bg-blue-500">
                        {{ __('確認メールを再送信する') }}
                    </x-button>
                </div>
            </form>
        </div>

        <div class="mt-4 flex justify-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="text-xs text-center text-gray-900 hover:text-gray-700">
                    {{ __('ログアウト') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
