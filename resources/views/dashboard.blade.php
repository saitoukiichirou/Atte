<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center pt-6">
        {{ Auth::user()->name }}さんお疲れ様です！
        @if (Session::has('message'))
            <p class="h-3 text-sm mt-2">{{ session('message') }}</p>
        @else
            <p class="h-3 text-sm mt-2"> </p>
        @endif
    </h2>

    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center">

            {{--                出退勤　　　　　 　　--}}
            <form class=" w-2/5 m-1 mt-3 sm:m-5" action="/punchin" method="post">
                @csrf
                @if($attendance_status == 11 )
                    <button class="bg-white w-full py-8 text-xl text-gray-800 rounded text-center sm:py-16">
                        勤務開始
                    </button>
                @else
                    <button class="bg-white w-full py-8 text-xl text-gray-200 rounded text-center  cursor-not-allowed sm:py-16" disabled>
                        勤務開始
                    </button>
                @endif
            </form>

            <form class="w-2/5 m-1 mt-3 sm:m-5" action="/punchout" method="post">
                @csrf
                @if($attendance_status >= 12)
                    @if($rest_status == 21)
                    <button class="bg-white w-full py-8 text-xl text-gray-800 rounded text-center sm:py-16">
                        勤務終了
                    </button>
                    @else
                        <button class="bg-white w-full py-8 text-xl text-gray-200 rounded text-center cursor-not-allowed sm:py-16" disabled>
                            勤務終了
                        </button>
                    @endif
                @else
                    <button class="bg-white w-full py-8 text-xl text-gray-200 rounded text-center cursor-not-allowed sm:py-16" disabled>
                        勤務終了
                    </button>
                @endif
            </form>
        </div>

        {{--                休憩　　　　　　　　　--}}
        @if($attendance_status > 11)
            <div class="flex justify-center">
                <form class="w-2/5 m-1 sm:m-5" action="/restin" method="post">
                    @csrf
                    @if($rest_status == 21)
                        <button class="bg-white w-full py-8 text-xl text-gray-800 rounded text-center sm:py-16" >
                            <div>
                                休憩開始
                            </div>
                        </button>
                    @else
                        <button class="bg-white w-full py-8 text-xl text-gray-200 rounded text-center cursor-not-allowed sm:py-16" disabled>
                            <div>
                                休憩開始
                            </div>
                        </button>
                    @endif
                </form>
                <form class="w-2/5 m-1 sm:m-5" action="/restout" method="post">
                    @csrf
                    @if($rest_status == 22)
                        <button class="bg-white w-full py-8 text-xl text-gray-800 rounded text-center sm:py-16">
                            <div>
                                休憩終了
                            </div>
                    @else
                        <button class="bg-white w-full py-8 text-xl text-gray-200 rounded text-center cursor-not-allowed sm:py-16" disabled>
                            <div>
                                休憩終了
                            </div>
                        </button>
                    @endif
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
