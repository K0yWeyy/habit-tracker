{{-- resources/views/habits/history.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    .section-card {
        background: #161618;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 20px;
        padding: 1.75rem 2rem;
        margin-bottom: 1.25rem;
        position: relative;
        overflow: hidden;
    }
    .section-card::before {
        content: '';
        position: absolute;
        top: -50px; right: -50px;
        width: 180px; height: 180px;
        background: radial-gradient(circle, rgba(240,168,66,0.08) 0%, transparent 70%);
        pointer-events: none;
    }
    .page-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.8rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: #f5f0e8;
        margin-bottom: 0.25rem;
    }
    .page-subtitle {
        font-size: 0.825rem;
        color: rgba(232,228,220,0.35);
        margin-bottom: 2rem;
    }
    .section-title {
        font-family: 'Syne', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: #e8e4dc;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(255,255,255,0.06);
    }
    .section-divider {
        height: 1px;
        background: rgba(255,255,255,0.06);
        margin: 2rem 0;
    }

    /* Weekly grid */
    .week-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
    }
    .week-day {
        text-align: center;
    }
    .week-day-name {
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: rgba(232,228,220,0.3);
        margin-bottom: 4px;
    }
    .week-day-date {
        font-size: 0.7rem;
        color: rgba(232,228,220,0.4);
        margin-bottom: 6px;
    }
    .week-day-pct {
        font-family: 'Syne', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 6px;
    }
    .pct-high { color: #97c459; }
    .pct-mid  { color: #f0a842; }
    .pct-low  { color: #e24b4a; }

    .week-bar-track {
        height: 48px;
        background: rgba(255,255,255,0.05);
        border-radius: 4px;
        overflow: hidden;
        display: flex;
        align-items: flex-end;
    }
    .week-bar-fill {
        width: 100%;
        border-radius: 4px 4px 0 0;
        transition: height 0.5s cubic-bezier(0.4,0,0.2,1);
    }
    .bar-high { background: linear-gradient(to top, #3b6d11, #97c459); }
    .bar-mid  { background: linear-gradient(to top, #854f0b, #f0a842); }
    .bar-low  { background: linear-gradient(to top, #a32d2d, #e24b4a); }

    /* Habit stats */
    .stat-row {
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .stat-row:last-child { border-bottom: none; }
    .stat-row-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }
    .stat-habit-name {
        font-size: 0.875rem;
        font-weight: 500;
        color: #e8e4dc;
    }
    .stat-count {
        font-family: 'Syne', sans-serif;
        font-size: 0.8rem;
        font-weight: 700;
        color: rgba(232,228,220,0.4);
    }
    .stat-bar-track {
        height: 4px;
        background: rgba(255,255,255,0.07);
        border-radius: 999px;
        overflow: hidden;
    }
    .stat-bar-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #3b6d11 0%, #97c459 100%);
    }

    /* Daily history - Today only */
    .day-block {
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 0.75rem;
        transition: border-color 0.2s;
    }
    .day-block:hover { border-color: rgba(240,168,66,0.15); }
    .day-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1.1rem;
        background: rgba(255,255,255,0.03);
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .day-date {
        font-family: 'Syne', sans-serif;
        font-size: 0.825rem;
        font-weight: 700;
        color: #e8e4dc;
    }
    .day-pct-badge {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.2rem 0.6rem;
        border-radius: 999px;
    }
    .badge-good { background: rgba(59,109,17,0.25); color: #97c459; }
    .badge-mid  { background: rgba(133,79,11,0.25); color: #f0a842; }
    .badge-low  { background: rgba(163,45,45,0.25); color: #e24b4a; }
    .day-habits {
        padding: 0.75rem 1.1rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
    }
    .habit-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .tag-done {
        background: rgba(59,109,17,0.2);
        color: #a3c96b;
        border: 1px solid rgba(99,153,34,0.2);
    }
    .tag-miss {
        background: rgba(163,45,45,0.12);
        color: rgba(226,75,74,0.7);
        border: 1px solid rgba(163,45,45,0.15);
    }

    /* Empty */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: rgba(232,228,220,0.2);
        font-size: 0.9rem;
    }

    /* Mobile specific for history page */
@media (max-width: 640px) {
    .section-card {
        padding: 1rem !important;
    }
    .page-title {
        font-size: 1.3rem !important;
    }
    .week-grid {
        gap: 4px !important;
    }
    .week-day-name {
        font-size: 0.55rem !important;
    }
    .week-day-date {
        font-size: 0.55rem !important;
    }
    .week-day-pct {
        font-size: 0.7rem !important;
    }
    .week-bar-track {
        height: 35px !important;
    }
    .stat-habit-name {
        font-size: 0.75rem !important;
    }
    .stat-count {
        font-size: 0.7rem !important;
    }
    .day-header {
        flex-direction: column;
        gap: 0.3rem;
        align-items: flex-start !important;
    }
    .day-date {
        font-size: 0.7rem !important;
    }
    .day-pct-badge {
        font-size: 0.6rem !important;
    }
    .habit-tag {
        font-size: 0.65rem !important;
        padding: 0.2rem 0.5rem !important;
    }
}
</style>

<div class="section-card">
    <div class="page-title">Riwayat Progress</div>
    <div class="page-subtitle">Lihat perjalanan kebiasaanmu dari hari ke hari</div>

    {{-- WEEKLY OVERVIEW --}}
    <div class="section-title">7 Hari Terakhir</div>
    <div class="week-grid">
        @foreach($weeklyStats as $date => $stat)
        @php
            $cls = $stat['percentage'] >= 80 ? 'pct-high' : ($stat['percentage'] >= 50 ? 'pct-mid' : 'pct-low');
            $barCls = $stat['percentage'] >= 80 ? 'bar-high' : ($stat['percentage'] >= 50 ? 'bar-mid' : 'bar-low');
            $barH = max(4, round($stat['percentage'] * 0.48));
        @endphp
        <div class="week-day">
            <div class="week-day-name">{{ \Carbon\Carbon::parse($date)->format('D') }}</div>
            <div class="week-day-date">{{ \Carbon\Carbon::parse($date)->format('d/m') }}</div>
            <div class="week-bar-track">
                <div class="week-bar-fill {{ $barCls }}" style="height:{{ $barH }}px;"></div>
            </div>
            <div class="week-day-pct {{ $cls }}" style="margin-top:5px;">{{ $stat['percentage'] }}%</div>
        </div>
        @endforeach
    </div>

    <div class="section-divider"></div>

 {{-- HABIT STATISTICS --}}
<div class="section-title">Statistik per Habit</div>

@php
    $permanentHabits = array_filter($habitStats, function($stat) {
        return !isset($stat['is_temporary_group']);
    });
    $temporaryGroup = array_filter($habitStats, function($stat) {
        return isset($stat['is_temporary_group']);
    });
@endphp

{{-- Tampilkan habit permanen satu per satu --}}
@foreach($permanentHabits as $stat)
<div class="stat-row">
    <div class="stat-row-top">
        <span class="stat-habit-name">
            <span style="margin-right: 0.5rem;">{{ $stat['icon'] ?? '📌' }}</span>
            {{ $stat['name'] }}
        </span>
        <span class="stat-count">{{ $stat['completed_days'] }}/{{ $stat['total_days'] }} &nbsp;·&nbsp; {{ $stat['percentage'] }}%</span>
    </div>
    <div class="stat-bar-track">
        <div class="stat-bar-fill" style="width:{{ $stat['percentage'] }}%"></div>
    </div>
</div>
@endforeach

{{-- Tampilkan temporary habits sebagai "Lainnya" --}}
@foreach($temporaryGroup as $stat)
<div class="stat-row" style="border-top: 1px dashed rgba(255,255,255,0.1); margin-top: 0.5rem; padding-top: 0.75rem;">
    <div class="stat-row-top">
        <span class="stat-habit-name">
            <span style="margin-right: 0.5rem;">{{ $stat['icon'] }}</span>
            {{ $stat['name'] }}
            <span style="font-size: 0.6rem; color: rgba(232,228,220,0.3); margin-left: 0.5rem;">(habit tambahan)</span>
        </span>
        <span class="stat-count">{{ $stat['completed_days'] }}/{{ $stat['total_days'] }} &nbsp;·&nbsp; {{ $stat['percentage'] }}%</span>
    </div>
    <div class="stat-bar-track">
        <div class="stat-bar-fill" style="width:{{ $stat['percentage'] }}%"></div>
    </div>
</div>
@endforeach

@if(count($permanentHabits) == 0 && count($temporaryGroup) == 0)
<div class="empty-state" style="padding: 1rem;">
    Belum ada data statistik
</div>
@endif

    <div class="section-divider"></div>

    {{-- TODAY'S HISTORY --}}
    <div class="section-title">Histori Hari Ini — {{ now()->format('l, d F Y') }}</div>

    @php
        $todayDate = now()->format('Y-m-d');
        $todayLogsCollection = \App\Models\HabitLog::with('habit')
            ->where('date', $todayDate)
            ->get();
        $todayPct = $todayLogsCollection->count() > 0 
            ? round(($todayLogsCollection->where('completed', true)->count() / $todayLogsCollection->count()) * 100, 2) 
            : 0;
        $badgeCls = $todayPct >= 70 ? 'badge-good' : ($todayPct >= 40 ? 'badge-mid' : 'badge-low');
    @endphp

    @if($todayLogsCollection->count() > 0)
    <div class="day-block">
        <div class="day-header">
            <span class="day-date">{{ now()->format('l, d F Y') }}</span>
            <span class="day-pct-badge {{ $badgeCls }}">{{ $todayPct }}% selesai</span>
        </div>
        <div class="day-habits">
            @foreach($todayLogsCollection as $log)
            <div class="habit-tag {{ $log->completed ? 'tag-done' : 'tag-miss' }}">
                <span>{{ $log->completed ? '✓' : '✗' }}</span>
                <span>{{ $log->habit->name }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="empty-state">
        <div style="font-size:2rem; margin-bottom:0.75rem;">📭</div>
        Belum ada aktivitas hari ini
    </div>
    @endif

    {{-- LINK KE ALL HISTORY --}}
    <div style="margin-top: 1.5rem; text-align: center;">
        <a href="{{ route('habits.all-history') }}" 
           style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(240,168,66,0.1); border: 1px solid rgba(240,168,66,0.2); padding: 0.6rem 1.5rem; border-radius: 999px; font-size: 0.8rem; font-weight: 500; color: #f0a842; text-decoration: none; transition: all 0.2s;">
            Lihat Semua History →
        </a>
    </div>
</div>
@endsection