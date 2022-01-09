<div class="min-h-screen flex-col justify-center sm: bg-gray-100">
    <div class="bg-white">
        <div class="max-w-5xl mx-auto flex-shrink-0 flex items-center pl-5" style="font-size: 30px">
            <a href="{{ route('dashboard') }}">
                Atte
            </a>
        </div>
    </div>
    <div class="w-64 mx-auto">
        {{ $slot }}
    </div>
</div>
