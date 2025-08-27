<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shoes Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="css/dashboard.css">
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
        <li class="nav-item"><a class="nav-link active" href="daftar_produk.php">Produk</a></li>
        <li class="nav-item"><a class="nav-link" href="keranjang_belanja.php">Belanja</a></li>
        <li class="nav-item"><a class="nav-link" href="hasil_belanja.php">Hasil Belanja</a></li>
        <li class="nav-item ms-auto">
          <button class="btn btn-outline-danger" onclick="logout()">Logout</button>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4" id="produk-list">

    <!-- Produk 1 -->
    <div class="col">
      <div class="card h-100" style="width: 18rem;">
        <img src="../img/puma2.jpg" class="card-img-top" alt="Sepatu Puma Original">
        <div class="card-body">
          <h5 class="card-title">Sepatu Puma Original</h5>
          <p class="card-text">Deskripsi produk 1.</p>
          <button class="btn btn-primary"
            onclick="goToCart({id:'P001', name:'Sepatu Puma Original', price:499000, img:'../img/puma2.jpg'})">
            Checkout
          </button>
        </div>
      </div>
    </div>

    <!-- Produk 2 -->
    <div class="col">
      <div class="card h-100" style="width: 18rem;">
        <img src="../img/puma1.jpg" class="card-img-top" alt="Sepatu Puma Original">
        <div class="card-body">
          <h5 class="card-title">Sepatu Puma Original</h5>
          <p class="card-text">Deskripsi produk 2.</p>
          <button class="btn btn-primary"
            onclick="goToCart({id:'P002', name:'Sepatu Puma Original 2', price:539000, img:'../img/puma1.jpg'})">
            Checkout
          </button>
        </div>
      </div>
    </div>

    <!-- Produk 3 -->
    <div class="col">
      <div class="card h-100" style="width: 18rem;">
        <img src="../img/sepatu_paul.jpeg" class="card-img-top" alt="Sepatu Nike Original">
        <div class="card-body">
          <h5 class="card-title">Sepatu Nike Original</h5>
          <p class="card-text">Deskripsi produk 3.</p>
          <button class="btn btn-primary"
            onclick="goToCart({id:'P003', name:'Sepatu Nike Original', price:699000, img:'../img/sepatu_paul.jpeg'})">
            Checkout
          </button>
        </div>
      </div>
    </div>

    <!-- Tambah produk lain sesuai kebutuhan... -->

  </div>
</div>

<script>
  function goToCart(item){
    // hapus state lama, simpan produk terpilih
    sessionStorage.removeItem('lastOrder');
    sessionStorage.setItem('pendingItem', JSON.stringify(item));
    // redirect ke halaman belanja
    window.location.href = 'keranjang_belanja.php';
  }
  function logout(){ /* nanti isi backend */ }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
