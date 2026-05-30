{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habit Tracker — Welcome</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #0d0d0f;
            color: #e8e4dc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Ambient blobs */
        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            opacity: 0.18;
        }
        .blob-1 { width: 500px; height: 400px; background: #f0a842; top: -100px; right: -80px; animation: drift 12s ease-in-out infinite alternate; }
        .blob-2 { width: 350px; height: 350px; background: #e06830; bottom: -80px; left: -60px; animation: drift 16s ease-in-out infinite alternate-reverse; }
        @keyframes drift { from { transform: translate(0,0) scale(1); } to { transform: translate(30px, 20px) scale(1.08); } }

        /* Grid texture overlay */
        body::after {
            content: '';
            position: fixed; inset: 0;
            background-image: linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }

        .wrapper {
            position: relative;
            z-index: 1;
            max-width: 620px;
            width: 100%;
            padding: 1.2rem;
            text-align: center;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #f0a842;
            border: 1px solid rgba(240,168,66,0.3);
            padding: 0.3rem 0.9rem;
            border-radius: 999px;
            margin-bottom: 1.5rem;
            background: rgba(240,168,66,0.06);
        }

        h1 {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2.3rem, 6vw, 4rem);
            font-weight: 100;
            line-height: 0.92;
            letter-spacing: -0.03em;
            color: #f5f0e8;
            margin-bottom: 0.7rem;
        }

        h1 span { color: #f0a842; }

        .subtitle {
            font-size: 0.95rem;
            color: rgba(232,228,220,0.55);
            line-height: 1.5;
            max-width: 420px;
            margin: 0 auto 1.8rem;
        }

        .features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 1.8rem;
            text-align: left;
        }
        .feat {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 14px;
            padding: 0.9rem 1rem;
            transition: border-color 0.2s, background 0.2s;
        }
        .feat:hover {
            background: rgba(255,255,255,0.06);
            border-color: rgba(240,168,66,0.25);
        }
        .feat-icon { font-size: 1.4rem; margin-bottom: 0.4rem; }
        .feat-title {
            font-family: 'Syne', sans-serif;
            font-size: 0.875rem;
            font-weight: 700;
            color: #e8e4dc;
            margin-bottom: 0.2rem;
        }
        .feat-desc { font-size: 0.75rem; color: rgba(232,228,220,0.4); line-height: 1.5; }

        /* CTA button */
        .cta {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #f0a842;
            color: #0d0d0f;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            padding: 0.85rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            transition: transform 0.2s, background 0.2s, box-shadow 0.2s;
            box-shadow: 0 0 0 0 rgba(240,168,66,0);
        }
        .cta:hover {
            transform: translateY(-2px) scale(1.02);
            background: #f5b95a;
            box-shadow: 0 12px 32px rgba(240,168,66,0.3);
        }
        .cta-arrow {
            width: 22px; height: 22px;
            background: rgba(0,0,0,0.15);
            border-radius: 6px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 0.9rem;
        }

        .footer-note {
            margin-top: 1rem;
            font-size: 0.7rem;
            color: rgba(232,228,220,0.25);
            letter-spacing: 0.05em;
        }

        @media (max-height: 750px) {
    .features {
        margin-bottom: 1.5rem;
    }

    .feat {
        padding: 0.9rem 1rem;
    }

    .subtitle {
        margin-bottom: 1.5rem;
    }

    .footer-note {
        margin-top: 1rem;
    }
}

/* Mobile specific for welcome page */
@media (max-width: 640px) {
    .wrapper {
        padding: 1rem !important;
    }
    h1 {
        font-size: clamp(1.8rem, 8vw, 2.5rem) !important;
    }
    .subtitle {
        font-size: 0.8rem !important;
        padding: 0 0.5rem !important;
    }
    .features {
        gap: 6px !important;
        margin-bottom: 1.2rem !important;
    }
    .feat {
        padding: 0.6rem 0.7rem !important;
    }
    .feat-icon {
        font-size: 1.1rem !important;
    }
    .feat-title {
        font-size: 0.7rem !important;
    }
    .feat-desc {
        font-size: 0.6rem !important;
    }
    .cta {
        padding: 0.6rem 1.2rem !important;
        font-size: 0.85rem !important;
    }
}
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="wrapper">
        <div class="eyebrow">
            <span>⬡</span> Personal Habit System
        </div>

        <h1>Build the<br><span>life you want.</span></h1>

        <p class="subtitle"> Bangun kebiasaan baik, lacak progressmu setiap hari!</p>

        <div class="features">
            <div class="feat">
                <div class="feat-icon">🫵🏻</div>
                <div class="feat-title">Simple Goals</div>
                <div class="feat-desc">Dopamin butuh reward yang nyata, bukan yang abstrak.</div>
            </div>
            <div class="feat">
                <div class="feat-icon">🏃</div>
                <div class="feat-title">Execution</div>
                <div class="feat-desc">Enjoy the process — itulah kuncinya.</div>
            </div>
            <div class="feat">
                <div class="feat-icon">🗣️</div>
                <div class="feat-title">Konsisten</div>
                <div class="feat-desc">Apapun yang terjadi, kamu bisa melakukannya.</div>
            </div>
            <div class="feat">
                <div class="feat-icon">🏆</div>
                <div class="feat-title">Succeed</div>
                <div class="feat-desc">Reward besar itu akan datang. Percaya prosesnya.</div>
            </div>
        </div>

        <a href="{{ route('habits.index') }}" class="cta">
            Mulai Sekarang
            <span class="cta-arrow">→</span>
        </a>

        <p class="footer-note">MULAI KEBIASAAN BAIKMU DARI HARI INI</p>
    </div>
</body>
</html>