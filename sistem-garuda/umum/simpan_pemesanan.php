<?php
$koneksi = new mysqli("localhost", "root", "", "sistem_garuda");

if ($koneksi->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Koneksi gagal: " . $koneksi->connect_error]);
    exit;
}

// Ambil data dari POST
$kode = $_POST['kode'] ?? '';
$asal = $_POST['asal'] ?? '';
$tujuan = $_POST['tujuan'] ?? '';
$jam = $_POST['jam'] ?? '';
$tanggal_berangkat = $_POST['tanggal_berangkat'] ?? '';
$tanggal_pulang = $_POST['tanggal_pulang'] ?? '';
$kelas = $_POST['kelas'] ?? '';
$kursi = $_POST['kursi'] ?? '';
$jumlah_penumpang = $_POST['jumlah_penumpang'] ?? '';
$harga = $_POST['harga'] ?? '';

// Simpan ke tabel pemesanan
$stmt = $koneksi->prepare("INSERT INTO pemesanan (kode_tiket, asal, tujuan, jam, tanggal_berangkat, tanggal_pulang, kelas, kursi, jumlah_penumpang, harga) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssisi", $kode, $asal, $tujuan, $jam, $tanggal_berangkat, $tanggal_pulang, $kelas, $kursi, $jumlah_penumpang, $harga);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "kode" => $kode]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Gagal menyimpan data: " . $stmt->error]);
}
?>
