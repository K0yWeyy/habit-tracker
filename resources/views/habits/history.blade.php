{{-- resources/views/habits/history.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h1 class="text-2xl font-bold mb-4">Riwayat Progress</h1>
    
    {{-- Weekly Overview --}}
    <div class="mb-8">
        <h2 class="text-lg font-semibold mb-3">7 Hari Terakhir</h2>
        <div class="grid grid-cols-7 gap-2">
            @foreach($weeklyStats as $date => $stat)
            <div class="text-center">
                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($date)->format('D') }}</div>
                <div class="text-sm font-medium">{{ \Carbon\Carbon::parse($date)->format('d/m') }}</div>
                <div class="mt-1 text-sm font-bold 
                    @if($stat['percentage'] >= 80) text-green-600
                    @elseif($stat['percentage'] >= 50) text-yellow-600
                    @else text-red-600 @endif">
                    {{ $stat['percentage'] }}%
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $stat['percentage'] }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    {{-- Per Habit Statistics --}}
    <div class="mb-8">
        <h2 class="text-lg font-semibold mb-3">Statistik per Habit</h2>
        <div class="space-y-3">
            @foreach($habitStats as $stat)
            <div class="p-3 border rounded-lg">
                <div class="flex justify-between mb-1">
                    <span class="font-medium">{{ $stat['name'] }}</span>
                    <span class="text-sm">{{ $stat['completed_days'] }}/{{ $stat['total_days'] }} ({{ $stat['percentage'] }}%)</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $stat['percentage'] }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    {{-- Daily History --}}
    <div>
        <h2 class="text-lg font-semibold mb-3">Histori Harian</h2>
        <div class="space-y-4">
            @forelse($logs as $date => $dailyLogs)
            <div class="border rounded-lg overflow-hidden">
                <div class="bg-gray-50 px-4 py-2 border-b flex justify-between">
                    <span class="font-medium">{{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}</span>
                    <span class="text-sm {{ $dailyStats[$date]['percentage'] >= 70 ? 'text-green-600' : 'text-yellow-600' }}">
                        {{ $dailyStats[$date]['percentage'] }}% selesai
                    </span>
                </div>
                <div class="p-3">
                    <div class="flex flex-wrap gap-2">
                        @foreach($dailyLogs as $log)
                        <div class="flex items-center gap-1 px-2 py-1 rounded-full text-sm
                            {{ $log->completed ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            <span>{{ $log->completed ? '✓' : '✗' }}</span>
                            <span>{{ $log->habit->name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-center py-8">Belum ada data history</p>
            @endforelse
        </div>
    </div>
</div>
@endsection