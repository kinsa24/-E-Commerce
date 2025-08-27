<?php
session_start();
include 'db/database.php';

global $database;

// Cek apakah user sudah login (dari cookie atau session)
// if (isset($_COOKIE['login']) && $_COOKIE['login'] === 'true') {
//     $_SESSION['login'] = true;  // Menyimpan status login ke session
// }

// // Jika sudah login, arahkan ke halaman dashboard
// if (isset($_SESSION['login'])) {
//     header("Location: ../dashboard/Dashboard.php");
//     exit;
// }

// Proses form login
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
   // $remember = $_POST['remember'];

    // Query untuk mencari username di database
    $stmt = $database->prepare("SELECT * FROM logindb WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika username ditemukan
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Set session login
            $_SESSION['login'] = true;

            // Jika checkbox "Ingat Saya" dicentang, set cookie
            if (isset($_POST['remember'])) {
                setcookie('login', 'true', time() + 1, '/');  // Cookie valid selama 1 detik
            }

            // Redirect ke halaman dashboard
            header("Location: ../dashboard/Dashboard.php");
            exit;
        }
    }

    // Jika username atau password salah
    $error = true;
}

// Jika ada error, tampilkan pesan error
if (isset($error)) {
    echo '<script>alert("Username atau password salah.");</script>';
}

?>
