<?php
$database = mysqli_connect("localhost", "root", "", "klinik");

if (!$database) {
    die("Connection failed: " . mysqli_connect_error());
}

?>