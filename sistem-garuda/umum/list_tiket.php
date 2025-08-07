<?php
session_start();
unset($_SESSION['kode_hotel']); // Reset pilihan hotel setiap load halaman ini

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "sistem_garuda");

// Cek koneksi
if ($koneksi->connect_error) {
  die("Koneksi gagal: " . $koneksi->connect_error);
}

// Query ambil tiket dan promo
$sql = "SELECT l.*, p.diskon_persen 
        FROM list_tiket l 
        LEFT JOIN promo p ON l.kode_promo = p.kode 
        ORDER BY l.id DESC";

$result = $koneksi->query($sql);
$tiketList = [];

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $hargaPromo = null;
    if (!is_null($row['diskon_persen'])) {
      $hargaPromo = $row['harga'] - ($row['harga'] * $row['diskon_persen'] / 100);
    }

    $tiketList[] = [
      "kode" => $row['kode'],
      "asal" => $row['asal'],
      "tujuan" => $row['tujuan'],
      "jam_berangkat" => substr($row['jam_berangkat'], 0, 5),
      "jam_tiba" => substr($row['jam_tiba'], 0, 5),
      "harga" => $row['harga'],
      "harga_promo" => $hargaPromo,
      "kelas" => $row['kelas'],
      "keterangan_waktu" => $row['keterangan_waktu'],
      "jumlah_kursi" => $row['jumlah_kursi']
    ];
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Tiket Penerbangan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">
  <div class="max-w-5xl mx-auto px-4">
    <h1 class="text-3xl font-bold text-center text-blue-900 mb-6">Pilih Tiket Penerbangan</h1>

    <div class="grid gap-6">
      <?php if (count($tiketList) > 0): ?>
        <?php foreach ($tiketList as $tiket): ?>
          <div class="bg-white rounded-xl shadow-md p-6 flex flex-col md:flex-row justify-between items-start md:items-center">
            <div class="mb-4 md:mb-0">
              <h2 class="text-xl font-semibold text-blue-800">Garuda Indonesia</h2>
              <p class="text-gray-600 text-sm mt-1"><?= htmlspecialchars($tiket['asal']) ?> → <?= htmlspecialchars($tiket['tujuan']) ?></p>
              <p class="text-gray-600 text-sm">Jam: <?= htmlspecialchars($tiket['jam_berangkat']) ?> - <?= htmlspecialchars($tiket['jam_tiba']) ?> (<?= htmlspecialchars($tiket['keterangan_waktu']) ?>)</p>
              <p class="text-gray-600 text-sm">Kelas: <?= htmlspecialchars($tiket['kelas']) ?></p>
              <p class="text-gray-600 text-sm">Sisa Kursi: <?= $tiket['jumlah_kursi'] ?></p>
            </div>

            <div class="flex flex-col items-end">
              <?php if ($tiket['harga_promo']): ?>
                <p class="text-lg font-bold text-green-700 mb-1">Rp<?= number_format($tiket['harga_promo'], 0, ',', '.') ?></p>
                <p class="text-sm text-gray-500 line-through mb-2">Rp<?= number_format($tiket['harga'], 0, ',', '.') ?></p>
              <?php else: ?>
                <p class="text-lg font-bold text-green-700 mb-2">Rp<?= number_format($tiket['harga'], 0, ',', '.') ?></p>
              <?php endif; ?>

              <form action="tiket.php" method="get">
                <input type="hidden" name="kode" value="<?= htmlspecialchars($tiket['kode']) ?>">
                <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded">Pilih Tiket</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center text-red-500">Tidak ada data tiket ditemukan.</p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
