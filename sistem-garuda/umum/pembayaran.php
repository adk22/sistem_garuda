<?php
$koneksi = new mysqli("localhost", "root", "", "sistem_garuda");

if (!isset($_GET['kode_tiket'])) {
  die("Kode tiket tidak ditemukan.");
}

$kode = $koneksi->real_escape_string($_GET['kode_tiket']);

// Ambil data penumpang
$penumpang = $koneksi->query("SELECT * FROM penumpang WHERE kode_tiket = '$kode'");

// Ambil data pemesanan
$pemesanan = $koneksi->query("SELECT * FROM pemesanan WHERE kode_tiket = '$kode'")->fetch_assoc();
if (!$pemesanan) die("Data pemesanan tidak ditemukan.");

// Ambil info tiket
$tiket = $koneksi->query("SELECT * FROM list_tiket WHERE kode = '$kode'")->fetch_assoc();
if (!$tiket) die("Tiket tidak ditemukan.");

// Gabungkan jam
$jam = $tiket['jam_berangkat'] . " - " . $tiket['jam_tiba'];

// Hitung total harga
$total_harga = $penumpang->num_rows * $tiket['harga'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Halaman Pembayaran</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">
  <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow">
    <h1 class="text-3xl font-bold text-center text-blue-900 mb-6">Konfirmasi Pembayaran</h1>

    <div class="mb-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-2">Rincian Tiket</h2>
      <div class="grid md:grid-cols-2 gap-4 text-gray-700">
        <div><strong>Kode Tiket:</strong> <?= htmlspecialchars($kode) ?></div>
        <div><strong>Asal:</strong> <?= htmlspecialchars($pemesanan['asal']) ?></div>
        <div><strong>Tujuan:</strong> <?= htmlspecialchars($pemesanan['tujuan']) ?></div>
        <div><strong>Tanggal Berangkat:</strong> <?= date('d M Y', strtotime($pemesanan['tanggal_berangkat'])) ?></div>
        <?php if (!empty($pemesanan['tanggal_pulang'])) : ?>
          <div><strong>Tanggal Pulang:</strong> <?= date('d M Y', strtotime($pemesanan['tanggal_pulang'])) ?></div>
        <?php endif; ?>
        <div><strong>Jam:</strong> <?= htmlspecialchars($jam) ?></div>
        <div><strong>Kelas:</strong> <?= htmlspecialchars($pemesanan['kelas']) ?></div>
        <div><strong>Kursi:</strong> <?= htmlspecialchars($pemesanan['kursi']) ?></div>
        <div><strong>Jumlah Penumpang:</strong> <?= $penumpang->num_rows ?></div>
        <div><strong>Total Harga:</strong> Rp <?= number_format($total_harga, 0, ',', '.') ?></div>
      </div>
    </div>

    <div class="mb-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-2">Data Penumpang</h2>
      <table class="w-full border text-sm">
        <thead class="bg-blue-100">
          <tr>
            <th class="border px-3 py-2">No</th>
            <th class="border px-3 py-2">Nama</th>
            <th class="border px-3 py-2">Jenis Kelamin</th>
            <th class="border px-3 py-2">Negara</th>
            <th class="border px-3 py-2">Alamat</th>
          </tr>
        </thead>
        <tbody>
        <?php $no = 1; while ($row = $penumpang->fetch_assoc()): ?>
          <tr>
            <td class="border px-2 py-1 text-center"><?= $no++ ?></td>
            <td class="border px-2 py-1"><?= htmlspecialchars($row['nama_lengkap']) ?></td>
            <td class="border px-2 py-1"><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
            <td class="border px-2 py-1"><?= htmlspecialchars($row['negara']) ?></td>
            <td class="border px-2 py-1"><?= htmlspecialchars($row['alamat']) ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <form method="post" class="space-y-4">
      <input type="hidden" name="kode_tiket" value="<?= $kode ?>">
      <input type="hidden" name="total_harga" value="<?= $total_harga ?>">
      
      <div>
        <label class="block font-semibold text-gray-700">Nama Pemesan</label>
        <input type="text" name="nama_pemesan" required class="w-full p-2 border rounded">
      </div>

      <div>
        <label class="block font-semibold text-gray-700">Metode Pembayaran</label>
        <select name="metode_pembayaran" required class="w-full p-2 border rounded">
          <option value="">-- Pilih --</option>
          <option value="Transfer BCA">Transfer BCA</option>
          <option value="Transfer BRI">Transfer BRI</option>
          <option value="Transfer BNI">Transfer BNI</option>
          <option value="QRIS">QRIS</option>
        </select>
      </div>

      <button type="submit" name="submit_pembayaran" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
        Lanjutkan Pembayaran
      </button>
    </form>
  </div>

<?php
if (isset($_POST['submit_pembayaran'])) {
  $nama_pemesan = $koneksi->real_escape_string($_POST['nama_pemesan']);
  $metode = $koneksi->real_escape_string($_POST['metode_pembayaran']);

  $koneksi->query("INSERT INTO pembayaran (kode_tiket, nama_pemesan, total_harga, metode_pembayaran)
    VALUES ('$kode', '$nama_pemesan', '$total_harga', '$metode')");

  echo "<script>alert('Pembayaran berhasil dicatat!'); window.location.href='tiket_sukses.php?kode_tiket=$kode';</script>";
}
?>
</body>
</html>
