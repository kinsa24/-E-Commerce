<?php
//session_start();
include 'db/database.php';  // Menghubungkan ke database

function registrasi($data) {
    global $database;

    $username =strtolower(stripslashes($data["username"]));
    $password =mysqli_real_escape_string($database, $data["password"]);
    $password_confirm =mysqli_real_escape_string($database, $data["confirm_password"]);

    $result = mysqli_query($database, "SELECT username FROM logindb WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Username sudah terdaftar, coba gunakan username lain.');
              </script>";
        return false;
    }

    if ($password !== $password_confirm) {
        echo "<script>
                alert('Konfirmasi password tidak cocok!');
              </script>";
        return false;
    }

    if (strlen($password) < 3) {
        echo "<script>
                alert('Password terlalu pendek! Minimal 3 karakter.');
              </script>";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($database, "INSERT INTO logindb VALUES ('','$username', '$password')");

    return mysqli_affected_rows($database);

}

if (isset($_POST["submit"])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
                alert('Akun sudah terdaftar, Anda dapat login sekarang.');
                document.location.href = '../login/HalamanLogin.php';
              </script>";
    } else {
                echo "<script>
            alert (
            
            'user gagal di tambahkan')
            </script>";
    }
}
 ?>
