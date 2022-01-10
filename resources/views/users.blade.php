<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <h2 class="font-semibold text-xl text-gray-800 py-6 leading-tight">
        <div class="text-center text-base sm:text-lg">
            <p class="">登録ユーザー一覧</p>
        </div>
    </h2>

    <div class="mb-5 text-sm  sm:text-base">
        <table class="w-5xl flex justify-center">
            <tr class="text-left border-t border-gray-400">
                <th class="w-32 md:w-10">
                    <p class="p-1 pl-3 md:p-3">id</p>
                    <p class="p-1 pl-3 md:hidden">名前</p>
                </th>
                <th class="hidden md:flex w-40">
                    <p class="p-3">名前</p>
                </th>
                <th class="w-48">
                    <p class="p-1 md:p-3">登録日時</p>
                    <p class="p-1 md:hidden">メールアドレス</p>
                </th>
                <th class="hidden md:flex w-64">
                    <p class="p-3">メールアドレス</p>
                </th>
            </tr>
            @foreach ($users as $user)
                <tr class="flex justify-center border-t border-gray-400">
                    <td class="w-32 md:w-10">
                        <p class="p-1 pl-3 md:p-3">{{$user->id}}</p>
                        <a href="/users/{{$user->id}}">
                            <p class="p-1 text-blue-500 hover:text-blue-700 md:hidden">{{$user->name}}</p>
                        </a>
                    </td>
                    <td class="hidden md:flex w-40">
                        <a href="/users/{{$user->id}}">
                            <p class="p-3 text-blue-500 hover:text-blue-700">{{$user->name}}</p>
                        </a>
                    </td>
                    <td>
                        <p class="w-48 p-2 pl-1 md:p-3">{{$user->created_at}}</p>
                        <a href="mailto:{{$user->email}}">
                            <p class="truncate w-48 p-2 pt-0 pl-1 text-blue-500 hover:text-blue-700 md:hidden">{{$user->email}}</p>
                        </a>
                    </td>
                    <td class="hidden md:flex w-64">
                        <a href="mailto:{{$user->email}}">
                            <p class="truncate w-64 p-0 pt-0 pl-1 text-blue-500 hover:text-blue-700 md:p-3">{{$user->email}}</p>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="mb-6 flex justify-center">
        {{ $users->links() }}
    </div>
</x-app-layout>
