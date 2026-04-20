<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | Beranda</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        :root {
            --bg-main: #FAFAFA;
            --card-bg: #FFFFFF;
            --text-main: #111827;
            --text-muted: #6B7280;
            --border-color: #E5E7EB;
            --primary: #111827; /* Hitam elegan untuk elemen utama */
            --accent: #059669; /* Hijau kalem untuk aksen/angka positif */
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
        }

        [data-theme="dark"] {
            --bg-main: #0A0A0A;
            --card-bg: #171717;
            --text-main: #F9FAFB;
            --text-muted: #A1A1AA;
            --border-color: #27272A;
            --primary: #F9FAFB;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Batik overlay sangat tipis agar tidak mengganggu layout elegan */
        .bg-batik {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url("{{ asset('images/mega-mendung.jpg') }}");
            background-size: cover;
            background-position: center;
            opacity: 0.02; 
            z-index: -1;
            filter: grayscale(100%);
            pointer-events: none;
        }

        .container { max-width: 1040px; margin: 0 auto; padding: 0 1.5rem 3rem 1.5rem; }

        /* Navbar Minimalis */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .nav-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--text-main);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .nav-links { display: flex; gap: 2rem; }
        
        .nav-link {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }
        .nav-link.active { color: var(--text-main); font-weight: 600; }
        .nav-link:hover:not(.active) { color: var(--text-main); }

        .nav-right { display: flex; align-items: center; gap: 1.5rem; }

        .btn-icon { background: none; border: none; cursor: pointer; color: var(--text-main); display: flex; align-items: center; }

        .avatar-circle {
            width: 32px; height: 32px;
            background: var(--text-main); color: var(--bg-main);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 0.8rem;
        }

        .btn-logout {
            background: transparent; color: var(--text-muted); border: none;
            font-weight: 500; font-size: 0.85rem; cursor: pointer; transition: 0.2s;
        }
        .btn-logout:hover { color: #DC2626; }

        /* Komponen Panel Standar */
        .panel {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 1.5rem;
        }

        /* Balance Card ala Kartu Hitam Premium */
        .balance-card {
            background: #111827; /* Selalu gelap untuk kesan premium */
            color: #FFFFFF;
            border-radius: var(--radius-lg);
            padding: 2rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.2);
        }

        .balance-label { font-size: 0.75rem; font-weight: 500; letter-spacing: 1px; color: #9CA3AF; margin-bottom: 0.5rem; display: block; }
        .balance-amount { font-size: 2.5rem; font-weight: 600; letter-spacing: -1px; margin-bottom: 1.5rem; line-height: 1; }

        .health-badge {
            display: flex; flex-direction: column; align-items: flex-end;
        }
        .health-score {
            font-size: 2rem; font-weight: 700; color: #10B981; line-height: 1;
        }
        .health-text { font-size: 0.7rem; color: #9CA3AF; letter-spacing: 0.5px; text-transform: uppercase; margin-top: 0.2rem; }

        /* Buttons */
        .btn-group { display: flex; gap: 0.75rem; }
        .btn {
            padding: 0.6rem 1.2rem; border-radius: var(--radius-sm);
            font-weight: 500; font-size: 0.85rem; cursor: pointer;
            text-decoration: none; transition: 0.2s;
        }
        .btn-light { background: #FFFFFF; color: #111827; border: 1px solid #FFFFFF; }
        .btn-light:hover { background: #F3F4F6; }
        .btn-outline-dark { background: transparent; color: #FFFFFF; border: 1px solid #374151; }
        .btn-outline-dark:hover { background: #1F2937; }

        /* Grid Layout */
        .main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; }
        @media (max-width: 900px) { .main-grid { grid-template-columns: 1fr; } }

        /* Shortcut Grid */
        .shortcut-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; }
        .shortcut-item {
            display: flex; flex-direction: column; align-items: flex-start;
            padding: 1.2rem; background: var(--card-bg); border: 1px solid var(--border-color);
            border-radius: var(--radius-md); text-decoration: none; color: var(--text-main);
            transition: all 0.2s ease;
        }
        .shortcut-item:hover { border-color: var(--text-main); }
        .shortcut-icon { width: 20px; height: 20px; margin-bottom: 1rem; color: var(--text-main); }
        .shortcut-label { font-size: 0.8rem; font-weight: 500; }

        /* List Items (Market) */
        .list-item { display: flex; justify-content: space-between; align-items: center; padding: 0.8rem 0; border-bottom: 1px solid var(--border-color); }
        .list-item:last-child { border-bottom: none; padding-bottom: 0; }
        .list-label { font-size: 0.85rem; font-weight: 500; color: var(--text-muted); }
        .list-value { font-size: 0.9rem; font-weight: 600; }

        /* Toggle Switch Elegan */
        .toggle-row { display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius-md); margin-bottom: 1.5rem; }
        .toggle-info h4 { font-size: 0.9rem; font-weight: 600; margin-bottom: 0.2rem; }
        .toggle-info p { font-size: 0.8rem; color: var(--text-muted); }

        .switch { width: 36px; height: 20px; position: relative; display: inline-block; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; inset: 0; background: var(--border-color); transition: .3s; border-radius: 20px; }
        .slider:before { position: absolute; content: ""; height: 14px; width: 14px; left: 3px; bottom: 3px; background: white; transition: .3s; border-radius: 50%; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
        input:checked + .slider { background: var(--primary); }
        input:checked + .slider:before { transform: translateX(16px); }

        .section-title { font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="bg-batik"></div>
    
    <div class="container">
        <nav class="navbar">
            <a href="{{ url('/') }}" class="nav-brand">Rupia.</a>
            <div class="nav-links">
                <a href="{{ url('/') }}" class="nav-link active">Beranda</a>
                <a href="{{ url('/saving') }}" class="nav-link">Tabungan</a>
                <a href="{{ url('/education') }}" class="nav-link">Edukasi</a>
                <a href="{{ url('/planner') }}" class="nav-link">Planner</a>
            </div>
            <div class="nav-right">
                <button id="themeToggle" class="btn-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path></svg>
                </button>
                <div class="avatar-circle">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf 
                    <button type="submit" class="btn-logout">Keluar</button>
                </form>
            </div>
        </nav>

        <header style="margin-bottom: 2rem;">
            <h1 style="font-size: 1.5rem; font-weight: 600; letter-spacing: -0.5px;">Halo, {{ Auth::user()->name ?? 'Abdan' }}.</h1>
            <p style="font-size: 0.9rem; color: var(--text-muted);">Ringkasan finansialmu hari ini.</p>
        </header>

        <div class="toggle-row">
            <div class="toggle-info">
                <h4>Mode Anti-Impuls</h4>
                <p>Verifikasi tambahan sebelum transaksi non-esensial.</p>
            </div>
            <label class="switch">
                <input type="checkbox" id="impulseToggle">
                <span class="slider"></span>
            </label>
        </div>

        <div class="main-grid">
            <section>
                <div class="balance-card">
                    <div>
                        <span class="balance-label">TOTAL SALDO</span>
                        <h2 class="balance-amount">Rp {{ number_format($totalBalance ?? 0, 0, ',', '.') }}</h2>
                        <div class="btn-group">
                            <a href="{{ url('/topup') }}" class="btn btn-light">Top Up</a>
                            <a href="{{ url('/transaction/create') }}" class="btn btn-outline-dark">Catat Keluar</a>
                        </div>
                    </div>
                    <div class="health-badge">
                        <div class="health-score">85</div>
                        <div class="health-text">Skor Finansial</div>
                    </div>
                </div>

                <h3 class="section-title" style="margin-top: 2rem;">Aksi Cepat</h3>
                <div class="shortcut-grid">
                    <a href="{{ url('/transfer') }}" class="shortcut-item">
                        <svg class="shortcut-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        <span class="shortcut-label">Transfer</span>
                    </a>
                    <a href="{{ url('/pay') }}" class="shortcut-item">
                        <svg class="shortcut-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <span class="shortcut-label">Pulsa</span>
                    </a>
                    <a href="{{ url('/pay') }}" class="shortcut-item">
                        <svg class="shortcut-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <span class="shortcut-label">Token PLN</span>
                    </a>
                    <a href="{{ url('/pay') }}" class="shortcut-item">
                        <svg class="shortcut-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span class="shortcut-label">Lainnya</span>
                    </a>
                </div>
            </section>

            <aside>
                <div class="panel" style="margin-bottom: 1.5rem;">
                    <h3 class="section-title">Live Market</h3>
                    <div>
                        <div class="list-item">
                            <span class="list-label">USD / IDR</span>
                            <span class="list-value">Rp {{ number_format($usdToIdr ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="list-item">
                            <span class="list-label">Bitcoin (BTC)</span>
                            <span class="list-value" style="color: var(--accent);">Rp {{ number_format($btcToIdr ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <h3 class="section-title">Analisis Mood</h3>
                    <div style="position: relative; height: 180px; width: 100%;">
                        <canvas id="moodChart"></canvas>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
        // Logika Theme dengan SVG dinamis
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        const themeBtn = document.getElementById('themeToggle');
        
        const moonIcon = `<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path></svg>`;
        const sunIcon = `<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>`;
        
        themeBtn.innerHTML = savedTheme === 'dark' ? sunIcon : moonIcon;
        
        themeBtn.addEventListener('click', () => {
            const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            themeBtn.innerHTML = next === 'dark' ? sunIcon : moonIcon;
        });

        // Logika Anti-Impuls
        const impulseToggle = document.getElementById('impulseToggle');
        impulseToggle.checked = localStorage.getItem('antiImpulse') === 'true';
        impulseToggle.addEventListener('change', (e) => localStorage.setItem('antiImpulse', e.target.checked));

        // Chart.js - Desain Minimalis Doughnut
        const ctx = document.getElementById('moodChart').getContext('2d');
        const chartData = @json($chartData ?? []);
        
        // Cek mode untuk warna teks legend
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        const textColor = isDark ? '#A1A1AA' : '#6B7280';

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Happy', 'Stress', 'Bored', 'FOMO'],
                datasets: [{
                    data: [
                        chartData['Happy'] || 0, 
                        chartData['Stress'] || 0, 
                        chartData['Bored'] || 0, 
                        chartData['FOMO'] || 0
                    ],
                    backgroundColor: ['#111827', '#E5E7EB', '#9CA3AF', '#059669'], // Palet elegan
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%', // Lebih tipis dan modern
                plugins: { 
                    legend: { 
                        position: 'right', 
                        labels: { 
                            usePointStyle: true, 
                            boxWidth: 6,
                            color: textColor,
                            font: { family: "'Inter', sans-serif", size: 11 } 
                        } 
                    } 
                }
            }
        });
    </script>
</body>
</html>