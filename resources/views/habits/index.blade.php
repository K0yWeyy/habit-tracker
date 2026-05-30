{{-- resources/views/habits/index.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    /* Hero section - Mobile */
    .hero-card {
        background: #161618;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 20px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        position: relative;
        overflow: hidden;
    }
    .hero-card::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 150px; height: 150px;
        background: radial-gradient(circle, rgba(240,168,66,0.12) 0%, transparent 70%);
        pointer-events: none;
    }
    .hero-label {
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(232,228,220,0.35);
        margin-bottom: 0.3rem;
    }
    .hero-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.5rem;
        font-weight: 800;
        color: #f5f0e8;
        letter-spacing: -0.02em;
    }
    .progress-pct {
        font-family: 'Syne', sans-serif;
        font-size: 2.5rem;
        font-weight: 800;
        color: #f0a842;
        line-height: 1;
    }
    .progress-pct-label {
        font-size: 0.7rem;
        color: rgba(232,228,220,0.4);
        margin-top: 0.1rem;
    }
    .progress-track {
        width: 100%;
        height: 5px;
        background: rgba(255,255,255,0.07);
        border-radius: 999px;
        margin: 1rem 0 1.5rem;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #f0a842 0%, #f5c870 100%);
        transition: width 0.6s cubic-bezier(0.4,0,0.2,1);
    }

    /* Habit item - Mobile */
    .habit-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.7rem 0.8rem;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 12px;
        margin-bottom: 0.5rem;
        transition: border-color 0.2s, background 0.2s;
        background: rgba(255,255,255,0.02);
    }
    .habit-icon {
        font-size: 1.2rem;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.05);
        border-radius: 8px;
        flex-shrink: 0;
    }
    .habit-name {
        font-weight: 500;
        font-size: 0.85rem;
        color: #e8e4dc;
        word-break: break-word;
    }
    .habit-name.completed-text {
        color: rgba(232,228,220,0.45);
        text-decoration: line-through;
        text-decoration-color: rgba(99,153,34,0.5);
    }
    .habit-temp {
        font-size: 0.6rem;
        color: rgba(232,228,220,0.3);
        border: 1px solid rgba(255,255,255,0.08);
        padding: 0.1rem 0.35rem;
        border-radius: 4px;
        margin-left: 0.4rem;
        white-space: nowrap;
    }

    /* Toggle button - Mobile (larger touch area) */
    .toggle-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: 2px solid rgba(255,255,255,0.15);
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 1rem;
        font-weight: 700;
        color: transparent;
        flex-shrink: 0;
        -webkit-tap-highlight-color: transparent;
    }
    .toggle-btn:active {
        transform: scale(0.95);
    }
    .toggle-btn.done {
        background: #3b6d11;
        border-color: #639922;
        color: #c0dd97;
    }

    /* Add form - Mobile */
    .add-card {
        background: #161618;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 16px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    .add-title {
        font-family: 'Syne', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: #f5f0e8;
        margin-bottom: 0.75rem;
    }
    .add-input {
        flex: 1;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 0.6rem 0.8rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.85rem;
        color: #e8e4dc;
        outline: none;
        transition: border-color 0.2s, background 0.2s;
        -webkit-appearance: none;
    }
    .add-input:focus {
        border-color: rgba(240,168,66,0.5);
        background: rgba(240,168,66,0.04);
    }
    .add-btn {
        background: #f0a842;
        color: #0d0d0f;
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.6rem 1rem;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        white-space: nowrap;
        -webkit-tap-highlight-color: transparent;
    }
    .add-btn:active {
        transform: scale(0.97);
    }

    .section-label {
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(232,228,220,0.3);
        margin-bottom: 0.6rem;
    }

    .empty-state {
        text-align: center;
        padding: 1.5rem 1rem;
        color: rgba(232,228,220,0.25);
        font-size: 0.8rem;
    }

    /* Mobile specific */
    @media (max-width: 480px) {
        .hero-card {
            padding: 1rem;
        }
        .hero-title {
            font-size: 1.2rem;
        }
        .progress-pct {
            font-size: 2rem;
        }
        .habit-item {
            padding: 0.6rem 0.7rem;
        }
        .habit-name {
            font-size: 0.8rem;
        }
        .toggle-btn {
            width: 32px;
            height: 32px;
        }
        .add-card {
            padding: 0.875rem;
        }
        form {
            flex-direction: column;
            gap: 0.5rem !important;
        }
        .add-btn {
            width: 100%;
            padding: 0.7rem;
        }
    }
</style>

{{-- ADD NEW HABIT - DI ATAS --}}
<div class="add-card">
    <div class="add-title">+ Tambah Habit Baru</div>
    <form action="{{ route('habits.store') }}" method="POST" style="display:flex; gap:0.5rem;">
        @csrf
        <input type="text" name="name" required placeholder="Nama habit baru..." class="add-input">
        <button type="submit" class="add-btn">Tambah</button>
    </form>
</div>

{{-- Hero: Today's Progress --}}
<div class="hero-card">
    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
        <div>
            <div class="hero-label">{{ now()->translatedFormat('l, d F Y') }}</div>
            <div class="hero-title">Hari Ini</div>
        </div>
        <div style="text-align:right;">
            <div class="progress-pct">{{ $todayPercentage }}%</div>
            <div class="progress-pct-label">selesai</div>
        </div>
    </div>

    <div class="progress-track">
        <div class="progress-fill" style="width: {{ $todayPercentage }}%"></div>
    </div>

    <div class="section-label">Daftar Habit — {{ count($habits) }} total</div>

    @if($habits->isEmpty())
        <div class="empty-state">Belum ada habit. Tambahkan habit pertamamu di atas 👆</div>
    @else
        @foreach($habits as $habit)
        @php $done = isset($todayLogs[$habit->id]) && $todayLogs[$habit->id]; @endphp
        <div class="habit-item {{ $done ? 'completed' : '' }}">
            <div style="display:flex; align-items:center; gap:0.6rem; flex:1; min-width:0;">
                <div class="habit-icon">{{ $habit->icon ?? '📌' }}</div>
                <div style="min-width:0; flex:1;">
                    <span class="habit-name {{ $done ? 'completed-text' : '' }}">{{ $habit->name }}</span>
                    @if(!$habit->is_permanent)
                        <span class="habit-temp">hari ini</span>
                    @endif
                </div>
            </div>
            <button onclick="toggleHabit({{ $habit->id }})"
                    class="toggle-btn habit-checkbox-{{ $habit->id }} {{ $done ? 'done' : '' }}"
                    aria-label="Toggle {{ $habit->name }}">
                @if($done)✓@endif
            </button>
        </div>
        @endforeach
    @endif
</div>

<script>
function toggleHabit(habitId) {
    $.ajax({
        url: `/app/habits/${habitId}/toggle`,
        method: 'POST',
        data: { _token: '{{ csrf_token() }}' },
        success: function(response) {
            if (response.completed) {
                $(`.habit-checkbox-${habitId}`).addClass('done').html('✓');
            } else {
                $(`.habit-checkbox-${habitId}`).removeClass('done').html('');
            }
            location.reload();
        },
        error: function(xhr) {
            console.log('Error:', xhr.responseText);
            alert('Terjadi kesalahan, cek console browser');
        }
    });
}
</script>
@endsection