<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | Tabungan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        :root {
            --bg-main: #FAFAFA; --card-bg: #FFFFFF; --text-main: #111827; --text-muted: #6B7280;
            --border-color: #E5E7EB; --primary: #111827; --accent: #059669;
            --radius-md: 12px; --radius-sm: 8px;
        }
        [data-theme="dark"] {
            --bg-main: #0A0A0A; --card-bg: #171717; --text-main: #F9FAFB; --text-muted: #A1A1AA; --border-color: #27272A; --primary: #F9FAFB;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg-main); color: var(--text-main); transition: 0.3s; }
        .container { max-width: 1040px; margin: 0 auto; padding: 0 1.5rem 3rem; }

        /* Navbar Identik dengan Beranda */
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 1.5rem 0; margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); }
        .nav-brand { font-weight: 700; font-size: 1.25rem; text-decoration: none; color: var(--text-main); letter-spacing: -0.5px; }
        .nav-links { display: flex; gap: 2rem; }
        .nav-link { font-size: 0.85rem; font-weight: 500; color: var(--text-muted); text-decoration: none; }
        .nav-link.active { color: var(--text-main); font-weight: 600; }
        .nav-right { display: flex; align-items: center; gap: 1.5rem; }
        .btn-icon { background: none; border: none; cursor: pointer; color: var(--text-main); }
        .avatar { width: 32px; height: 32px; background: var(--text-main); color: var(--bg-main); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.8rem; }

        /* Content Layout */
        .main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; }
        @media (max-width: 900px) { .main-grid { grid-template-columns: 1fr; } }

        .panel { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.5rem; margin-bottom: 1.5rem; }
        
        /* Progress & Savings Card */
        .saving-card { padding-bottom: 1.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); }
        .saving-card:last-child { border-bottom: none; padding-bottom: 0; }
        
        .progress-container { background: var(--bg-main); height: 6px; border-radius: 10px; margin: 1rem 0; overflow: hidden; }
        .progress-bar { height: 100%; background: var(--accent); border-radius: 10px; transition: 0.6s cubic-bezier(0.4, 0, 0.2, 1); }

        .btn { padding: 0.6rem 1.2rem; border-radius: var(--radius-sm); font-weight: 500; font-size: 0.85rem; cursor: pointer; border: none; transition: 0.2s; text-decoration: none; display: inline-block; }
        .btn-primary { background: var(--primary); color: var(--bg-main); }
        .btn-outline { background: transparent; border: 1px solid var(--border-color); color: var(--text-main); }
        .btn-outline:hover { border-color: var(--text-main); }

        /* Modal Minimalis */
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; }
        .modal-content { background: var(--card-bg); padding: 2rem; border-radius: var(--radius-md); width: 90%; max-width: 400px; border: 1px solid var(--border-color); }
        .modal-input { width: 100%; padding: 0.8rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--bg-main); color: var(--text-main); margin-bottom: 1rem; outline: none; }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <a href="{{ url('/') }}" class="nav-brand">Rupia.</a>
            <div class="nav-links">
                <a href="{{ url('/') }}" class="nav-link">Beranda</a>
                <a href="{{ url('/saving') }}" class="nav-link active">Tabungan</a>
                <a href="{{ url('/education') }}" class="nav-link">Edukasi</a>
                <a href="{{ url('/planner') }}" class="nav-link">Planner</a>
            </div>
            <div class="nav-right">
                <button id="themeToggle" class="btn-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" id="themeIcon"></svg>
                </button>
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
            </div>
        </nav>

        <header style="margin-bottom: 2.5rem;">
            <h1 style="font-size: 1.5rem; font-weight: 600; letter-spacing: -0.5px;">Target Tabungan</h1>
            <p style="font-size: 0.9rem; color: var(--text-muted);">Kelola impian masa depanmu secara terukur.</p>
        </header>

        <div class="main-grid">
            <div class="panel">
                @forelse($savings ?? [] as $saving)
                    @php $progress = $saving->target_amount > 0 ? round(($saving->current_amount / $saving->target_amount) * 100) : 0; @endphp
                    <div class="saving-card">
                        <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                            <div>
                                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 4px;">{{ $saving->title }}</h3>
                                <p style="font-size: 0.8rem; color: var(--text-muted);">Target: Rp {{ number_format($saving->target_amount, 0, ',', '.') }}</p>
                            </div>
                            <span style="font-weight: 700; color: var(--accent);">{{ $progress }}%</span>
                        </div>
                        <div class="progress-container">
                            <div class="progress-bar" style="width: {{ $progress > 100 ? 100 : $progress }}%;"></div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <p style="font-size: 0.85rem;">Terkumpul: <b>Rp {{ number_format($saving->current_amount, 0, ',', '.') }}</b></p>
                            <button class="btn btn-outline" onclick="openDepositModal('{{ $saving->id }}', '{{ $saving->title }}')">Isi Celengan</button>
                        </div>
                    </div>
                @empty
                    <p style="color: var(--text-muted); font-size: 0.9rem; text-align: center;">Belum ada target yang dibuat.</p>
                @endforelse
            </div>

            <aside>
                <div class="panel" style="background: var(--primary); color: var(--bg-main);">
                    <h3 style="font-size: 1rem; margin-bottom: 0.5rem;">Tambah Target</h3>
                    <p style="font-size: 0.8rem; opacity: 0.8; margin-bottom: 1.5rem;">Wujudkan barang impianmu dengan menabung konsisten.</p>
                    <button class="btn" style="background: var(--bg-main); color: var(--primary); width: 100%;" onclick="document.getElementById('goalModal').style.display='flex'">+ Buat Goal Baru</button>
                </div>
            </aside>
        </div>
    </div>

    <div id="goalModal" class="modal">
        <form class="modal-content" action="{{ url('/saving/store') }}" method="POST">
            @csrf
            <h2 style="font-size: 1.1rem; margin-bottom: 1.2rem;">Goal Baru</h2>
            <input type="text" name="title" class="modal-input" placeholder="Nama Barang" required>
            <input type="number" name="target_amount" class="modal-input" placeholder="Harga Target (Rp)" required>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Pasang Target</button>
            <button type="button" class="btn btn-outline" style="width: 100%; border: none; margin-top: 0.5rem;" onclick="document.getElementById('goalModal').style.display='none'">Batal</button>
        </form>
    </div>

    <script>
        // Theme logic (sama seperti beranda)
        const themeBtn = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const moon = `<path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>`;
        const sun = `<path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>`;
        
        let currentTheme = localStorage.getItem('theme') || 'light';
        themeIcon.innerHTML = currentTheme === 'dark' ? sun : moon;

        themeBtn.addEventListener('click', () => {
            currentTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', currentTheme);
            localStorage.setItem('theme', currentTheme);
            themeIcon.innerHTML = currentTheme === 'dark' ? sun : moon;
        });

        function openDepositModal(id, title) {
            // Logika deposit modal... sama seperti kode asli Anda
        }
    </script>
</body>
</html>