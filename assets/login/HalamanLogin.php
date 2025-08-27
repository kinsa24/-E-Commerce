<?php
//session_start();  // Pastikan session_start() dipanggil untuk setiap halaman yang menggunakan session
require '../backend/backendlogin.php';  // Memasukkan logika backend untuk login
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="HalamanLogin.css">
    <!-- Link ke Toastr CSS untuk Notifikasi Modern -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <h2 class="text-center mt-5">Login</h2>

        <!-- Menampilkan pesan error jika ada -->
        <?php

        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);  // Menghapus error setelah ditampilkan
        }
        ?>

        <!-- Formulir login -->
        <form method="POST" action=""> 
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <div class="mb-3">
                <label for="remember" class="form-label">Ingat Saya</label>
                <input type="checkbox" id="remember" name="remember">
            </div>
            <button type="submit" class="btn btn-primary" id="submit" name="submit">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
    <!-- Link ke Toastr JS untuk Notifikasi Modern -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- <script>
        // Menampilkan pesan error jika ada session error
        <?php if (isset($_SESSION['error'])) { ?>
            toastr.error('<?php echo $_SESSION['error']; ?>', 'Login Gagal!', {
                "positionClass": "toast-top-right",
                "timeOut": 5000 // 5 detik
            });
            <?php unset($_SESSION['error']); // Menghapus error setelah ditampilkan ?>
        <?php } ?>
    </script> -->
</body>

</html>
