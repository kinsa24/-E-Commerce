<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
      <link rel="stylesheet" href="css/dashboard.css">
    <style>
        .object-fit-cover {
            object-fit: cover
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Shoes Original Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="Dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="daftar_produk.php">Produk</a></li>
                    <li class="nav-item"><a class="nav-link active" href="keranjang_belanja.php">Belanja</a></li>
                    <li class="nav-item"><a class="nav-link" href="hasil_belanja.php">Hasil Belanja</a></li>
                    <li class="nav-item ms-auto">
                        <button class="btn btn-outline-danger" onclick="logout()">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <div class="row g-4">
            <!-- Sisi kiri: pesan atau form pembelian -->
            <div class="col-12 col-lg-8" id="leftPane"></div>

            <!-- Sisi kanan: bantuan -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-body-secondary">Bantuan Cepat</div>
                    <div class="card-body">
                        <ol class="mb-3">
                            <li>Pilih produk di <strong>Produk</strong>.</li>
                            <li>Atur jumlah di <strong>Belanja</strong>.</li>
                            <li>Klik <strong>Belanja</strong> untuk checkout.</li>
                        </ol>
                        <a href="daftar_produk.php" class="btn btn-outline-primary w-100 mb-2">
                            <i class="bi bi-shop-window me-1"></i> Ke Halaman Produk
                        </a>
                        <a href="hasil_belanja.php" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-receipt me-1"></i> Lihat Hasil Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const formatIDR = n => new Intl.NumberFormat('id-ID').format(n);

        document.addEventListener('DOMContentLoaded', () => {
            const left = document.getElementById('leftPane');
            const raw = sessionStorage.getItem('pendingItem');

            if (!raw) {
                // kalau tidak ada produk yang dipilih → tampilkan pesan kosong
                left.innerHTML = `
          <div class="card shadow-sm">
            <div class="card-body text-center">
              <i class="bi bi-cart-x fs-1 text-secondary"></i>
              <h5 class="mt-2 mb-1">Keranjang kosong</h5>
              <p class="text-secondary mb-3">Silakan pilih produk terlebih dahulu untuk melanjutkan.</p>
              <a href="daftar_produk.php" class="btn btn-primary">
                <i class="bi bi-bag-plus me-1"></i> Lihat Produk
              </a>
            </div>
          </div>`;
                return;
            }

            // kalau ada produk, tampilkan form belanja
            const item = JSON.parse(raw);
            left.innerHTML = `
        <div class="card shadow-sm">
          <div class="row g-0">
            <div class="col-md-5">
              <img src="${item.img}" alt="${item.name}" class="img-fluid rounded-start h-100 object-fit-cover">
            </div>
            <div class="col-md-7">
              <div class="card-body">
                <h5 class="card-title mb-1">${item.name}</h5>
                <div class="text-secondary small mb-2">ID: ${item.id}</div>
                <div class="fw-bold fs-5 mb-3">Rp <span id="price">${formatIDR(item.price)}</span></div>

                <div class="mb-3">
                  <label class="form-label">Jumlah</label>
                  <input type="number" id="qty" class="form-control" min="1" value="1">
                </div>

                <div class="mb-3">
                  <div class="small text-secondary">Subtotal</div>
                  <div class="h5">Rp <span id="subtotal">${formatIDR(item.price)}</span></div>
                </div>

                <div class="d-flex gap-2">
                  <button class="btn btn-success flex-fill" id="btnBuy">
                    <i class="bi bi-bag-check me-1"></i> Belanja
                  </button>
                  <button class="btn btn-danger flex-fill" id="btnCancel">
                    <i class="bi bi-x-circle me-1"></i> Batalkan
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>`;

            const qtyEl = document.getElementById('qty');
            const subtotalEl = document.getElementById('subtotal');
            qtyEl.addEventListener('input', () => {
                const q = Math.max(1, parseInt(qtyEl.value || '1', 10));
                qtyEl.value = q;
                subtotalEl.textContent = formatIDR(q * item.price);
            });

            // klik Belanja
            document.getElementById('btnBuy').addEventListener('click', () => {
                const qty = Math.max(1, parseInt(qtyEl.value || '1', 10));
                const order = {
                    id: 'INV-' + Date.now(),
                    items: [{ ...JSON.parse(sessionStorage.getItem('pendingItem')), quantity: qty }],
                    total: qty * JSON.parse(sessionStorage.getItem('pendingItem')).price,
                    created_at: new Date().toISOString()
                };
                const key = 'orderHistory';
                const history = JSON.parse(sessionStorage.getItem(key) || '[]');
                history.push(order);
                sessionStorage.setItem(key, JSON.stringify(history));


                //sessionStorage.setItem('lastOrder', JSON.stringify(order));
                sessionStorage.removeItem('pendingItem');
                window.location.href = 'hasil_belanja.php';
            });

            // klik Batalkan
            document.getElementById('btnCancel').addEventListener('click', () => {
                sessionStorage.removeItem('pendingItem');
                left.innerHTML = `
          <div class="card shadow-sm">
            <div class="card-body text-center">
              <i class="bi bi-cart-x fs-1 text-secondary"></i>
              <h5 class="mt-2 mb-1">Keranjang kosong</h5>
              <p class="text-secondary mb-3">Silakan pilih produk terlebih dahulu untuk melanjutkan.</p>
              <a href="daftar_produk.php" class="btn btn-primary">
                <i class="bi bi-bag-plus me-1"></i> Lihat Produk
              </a>
            </div>
          </div>`;
            });
        });

        function logout() { /* isi backend nanti */ }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>