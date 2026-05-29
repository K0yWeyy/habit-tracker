{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Habit Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-timetable-64.png') }}">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg mb-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <a href="{{ route('habits.index') }}" class="py-4 px-2 text-gray-700 font-semibold">Habit Tracker</a>
                    <a href="{{ route('habits.history') }}" class="py-4 px-2 text-gray-500 hover:text-gray-700">History</a>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="py-2 px-3 text-sm text-gray-500 hover:text-gray-700">Keluar</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mx-auto px-4 max-w-4xl">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </div>
</body>
</html>