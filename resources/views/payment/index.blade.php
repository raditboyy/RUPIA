<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | Mall</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        :root {
            --bg-main: #FAFAFA; --card-bg: #FFFFFF; --text-main: #111827; --text-muted: #6B7280;
            --border-color: #E5E7EB; --primary: #111827; --info: #3b82f6; --radius-md: 12px;
        }
        [data-theme="dark"] {
            --bg-main: #0A0A0A; --card-bg: #171717; --text-main: #F9FAFB; --text-muted: #A1A1AA; --border-color: #27272A;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg-main); color: var(--text-main); transition: 0.3s; padding-bottom: 5rem; }
        .container { max-width: 1000px; margin: 0 auto; padding: 0 1.5rem; }

        /* Navbar Minimalis */
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 1.5rem 0; margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); }
        .nav-brand { font-weight: 800; font-size: 1.4rem; text-decoration: none; color: var(--text-main); }
        .nav-links { display: flex; gap: 1.5rem; }
        .nav-link { font-size: 0.9rem; font-weight: 500; color: var(--text-muted); text-decoration: none; transition: 0.2s; }
        .nav-link:hover { color: var(--text-main); }

        .category-title { font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 2.5rem 0 1rem; }
        
        /* Grid Produk */
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; }
        .product-card { background: var(--card-bg); border: 1px solid var(--border-color); padding: 1.5rem; border-radius: var(--radius-md); cursor: pointer; transition: 0.2s; text-align: center; }
        .product-card:hover { border-color: var(--text-main); transform: translateY(-3px); }
        .product-icon { font-size: 2rem; margin-bottom: 0.8rem; display: block; }
        .product-name { font-size: 0.95rem; font-weight: 600; }

        /* Modals */
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; }
        .modal-content { background: var(--card-bg); padding: 2rem; border-radius: 16px; width: 90%; max-width: 420px; border: 1px solid var(--border-color); }
        
        .list-item { display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid var(--border-color); border-radius: 10px; margin-bottom: 0.7rem; cursor: pointer; transition: 0.2s; }
        .list-item:hover { border-color: var(--text-main); background: var(--bg-main); }
        .list-item-name { font-weight: 600; font-size: 0.9rem; }
        .list-item-price { font-weight: 700; color: var(--info); }

        .custom-input { width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-main); color: var(--text-main); margin: 1rem 0; outline: none; text-align: center; font-weight: 600; }
        .btn-submit { width: 100%; background: var(--primary); color: white; padding: 1rem; border-radius: 8px; border: none; font-weight: 700; cursor: pointer; margin-top: 1rem; }
        .btn-cancel { width: 100%; background: none; border: 1px solid var(--border-color); color: var(--text-muted); padding: 0.8rem; border-radius: 8px; margin-top: 0.5rem; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <a href="#" class="nav-brand">Rupia.</a>
            <div class="nav-links">
                <a href="#" class="nav-link">Beranda</a>
                <a href="#" class="nav-link">Tabungan</a>
                <a href="#" class="nav-link">Planner</a>
            </div>
        </nav>

        <h1 style="font-size: 1.8rem; font-weight: 800;">🎛️ Mall Pembayaran</h1>

        <div class="category-section">
            <h3 class="category-title">📱 Pulsa & Paket Data</h3>
            <div class="product-grid">
                <div class="product-card" onclick="openMenuModal('pulsa')">
                    <span class="product-icon">📱</span>
                    <div class="product-name">Isi Pulsa</div>
                </div>
                <div class="product-card" onclick="openMenuModal('data')">
                    <span class="product-icon">🌐</span>
                    <div class="product-name">Paket Data</div>
                </div>
            </div>
        </div>

        <div class="category-section">
            <h3 class="category-title">🏠 Tagihan Rumah</h3>
            <div class="product-grid">
                <div class="product-card" onclick="openMenuModal('pln')">
                    <span class="product-icon">⚡</span>
                    <div class="product-name">Token PLN</div>
                </div>
                <div class="product-card" onclick="openMenuModal('internet')">
                    <span class="product-icon">📡</span>
                    <div class="product-name">Internet & TV</div>
                </div>
            </div>
        </div>
    </div>

    <div id="menuModal" class="modal">
        <div class="modal-content">
            <h2 id="menuTitle" style="font-size: 1.1rem; margin-bottom: 1.5rem; text-align: center;">Pilih Nominal</h2>
            <div id="menuContainer"></div>
            <button class="btn-cancel" onclick="closeMenuModal()">Batal</button>
        </div>
    </div>

    <div id="paymentModal" class="modal">
        <form id="paymentForm" class="modal-content" action="{{ url('/pay/process') }}" method="POST" style="text-align: center;">
            @csrf
            <div id="modalIcon" style="font-size: 3rem; margin-bottom: 1rem;">🛒</div>
            <h2 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Konfirmasi Bayar</h2>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1rem;">Pembelian: <b id="displayProduct" style="color: var(--text-main);">...</b></p>
            <h1 id="displayPrice" style="color: var(--info); font-size: 1.8rem; font-weight: 800; margin-bottom: 1rem;">Rp 0</h1>

            <input type="text" class="custom-input" placeholder="Nomor HP / ID Pelanggan" required>
            <input type="hidden" name="product_name" id="inputProduct">
            <input type="hidden" name="amount" id="inputAmount">

            <button type="submit" class="btn-submit">Bayar Sekarang</button>
            <button type="button" class="btn-cancel" onclick="closePaymentModal()">Kembali</button>
        </form>
    </div>

    <script>
        // Data Dummy (Persis punyamu, Abdan)
        const productData = {
            'pulsa': { title: '📱 Pilih Nominal Pulsa', icon: '📱', items: [ { name: 'Pulsa 20.000', price: 21500 }, { name: 'Pulsa 50.000', price: 51000 }, { name: 'Pulsa 100.000', price: 99500 } ] },
            'data': { title: '🌐 Pilih Paket Data', icon: '🌐', items: [ { name: 'Paket Harian 2GB', price: 15000 }, { name: 'Paket Mingguan 10GB', price: 55000 } ] },
            'pln': { title: '⚡ Pilih Token Listrik', icon: '⚡', items: [ { name: 'Token PLN 50.000', price: 52500 }, { name: 'Token PLN 100.000', price: 102500 } ] },
            'internet': { title: '📡 Bayar Internet', icon: '📡', items: [ { name: 'Indihome 30Mbps', price: 350000 } ] }
        };

        function openMenuModal(key) {
            const data = productData[key];
            document.getElementById('menuTitle').innerText = data.title;
            const container = document.getElementById('menuContainer');
            container.innerHTML = '';
            data.items.forEach(item => {
                const div = document.createElement('div');
                div.className = 'list-item';
                div.onclick = () => openPaymentModal(item.name, item.price, data.icon);
                div.innerHTML = `<span class="list-item-name">${item.name}</span><span class="list-item-price">Rp ${item.price.toLocaleString('id-ID')}</span>`;
                container.appendChild(div);
            });
            document.getElementById('menuModal').style.display = 'flex';
        }

        function openPaymentModal(name, price, icon) {
            closeMenuModal();
            document.getElementById('modalIcon').innerText = icon;
            document.getElementById('displayProduct').innerText = name;
            document.getElementById('displayPrice').innerText = 'Rp ' + price.toLocaleString('id-ID');
            document.getElementById('inputProduct').value = name;
            document.getElementById('inputAmount').value = price;
            document.getElementById('paymentModal').style.display = 'flex';
        }

        function closeMenuModal() { document.getElementById('menuModal').style.display = 'none'; }
        function closePaymentModal() { document.getElementById('paymentModal').style.display = 'none'; }
        document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'light');
    </script>
</body>
</html>