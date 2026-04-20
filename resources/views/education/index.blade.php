<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | Edukasi</title>
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

        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 1.5rem 0; margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); }
        .nav-brand { font-weight: 700; font-size: 1.25rem; text-decoration: none; color: var(--text-main); letter-spacing: -0.5px; }
        .nav-links { display: flex; gap: 2rem; }
        .nav-link { font-size: 0.85rem; font-weight: 500; color: var(--text-muted); text-decoration: none; }
        .nav-link.active { color: var(--text-main); font-weight: 600; }
        
        .nav-right { display: flex; align-items: center; gap: 1.5rem; }
        .btn-icon { background: none; border: none; cursor: pointer; color: var(--text-main); }
        .avatar { width: 32px; height: 32px; background: var(--text-main); color: var(--bg-main); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.8rem; }

        .main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; }
        @media (max-width: 900px) { .main-grid { grid-template-columns: 1fr; } }

        .panel { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.5rem; margin-bottom: 1.5rem; }

        .edu-item { border-bottom: 1px solid var(--border-color); padding: 1.2rem 0; cursor: pointer; }
        .edu-item:last-child { border-bottom: none; }
        .edu-header { display: flex; justify-content: space-between; align-items: center; }
        .edu-header h3 { font-size: 1rem; font-weight: 600; }
        .edu-icon { transition: 0.3s; color: var(--text-muted); }
        
        .edu-detail { display: none; margin-top: 1rem; font-size: 0.9rem; color: var(--text-muted); line-height: 1.6; }
        
        .info-card { background: rgba(5, 150, 105, 0.05); border: 1px solid var(--accent); border-radius: var(--radius-md); padding: 1.5rem; }
        .info-card h4 { color: var(--accent); font-size: 0.85rem; text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.5px; }

        footer { text-align: center; margin-top: 3rem; color: var(--text-muted); font-size: 0.8rem; }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <a href="{{ url('/') }}" class="nav-brand">Rupia.</a>
            <div class="nav-links">
                <a href="{{ url('/') }}" class="nav-link">Beranda</a>
                <a href="{{ url('/saving') }}" class="nav-link">Tabungan</a>
                <a href="{{ url('/education') }}" class="nav-link active">Edukasi</a>
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
            <h1 style="font-size: 1.5rem; font-weight: 600; letter-spacing: -0.5px;">Knowledge Base</h1>
            <p style="font-size: 0.9rem; color: var(--text-muted);">Pelajari cara mengelola aset dengan cerdas.</p>
        </header>

        <div class="main-grid">
            <div class="panel">
                <div class="edu-item" onclick="toggleDetail(this)">
                    <div class="edu-header">
                        <h3>Kenapa Harus Dana Darurat?</h3>
                        <svg class="edu-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="edu-detail">
                        Dana darurat adalah uang yang disimpan khusus untuk kejadian tak terduga (seperti biaya perbaikan motor atau kebutuhan mendesak lainnya). Bagi pelajar atau pekerja magang, idealnya simpan minimal 3-6 bulan pengeluaran bulananmu.
                    </div>
                </div>

                <div class="edu-item" onclick="toggleDetail(this)">
                    <div class="edu-header">
                        <h3>Strategi Alokasi 50/30/20</h3>
                        <svg class="edu-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="edu-detail">
                        Bagi pendapatanmu menjadi tiga bagian: 50% untuk kebutuhan pokok (Needs), 30% untuk hiburan atau keinginan (Wants), dan 20% wajib untuk tabungan atau investasi (Savings).
                    </div>
                </div>

                <div class="edu-item" onclick="toggleDetail(this)">
                    <div class="edu-header">
                        <h3>Mengenal Bahaya Inflasi</h3>
                        <svg class="edu-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="edu-detail">
                        Inflasi adalah penurunan nilai mata uang seiring berjalannya waktu. Itulah sebabnya menabung di instrumen seperti emas atau aset investasi lainnya lebih baik daripada sekadar menyimpan uang tunai di bawah bantal.
                    </div>
                </div>
            </div>

            <aside>
                <div class="info-card">
                    <h4>Insight Hari Ini</h4>
                    <p style="font-size: 0.9rem; line-height: 1.5; color: var(--text-main);">"Jangan menabung apa yang tersisa setelah dibelanjakan, tapi belanjakan apa yang tersisa setelah menabung."</p>
                </div>
            </aside>
        </div>

        <footer>&copy; 2026 Rupia App</footer>
    </div>

    <script>
        // Theme Logic
        const themeBtn = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const moon = `<path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>`;
        const sun = `<path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>`;
        
        let currentTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', currentTheme);
        themeIcon.innerHTML = currentTheme === 'dark' ? sun : moon;

        themeBtn.addEventListener('click', () => {
            currentTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', currentTheme);
            localStorage.setItem('theme', currentTheme);
            themeIcon.innerHTML = currentTheme === 'dark' ? sun : moon;
        });

        // Toggle Edu Detail
        function toggleDetail(panel) {
            const detail = panel.querySelector('.edu-detail');
            const icon = panel.querySelector('.edu-icon');
            const isHidden = window.getComputedStyle(detail).display === 'none';
            detail.style.display = isHidden ? 'block' : 'none';
            icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
        }
    </script>
</body>
</html>