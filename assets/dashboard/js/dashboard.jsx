// Dashboard SPA: render Produk, Belanja, dan Hasil Belanja dalam satu halaman

// Helper format Rupiah
const fmtIDR = (n) => new Intl.NumberFormat('id-ID').format(n || 0);

// Sumber data produk (samakan dengan daftar_produk.php)
const products = [
  { id: 'P001', name: 'Sepatu Puma Original', price: 499000, img: '../img/puma2.jpg' },
  { id: 'P002', name: 'Sepatu Puma Original 2', price: 539000, img: '../img/puma1.jpg' },
  { id: 'P003', name: 'Sepatu Nike Original', price: 699000, img: '../img/sepatu_paul.jpeg' }
];

// Update kartu ringkas pada Dashboard
function updateDashboardStats() {
  const history = JSON.parse(sessionStorage.getItem('orderHistory') || '[]');

  const totalQty = history.reduce((sum, o) => sum + (o.items || []).reduce((s, it) => s + (it.quantity || 0), 0), 0);
  const totalAmount = history.reduce((sum, o) => sum + (o.total || 0), 0);

  const qtyEl = document.getElementById('cartQty');
  const totalEl = document.getElementById('cartTotal');
  const prodEl = document.getElementById('totalProducts');
  if (qtyEl) qtyEl.textContent = String(totalQty);
  if (totalEl) totalEl.textContent = 'Rp ' + fmtIDR(totalAmount);
  if (prodEl) prodEl.textContent = String(products.length);
}

// Render daftar produk ke section #produk-list
function renderProducts() {
  const wrap = document.getElementById('produk-list');
  if (!wrap) return;
  wrap.innerHTML = products.map(p => `
    <div class="col">
      <div class="card h-100" style="width: 18rem;">
        <img src="${p.img}" class="card-img-top" alt="${p.name}">
        <div class="card-body">
          <h5 class="card-title">${p.name}</h5>
          <p class="card-text">Harga: Rp ${fmtIDR(p.price)}</p>
          <button class="btn btn-primary" onclick='goToCart(${JSON.stringify(p)})'>Checkout</button>
        </div>
      </div>
    </div>
  `).join('');
}

// Simpan produk yang dipilih ke sessionStorage dan arahkan ke Belanja
function goToCart(item) {
  try {
    sessionStorage.removeItem('lastOrder');
    sessionStorage.setItem('pendingItem', JSON.stringify(item));
    loadPage('belanja');
  } catch (e) {
    console.error(e);
    alert('Gagal menambahkan ke keranjang.');
  }
}
window.goToCart = goToCart;

