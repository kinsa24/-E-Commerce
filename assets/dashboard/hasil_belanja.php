<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hasil Belanja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
  <!-- Navbar -->
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
          <li class="nav-item"><a class="nav-link" href="keranjang_belanja.php">Belanja</a></li>
          <li class="nav-item"><a class="nav-link active" href="hasil_belanja.php">Hasil Belanja</a></li>
          <li class="nav-item ms-auto">
            <button class="btn btn-outline-danger" onclick="logout()">Logout</button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hasil Belanja -->
  <div class="container mt-4" id="orderSummary"></div>

  <script>
  const fmtIDR = n => new Intl.NumberFormat('id-ID').format(n);

  function renderHistory() {
    const wrap = document.getElementById('orderSummary');
    const key = 'orderHistory';
    const history = JSON.parse(sessionStorage.getItem(key) || '[]');

    if (history.length === 0) {
      wrap.innerHTML = `
        <div class="alert alert-info text-center">
          Belum ada transaksi.<br>
          <a href="daftar_produk.php" class="btn btn-primary mt-2">
            <i class="bi bi-shop-window me-1"></i> Belanja
          </a>
        </div>`;
      return;
    }

    // terbaru dulu
    const list = [...history].reverse();

    wrap.innerHTML = `
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Riwayat Belanja</h4>
        <div class="d-flex gap-2">
          <a href="daftar_produk.php" class="btn btn-primary">
            <i class="bi bi-bag me-1"></i> Belanja Lagi
          </a>
          <button class="btn btn-outline-danger" id="btnClearAll">
            <i class="bi bi-trash me-1"></i> Hapus Riwayat
          </button>
        </div>
      </div>
      <div id="ordersContainer"></div>
    `;

    const container = document.getElementById('ordersContainer');
    container.innerHTML = list.map((order, idx) => {
      // hitung index asli (karena kita reverse saat render)
      const originalIndex = history.length - 1 - idx;

      const rows = (order.items || []).map(it => `
        <tr>
          <td style="width:90px">
            <img src="${it.img}" alt="${it.name}" class="img-fluid rounded" style="max-height:70px; object-fit:cover;">
          </td>
          <td>
            <div class="fw-semibold">${it.name}</div>
            <div class="text-secondary small">ID: ${it.id}</div>
          </td>
          <td class="text-end">Rp ${fmtIDR(it.price)}</td>
          <td class="text-center">${it.quantity}</td>
          <td class="text-end">Rp ${fmtIDR(it.price * it.quantity)}</td>
        </tr>
      `).join('');

      return `
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
              <div>
                <div class="text-secondary small">Nomor Transaksi</div>
                <div class="h5 fw-bold mb-0">${order.id}</div>
              </div>
              <div class="text-end">
                <div class="text-secondary small">Tanggal</div>
                <div class="fw-semibold">${new Date(order.created_at).toLocaleString('id-ID')}</div>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table align-middle">
                <thead class="table-light">
                  <tr>
                    <th></th>
                    <th>Produk</th>
                    <th class="text-end">Harga</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Subtotal</th>
                  </tr>
                </thead>
                <tbody>${rows}</tbody>
                <tfoot>
                  <tr>
                    <th colspan="4" class="text-end">Total</th>
                    <th class="text-end">Rp ${fmtIDR(order.total)}</th>
                  </tr>
                </tfoot>
              </table>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <button class="btn btn-outline-secondary" onclick="window.print()">
                <i class="bi bi-printer me-1"></i> Cetak
              </button>
              <button class="btn btn-outline-danger" onclick="deleteOne(${originalIndex})">
                <i class="bi bi-x-circle me-1"></i> Hapus Transaksi Ini
              </button>
            </div>
          </div>
        </div>`;
    }).join('');

    // Hapus semua riwayat
    document.getElementById('btnClearAll').addEventListener('click', () => {
      sessionStorage.removeItem(key);
      renderHistory();
    });
  }

  function deleteOne(index) {
    const key = 'orderHistory';
    const history = JSON.parse(sessionStorage.getItem(key) || '[]');
    history.splice(index, 1);
    sessionStorage.setItem(key, JSON.stringify(history));
    renderHistory();
  }

  document.addEventListener('DOMContentLoaded', renderHistory);

  function logout(){ /* backend nanti */ }
</script>



  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
