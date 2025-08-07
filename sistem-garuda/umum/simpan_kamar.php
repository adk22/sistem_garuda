<?php
session_start();
include '../include/koneksi.php';

// Pastikan user memang mengisi form hotel, bukan hanya tiket
if (!isset($_POST['hotel'])) {
    die("Akses tidak sah.");
}

// Ambil kode tiket dari session
if (!isset($_SESSION['kode_tiket'])) {
    die("Kode tiket tidak ditemukan.");
}
$kode_tiket = $_SESSION['kode_tiket'];

// Generate kode hotel baru
$kode_hotel = 'HOTEL' . time() . rand(100, 999);
$_SESSION['kode_hotel'] = $kode_hotel;

// Ambil data dari form
$hotel        = $_POST['hotel'] ?? '';
$nama_kamar   = $_POST['nama_kamar'] ?? '';
$jum_tamu     = intval($_POST['jumlah_tamu'] ?? 0);
$harga_diskon = intval($_POST['harga_diskon'] ?? 0);
$harga_asli   = intval($_POST['harga_asli'] ?? 0);
$harga_hotel  = ($harga_diskon > 0) ? $harga_diskon : $harga_asli;

// Validasi
if (!$hotel || !$nama_kamar || $jum_tamu <= 0 || $harga_hotel <= 0) {
    die("Data kamar tidak lengkap.");
}

// Update data hotel di pemesanan
$queryUpdate = "UPDATE pemesanan SET 
    kode_hotel = ?, 
    nama_hotel = ?, 
    nama_kamar = ?, 
    jumlah_tamu = ?, 
    harga_hotel = ? 
WHERE kode_tiket = ?";
$stmt = $conn->prepare($queryUpdate);
$stmt->bind_param("sssiss", $kode_hotel, $hotel, $nama_kamar, $jum_tamu, $harga_hotel, $kode_tiket);
$stmt->execute();

// Redirect ke tiket.php
header("Location: tiket.php");
exit;
?>
