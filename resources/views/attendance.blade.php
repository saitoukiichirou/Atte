{{--ダッシュボードのビューをコピーしただけ--}}
{{--全然未完成・未着手--}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    ログインしました
                    @if (Session::has('start'))
                        <p>勤怠番号は{{ session('start') }}です</p>
                    @endif
                    @if (Session::has('message'))
                        <p>{{ session('message') }}</p>
                    @endif
                </div>
                <div>
                </div>

                {{--                出退勤　　　　　　　--}}
                <div>
                    <form action="/punchin" method="post">
                        @csrf
                        {{--                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">--}}
                        {{--                        <input type="hidden" name="date" value="">--}}
                        <button name="" value="">[出勤]</button>
                        {{--                        <button name="start_time" value="{{Auth::user()->id}}">[出勤]</button>--}}

                    </form>
                </div>
                <div>
                    <form action="/punchout" method="post">
                        @csrf
                        <button name="punchout" value="">[退勤]</button>
                    </form>
                </div>

                {{--                休憩　　　　　　　　　--}}
                <div>
                    {{--                    <div>{{Attendance::id()->id }}</div>--}}
                    {{--                    @foreach($item1)--}}
                    {{--                    <form action="{{ route('restin')}}" method="post">--}}
                    <form action="/restin" method="post">
                        @csrf
                        {{--                        <button name="start" value="">[休憩開始]</button>--}}
                        <button name="start" value="">[休憩開始]</button>
                    </form>
                    {{--                        @endforeach--}}
                </div>
                <div>
                    <form action="/restout" method="post">
                        @csrf
                        <button name="punchout" value="">[休憩終了]</button>
                    </form>
                </div>
                <div>
                    {{--                    <ul>--}}
                    {{--                        @foreach($test as $v)--}}
                    {{--                            <li><a href="#">{{$test}}</a></li>--}}
                    {{--                        @endforeach--}}
                    {{--                    </ul>--}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
