<?php
$host = "192.168.100.10"; 
$user = "indrakusuma";
$pass = "indra123";
$db   = "sm";

// buat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// cek koneksi
if (!$conn) {
    // gunakan json agar bisa langsung diparse di JS jika error
    die(json_encode([
        "status" => "error",
        "message" => "Koneksi gagal: " . mysqli_connect_error()
    ]));
}

// Koneksi berhasil, tidak ada echo di sini!
// echo "Koneksi database berhasil"; // Hapus ini!
?>