// Render halaman belanja di section #belanja
function renderBelanja() {
  const left = document.getElementById('cartItems');
  if (!left) return;

  // Sembunyikan tombol Checkout statis bawaan Dashboard.php (kita pakai tombol sendiri)
  const staticCheckoutBtn = document.querySelector('#belanja > button.btn.btn-success');
  if (staticCheckoutBtn) staticCheckoutBtn.style.display = 'none';

  const raw = sessionStorage.getItem('pendingItem');
  if (!raw) {
    left.innerHTML = `
      <div class="card shadow-sm">
        <div class="card-body text-center">
          <i class="bi bi-cart-x fs-1 text-secondary"></i>
          <h5 class="mt-2 mb-1">Keranjang kosong</h5>
          <p class="text-secondary mb-3">Silakan pilih produk terlebih dahulu untuk melanjutkan.</p>
          <button class="btn btn-primary" onclick="loadPage('produk')">
            <i class="bi bi-bag-plus me-1"></i> Lihat Produk
          </button>
        </div>
      </div>`;
    return;
  }

  const item = JSON.parse(raw);
  left.innerHTML = `
    <div class="card shadow-sm">
      <div class="row g-0">
        <div class="col-md-5">
          <img src="${item.img}" alt="${item.name}" class="img-fluid rounded-start h-100" style="object-fit:cover;">
        </div>
        <div class="col-md-7">
          <div class="card-body">
            <h5 class="card-title mb-1">${item.name}</h5>
            <div class="text-secondary small mb-2">ID: ${item.id}</div>
            <div class="fw-bold fs-5 mb-3">Rp <span id="price">${fmtIDR(item.price)}</span></div>

            <div class="mb-3">
              <label class="form-label">Jumlah</label>
              <input type="number" id="qty" class="form-control" min="1" value="1">
            </div>

            <div class="mb-3">
              <div class="small text-secondary">Subtotal</div>
              <div class="h5">Rp <span id="subtotal">${fmtIDR(item.price)}</span></div>
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
    subtotalEl.textContent = fmtIDR(q * item.price);
  });

  document.getElementById('btnBuy').addEventListener('click', () => checkout());
  document.getElementById('btnCancel').addEventListener('click', () => {
    sessionStorage.removeItem('pendingItem');
    renderBelanja();
    updateDashboardStats();
  });
}

// Proses checkout: simpan ke orderHistory dan alihkan ke hasil
function checkout() {
  const raw = sessionStorage.getItem('pendingItem');
  if (!raw) {
    alert('Keranjang kosong.');
    return;
  }
  const item = JSON.parse(raw);
  const qtyEl = document.getElementById('qty');
  const qty = Math.max(1, parseInt((qtyEl && qtyEl.value) || '1', 10));

  const order = {
    id: 'INV-' + Date.now(),
    items: [{ ...item, quantity: qty }],
    total: qty * item.price,
    created_at: new Date().toISOString()
  };

  const key = 'orderHistory';
  const history = JSON.parse(sessionStorage.getItem(key) || '[]');
  history.push(order);
  sessionStorage.setItem(key, JSON.stringify(history));

  sessionStorage.removeItem('pendingItem');
  updateDashboardStats();
  loadPage('hasil');
}
window.checkout = checkout;

// Render hasil belanja/riwayat ke section #orderSummary
function renderHasil() {
  const wrap = document.getElementById('orderSummary');
  if (!wrap) return;

  const key = 'orderHistory';
  const history = JSON.parse(sessionStorage.getItem(key) || '[]');

  if (history.length === 0) {
    wrap.innerHTML = `
      <div class="alert alert-info text-center">
        Belum ada transaksi.<br>
        <button class="btn btn-primary mt-2" onclick="loadPage('produk')">
          <i class="bi bi-shop-window me-1"></i> Belanja
        </button>
      </div>`;
    return;
  }

  const list = [...history].reverse();

  wrap.innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">Riwayat Belanja</h4>
      <div class="d-flex gap-2">
        <button class="btn btn-primary" onclick="loadPage('produk')">
          <i class="bi bi-bag me-1"></i> Belanja Lagi
        </button>
        <button class="btn btn-outline-danger" id="btnClearAll">
          <i class="bi bi-trash me-1"></i> Hapus Riwayat
        </button>
      </div>
    </div>
    <div id="ordersContainer"></div>
  `;

  const container = document.getElementById('ordersContainer');
  container.innerHTML = list.map((order, idx) => {
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

  const clearBtn = document.getElementById('btnClearAll');
  if (clearBtn) {
    clearBtn.addEventListener('click', () => {
      sessionStorage.removeItem(key);
      updateDashboardStats();
      renderHasil();
    });
  }
}

function deleteOne(index) {
  const key = 'orderHistory';
  const history = JSON.parse(sessionStorage.getItem(key) || '[]');
  history.splice(index, 1);
  sessionStorage.setItem(key, JSON.stringify(history));
  updateDashboardStats();
  renderHasil();
}
window.deleteOne = deleteOne;

// Show/hide section dan panggil renderer sesuai tab
function loadPage(page) {
  const sections = ['dashboard', 'produk', 'belanja', 'hasil'];
  sections.forEach(id => {
    const el = document.getElementById(id);
    if (el) el.style.display = (id === page ? 'block' : 'none');
  });

  if (page === 'produk') {
    renderProducts();
  } else if (page === 'belanja') {
    renderBelanja();
  } else if (page === 'hasil') {
    renderHasil();
  } else if (page === 'dashboard') {
    updateDashboardStats();
  }
}
window.loadPage = loadPage;

// Placeholder logout
function logout() {
  alert('Logout berhasil');
}
window.logout = logout;

// Init saat halaman siap
(document.addEventListener('DOMContentLoaded', () => {
  updateDashboardStats();
  // Default: tampilkan dashboard; section lain disembunyikan di HTML
  // Jika ada hash, gunakan
  const hash = (location.hash || '').replace('#', '');
  if (['dashboard','produk','belanja','hasil'].includes(hash)) {
    loadPage(hash);
  }
}));
