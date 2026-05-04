<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | Transfer</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        :root {
            --bg-main: #FAFAFA; --card-bg: #FFFFFF; --text-main: #111827; --text-muted: #6B7280;
            --border-color: #E5E7EB; --primary: #111827; --accent: #059669; --radius-md: 12px;
        }
        [data-theme="dark"] {
            --bg-main: #0A0A0A; --card-bg: #171717; --text-main: #F9FAFB; --text-muted: #A1A1AA; --border-color: #27272A;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg-main); color: var(--text-main); transition: 0.3s; padding: 2rem 1.5rem; }
        .container { max-width: 480px; margin: 0 auto; }
        
        .back-link { display: flex; align-items: center; gap: 8px; text-decoration: none; color: var(--text-muted); font-size: 0.85rem; font-weight: 500; margin-bottom: 2rem; transition: 0.2s; }
        .back-link:hover { color: var(--text-main); }

        .panel { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 2rem; }
        
        .form-group { margin-bottom: 1.5rem; }
        .label { display: block; font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
        
        .input-clean { width: 100%; background: var(--bg-main); border: 1px solid var(--border-color); border-radius: 8px; padding: 0.8rem 1rem; color: var(--text-main); font-size: 0.95rem; outline: none; transition: 0.2s; }
        .input-clean:focus { border-color: var(--text-main); }
        .input-amount { font-size: 1.5rem; font-weight: 700; text-align: center; padding: 1.2rem; }

        .btn-black { width: 100%; background: var(--primary); color: var(--bg-main); padding: 1rem; border-radius: 8px; border: none; font-weight: 600; font-size: 0.95rem; cursor: pointer; margin-top: 1rem; transition: 0.2s; }
        .btn-black:hover { opacity: 0.9; }

        .alert { padding: 1rem; border-radius: 8px; font-size: 0.85rem; font-weight: 500; margin-bottom: 1.5rem; }
        .alert-error { background: #FEF2F2; color: #991B1B; border: 1px solid #FEE2E2; }
        .alert-success { background: #ECFDF5; color: #065F46; border: 1px solid #D1FAE5; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ url('/') }}" class="back-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"></path></svg>
            Kembali ke Beranda
        </a>

        @if(session('error')) <div class="alert alert-error">{{ session('error') }}</div> @endif
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

        <form action="{{ url('/transfer/process') }}" method="POST" class="panel">
            @csrf
            <h1 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 2rem;">Kirim Uang</h1>
            
            <div class="form-group">
                <label class="label">Nominal Transfer</label>
                <input type="number" name="amount" class="input-clean input-amount" placeholder="0" required autofocus>
            </div>

            <div class="form-group">
                <label class="label">Tujuan (Bank / E-Wallet)</label>
                <input type="text" name="destination" class="input-clean" placeholder="Contoh: BCA 12345678" required>
            </div>

            <div class="form-group">
                <label class="label">Catatan (Opsional)</label>
                <input type="text" name="notes" class="input-clean" placeholder="Contoh: Bayar Makan">
            </div>

            <button type="submit" class="btn-black">Konfirmasi Transfer</button>
        </form>
    </div>
    <script>document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'light');</script>
</body>
</html>KO