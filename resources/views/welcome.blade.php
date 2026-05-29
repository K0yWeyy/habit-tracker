{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habit Tracker - Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            overflow: hidden; /* Mencegah scroll */
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 h-screen overflow-hidden">
    <div class="container mx-auto px-4 h-full flex items-center justify-center">
        <div class="max-w-4xl w-full text-center">
            {{-- Logo/Icon --}}
            <div class="mb-6">
                <div class="text-7xl mb-3 animate-bounce">🎯</div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Habit Tracker</h1>
                <p class="text-lg text-gray-600">Bangun kebiasaan baik, lacak progressmu setiap hari!</p>
            </div>
            
            {{-- Features - Grid 2x2 untuk 4 item --}}
            <div class="grid grid-cols-2 gap-4 mb-8 max-w-3xl mx-auto">
                <div class="bg-white/50 backdrop-blur-sm rounded-xl p-3">
                    <div class="text-2xl mb-1">🫵🏻</div>
                    <h3 class="font-semibold text-gray-800 text-sm">Simple Goals</h3>
                    <p class="text-xs text-gray-600">dopamin memerlukan reward yang besar</p>
                </div>
                <div class="bg-white/50 backdrop-blur-sm rounded-xl p-3">
                    <div class="text-2xl mb-1">🏃</div>
                    <h3 class="font-semibold text-gray-800 text-sm">Execution</h3>
                    <p class="text-xs text-gray-600">Enjoy the process!</p>
                </div>
                <div class="bg-white/50 backdrop-blur-sm rounded-xl p-3">
                    <div class="text-2xl mb-1">🗣️</div>
                    <h3 class="font-semibold text-gray-800 text-sm">Konsisten</h3>
                    <p class="text-xs text-gray-600">apapun yang terjadi saya harus bisa melakukannya</p>
                </div>
                <div class="bg-white/50 backdrop-blur-sm rounded-xl p-3">
                    <div class="text-2xl mb-1">🏆</div>
                    <h3 class="font-semibold text-gray-800 text-sm">Succeed</h3>
                    <p class="text-xs text-gray-600">gw bakal paham setelah reward yang besar itu telah datang</p>
                </div>
            </div>
            
            {{-- Button --}}
            <a href="{{ route('habits.index') }}" 
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-xl text-lg transition-all transform hover:scale-105 shadow-lg">
                Come on in 🚀
            </a>
            
            {{-- Footer --}}
            <p class="mt-6 text-xs text-gray-500">Mulai kebiasaan baikmu dari hari ini</p>
        </div>
    </div>
</body>
</html>