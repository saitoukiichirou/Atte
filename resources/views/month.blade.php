<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <h2 class="font-semibold text-xl text-gray-800 py-6 leading-tight">
        <div class="text-center text-base sm:text-lg">
            <p class="mb-3">{{$user_name}}さんの月別勤実績一覧</p>
            <a class="bg-white text-blue-500 border border-blue-500 px-2 mr-3 hover:text-blue-300" href="/users/{{$user_id}}/{{$param_month->subMonth()->format('Y-m')}}"><</a>
            {{ $param_month->addMonth()->format('Y-m') }}
            <a class="bg-white text-blue-500 border border-blue-500 px-2 ml-3 hover:text-blue-300" href="/users/{{$user_id}}/{{$param_month->addMonth()->format('Y-m')}}">></a>
        </div>
    </h2>

    <div class="mb-5 text-sm  sm:text-base">
        <table class="w-5xl flex justify-center">
            <tr class=" text-left border-t border-gray-400">
                <th class="w-32">
                    <p class="p-3">月日</p>
                </th>
                <th class="w-20 sm:w-32">
                    <p class="p-1 sm:p-3">勤務開始</p>
                    <p class="p-1 sm:hidden">勤務終了</p>
                </th>
                <th class="hidden w-20 sm:flex w-32">
                    <p class="p-3">勤務終了</p>
                </th>
                <th class="w-20 sm:w-32">
                    <p class="p-1 sm:p-3">休憩時間</p>
                    <p class="p-1 sm:hidden">勤務時間</p>
                </th class="w-20 sm:w-32">
                <th class="hidden sm:flex w-32">
                    <p class="p-3">勤務時間</p>
                </th>
            </tr>
            @foreach ($attendances_user_month as $attendance)
                <tr class="flex justify-center border-t border-gray-400">
                    <td class="max-w-48 w-32">
                        <p class="p-3 pr-0">{{$attendance->date}}</p>
                    </td>
                    <td class="w-20 sm:w-32">
                        <p class="w-20 p-2 pl-1 sm:p-3">{{$attendance->start_time}}</p>
                        <p class="w-20 p-2 pt-0 pl-1 sm:hidden">{{$attendance->end_time ?? '--:--:--'}}</p>
                    </td>
                    <td class="hidden sm:flex w-32">
                        <p class="p-0 sm:p-3">{{$attendance->end_time ?? '--:--:--'}}</p>
                    </td>
                    <td class="w-20 sm:w-32">
                        <p class="w-20 p-2 pl-1 sm:p-3">{{gmdate('H:i:s', $attendance->rest_time)}}</p>
                        <p class="w-20 p-2 pt-0 pl-1 sm:hidden">{{gmdate('H:i:s', $attendance->working_time)}}</p>
                    </td>
                    <td class="hidden sm:flex w-32">
                        <p class="p-0 sm:p-3">{{gmdate('H:i:s', $attendance->working_time)}}</p>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="mb-6 flex justify-center">
        {{ $attendances_user_month->links() }}
    </div>
</x-app-layout>

