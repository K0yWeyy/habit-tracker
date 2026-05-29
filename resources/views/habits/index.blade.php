{{-- resources/views/habits/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Hari Ini</h1>
        <div class="text-right">
            <div class="text-sm text-gray-500">Progress Hari Ini</div>
            <div class="text-3xl font-bold text-blue-600">{{ $todayPercentage }}%</div>
        </div>
    </div>
    
    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-6">
        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $todayPercentage }}%"></div>
    </div>
    
    <div class="space-y-3">
@foreach($habits as $habit)
<div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50">
    <div class="flex items-center gap-3">
        <span class="text-2xl">{{ $habit->icon ?? '📌' }}</span>
        <span class="font-medium">
            {{ $habit->name }}
            @if(!$habit->is_permanent)
            <span class="text-xs text-gray-400 ml-2">(sementara - hanya hari ini)</span>
            @endif
        </span>
    </div>
    <button onclick="toggleHabit({{ $habit->id }})" 
            class="habit-checkbox-{{ $habit->id }} w-6 h-6 rounded border-2 transition-all flex items-center justify-center text-white font-bold text-sm
                   {{ isset($todayLogs[$habit->id]) && $todayLogs[$habit->id] ? 'bg-green-500 border-green-500' : 'border-gray-300 hover:border-green-400' }}">
        @if(isset($todayLogs[$habit->id]) && $todayLogs[$habit->id])
        ✓
        @endif
    </button>
</div>
@endforeach
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-4">Tambah Habit Baru</h2>
    <form action="{{ route('habits.store') }}" method="POST" class="flex gap-2">
        @csrf
        <input type="text" name="name" required placeholder="Nama habit..." 
               class="flex-1 border rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
            Tambah
        </button>
    </form>
</div>

<script>
function toggleHabit(habitId) {
    $.ajax({
        url: `/app/habits/${habitId}/toggle`,  // <-- TAMBAHKAN /app/
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.completed) {
                $(`.habit-checkbox-${habitId}`).addClass('bg-green-500 border-green-500').html('✓');
            } else {
                $(`.habit-checkbox-${habitId}`).removeClass('bg-green-500 border-green-500').html('');
            }
            location.reload(); // Refresh untuk update percentage
        },
        error: function(xhr) {
            console.log('Error:', xhr.responseText); // Tambahkan ini untuk debugging
            alert('Terjadi kesalahan, cek console browser');
        }
    });
}
</script>
@endsection