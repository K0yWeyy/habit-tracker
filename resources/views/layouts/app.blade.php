{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Habit Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-timetable-64.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: #0d0d0f;
            color: #e8e4dc;
            min-height: 100vh;
        }
        h1, h2, h3, .font-display { font-family: 'Syne', sans-serif; }

        /* Nav - Mobile Friendly */
        .nav-wrap {
            background: rgba(13,13,15,0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255,255,255,0.07);
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .nav-logo {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            color: #f0a842;
            letter-spacing: -0.02em;
            text-decoration: none;
        }
        .nav-link {
            font-size: 0.75rem;
            font-weight: 500;
            color: rgba(232,228,220,0.5);
            text-decoration: none;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            transition: color 0.2s, background 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            color: #e8e4dc;
            background: rgba(255,255,255,0.07);
        }
        .nav-exit {
            font-size: 0.7rem;
            font-weight: 500;
            color: rgba(232,228,220,0.35);
            text-decoration: none;
            padding: 0.25rem 0.6rem;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 6px;
            transition: all 0.2s;
        }
        .nav-exit:hover {
            color: #e8e4dc;
            border-color: rgba(255,255,255,0.2);
        }

        /* Page bg texture */
        .page-bg {
            background: #0d0d0f;
            background-image:
                radial-gradient(ellipse 60% 40% at 80% 10%, rgba(240,168,66,0.07) 0%, transparent 60%),
                radial-gradient(ellipse 50% 50% at 10% 80%, rgba(240,168,66,0.04) 0%, transparent 60%);
            min-height: 100vh;
            padding: 1rem 0.75rem 2rem;
        }

        /* Flash success */
        .flash-success {
            background: rgba(99, 153, 34, 0.12);
            border: 1px solid rgba(99,153,34,0.3);
            color: #a3c96b;
            padding: 0.6rem 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            font-size: 0.8rem;
        }

        /* Cards - Mobile responsive */
        .card {
            background: #161618;
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 16px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        /* Mobile container */
        @media (max-width: 640px) {
            .page-bg {
                padding: 0.75rem 0.5rem 1.5rem;
            }
            .nav-link {
                font-size: 0.7rem;
                padding: 0.25rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="nav-wrap">
        <div style="max-width:900px; margin:0 auto; padding:0 0.75rem; height:52px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:0.2rem; flex-wrap:wrap;">
                <a href="{{ route('habits.index') }}" class="nav-logo">⬡ Habit</a>
                <div style="width:1px; height:16px; background:rgba(255,255,255,0.1); margin:0 0.5rem;"></div>
                <a href="{{ route('habits.index') }}" class="nav-link {{ request()->routeIs('habits.index') ? 'active' : '' }}">Today</a>
                <a href="{{ route('habits.history') }}" class="nav-link {{ request()->routeIs('habits.history') ? 'active' : '' }}">History</a>
            </div>
            <a href="{{ route('welcome') }}" class="nav-exit">Keluar ↩</a>
        </div>
    </nav>

    <div class="page-bg">
        <div style="max-width:900px; margin:0 auto;">
            @if(session('success'))
                <div class="flash-success">✓ {{ session('success') }}</div>
            @endif
            @yield('content')
        </div>
    </div>
</body>
</html>