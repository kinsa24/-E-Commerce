<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shoes Original Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Shoes Original Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="Dashboard.php" onclick="loadPage('dashboard')">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="daftar_produk.php" onclick="loadPage('produk')">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="keranjang_belanja.php" onclick="loadPage('belanja')">Belanja</a></li>
                    <li class="nav-item"><a class="nav-link" href="hasil_belanja.php" onclick="loadPage('hasil')">Hasil Belanja</a></li>
                    <li class="nav-item ms-auto">
                        <button class="btn btn-outline-danger" onclick="logout()">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div id="content-container" class="container mt-4">
        <div id="dashboard">
            <h2>Dashboard</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card p-3">
                        <h5>Produk di Keranjang</h5>
                        <p id="cartQty">0</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3">
                        <h5>Total Keranjang</h5>
                        <p id="cartTotal">Rp 0</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3">
                        <h5>Total Produk</h5>
                        <p id="totalProducts">6</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="produk" style="display:none;">
            <h2>Produk</h2>
            <div class="row" id="produk-list">
                <!-- Produk list akan diisi menggunakan JS -->
            </div>
        </div>

        <div id="belanja" style="display:none;">
            <h2>Keranjang Belanja</h2>
            <div id="cartItems">
                <!-- Items in cart -->
            </div>
            <button class="btn btn-success" onclick="checkout()">Checkout</button>
        </div>

        <div id="hasil" style="display:none;">
            <h2>Hasil Belanja</h2>
            <div id="orderSummary">
                <!-- Summary hasil belanja -->
            </div>
        </div>
    </div>

    <script src="js/dashboard.jsx"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
