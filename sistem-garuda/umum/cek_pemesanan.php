<?php
$koneksi = new mysqli("localhost", "root", "", "sistem_garuda");

$total = $koneksi->query("SELECT SUM(jumlah_penumpang) as total FROM pemesanan_tiket")->fetch_assoc()['total'] ?? 0;
$config = $koneksi->query("SELECT * FROM tiket_config LIMIT 1")->fetch_assoc();

echo json_encode([
    'jumlah' => (int)$total,
    'batas' => (int)($config['batas_penumpang'] ?? 20)
]);
?>
