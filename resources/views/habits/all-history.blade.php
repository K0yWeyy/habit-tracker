{{-- resources/views/habits/all-history.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    .section-card {
        background: #161618;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 20px;
        padding: 1.75rem 2rem;
        margin-bottom: 1.25rem;
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
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: rgba(232,228,220,0.4);
        text-decoration: none;
        font-size: 0.8rem;
        margin-bottom: 1.5rem;
        transition: color 0.2s;
    }
    .back-link:hover {
        color: #f0a842;
    }
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
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    .pagination a, .pagination span {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        background: rgba(255,255,255,0.05);
        color: rgba(232,228,220,0.6);
        text-decoration: none;
        font-size: 0.8rem;
        transition: all 0.2s;
    }
    .pagination a:hover {
        background: rgba(240,168,66,0.2);
        color: #f0a842;
    }
    .pagination .active span {
        background: #f0a842;
        color: #0d0d0f;
    }
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: rgba(232,228,220,0.2);
        font-size: 0.9rem;
    }

    /* Mobile specific for all history */
@media (max-width: 640px) {
    .section-card {
        padding: 1rem !important;
    }
    .page-title {
        font-size: 1.3rem !important;
    }
    .day-header {
        flex-direction: column;
        gap: 0.3rem;
        align-items: flex-start !important;
    }
    .day-date {
        font-size: 0.7rem !important;
    }
    .habit-tag {
        font-size: 0.65rem !important;
        padding: 0.2rem 0.5rem !important;
    }
    .pagination a, .pagination span {
        padding: 0.3rem 0.6rem !important;
        font-size: 0.7rem !important;
    }
}
</style>

<div class="section-card">
    <a href="{{ route('habits.history') }}" class="back-link">← Kembali ke History</a>
    
    <div class="page-title">Semua History</div>
    <div class="page-subtitle">Seluruh perjalanan kebiasaanmu dari awal hingga sekarang</div>

    @php
        // Group logs by date dari collection paginator
        $logsByDate = $allLogs->getCollection()->groupBy('date');
    @endphp

    @forelse($logsByDate as $date => $dailyLogs)
    @php
        $pct = $dailyStats[$date]['percentage'] ?? 0;
        $badgeCls = $pct >= 70 ? 'badge-good' : ($pct >= 40 ? 'badge-mid' : 'badge-low');
    @endphp
    <div class="day-block">
        <div class="day-header">
            <span class="day-date">{{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}</span>
            <span class="day-pct-badge {{ $badgeCls }}">{{ $pct }}% selesai</span>
        </div>
        <div class="day-habits">
            @foreach($dailyLogs as $log)
            <div class="habit-tag {{ $log->completed ? 'tag-done' : 'tag-miss' }}">
                <span>{{ $log->completed ? '✓' : '✗' }}</span>
                <span>{{ $log->habit->name }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="empty-state">
        <div style="font-size:2rem; margin-bottom:0.75rem;">📭</div>
        Belum ada data history
    </div>
    @endforelse

    {{-- Pagination --}}
    <div class="pagination">
        {{ $allLogs->links() }}
    </div>
</div>
@endsection