<?php
//session_start(); // Start session to handle errors or messages
include '../backend/backendregis.php'; // Include the backend registration logic
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>

    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <!-- Link ke Font Awesome untuk ikon jika dibutuhkan -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="HalamanRegistrasi.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
</head>

<body>



    <div class="container">
        <h2 class="text-center mt-5">Registrasi</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username"
                    required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Masukkan password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                    placeholder="Konfirmasi password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit" id="submit">Daftar</button>
        </form>
    </div>

    <!-- Link ke Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- <script src="../js/LandingPage.jsx"></script> -->
     
        
        <!-- // Menampilkan pesan sukses jika ada session alert_message
        // if (isset($_SESSION['alert_message'])) {
        //     echo '<div class="alert alert-success" role="alert">' . $_SESSION['alert_message'] . '</div>';
        //     unset($_SESSION['alert_message']); // Menghapus alert message setelah ditampilkan
        // }

        // Menampilkan pesan error jika ada session error
        // if (isset($_SESSION['error'])) {
        //     echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
        //     unset($_SESSION['error']); // Menghapus error setelah ditampilkan
        // }
          -->


</body>

</html>