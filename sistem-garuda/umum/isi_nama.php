<?php
session_start();
include '../include/koneksi.php';

$kodeTiket = $_SESSION['kode_tiket'] ?? null;
$data = [];

if ($kodeTiket) {
    $result = mysqli_query($conn, "SELECT * FROM pemesanan WHERE kode_tiket = '$kodeTiket'");
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    }
}

$jumlahPenumpang = isset($data['jumlah_penumpang']) && (int)$data['jumlah_penumpang'] > 0
    ? (int)$data['jumlah_penumpang']
    : 1;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Isi Data Penumpang</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .fade-in {
      animation: fadeIn 0.8s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }
    input[type="radio"] {
      accent-color: #2563eb;
      width: 18px;
      height: 18px;
    }
  </style>
</head>
<body class="bg-gray-100 py-10">
  <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-md p-6 fade-in">
    <h1 class="text-3xl font-bold text-center text-blue-900 mb-8">Data Penumpang & Rincian Tiket</h1>

    <div class="grid md:grid-cols-2 gap-8">
      <!-- Kiri: Rincian Tiket -->
      <div class="bg-blue-50 p-5 rounded-lg shadow-sm fade-in text-sm text-gray-700 space-y-2">
        <h2 class="text-xl font-semibold mb-4 text-blue-800">Preview Tiket</h2>
        <?php if (!empty($data)): ?>
          <div><strong>Kode Tiket:</strong> <?= htmlspecialchars($data['kode_tiket']) ?></div>
          <div><strong>Asal:</strong> <?= htmlspecialchars($data['asal']) ?></div>
          <div><strong>Tujuan:</strong> <?= htmlspecialchars($data['tujuan']) ?></div>
          <div><strong>Jam Berangkat:</strong> <?= htmlspecialchars($data['jam_keberangkatan']) ?></div>
          <div><strong>Jam Tiba:</strong> <?= htmlspecialchars($data['jam_tiba']) ?></div>
          <div><strong>Tanggal Berangkat:</strong> <?= htmlspecialchars($data['tanggal_berangkat']) ?></div>
          <div><strong>Tanggal Pulang:</strong> <?= htmlspecialchars($data['tanggal_pulang'] ?? '-') ?></div>
          <div><strong>Kelas:</strong> <?= htmlspecialchars($data['kelas']) ?></div>
          <div><strong>Kursi:</strong> <?= htmlspecialchars($data['kursi']) ?></div>
          <div><strong>Jumlah Penumpang:</strong> <?= $jumlahPenumpang ?></div>
          <div><strong>Total Harga Tiket:</strong> Rp <?= number_format($data['harga'], 0, ',', '.') ?></div>

          <?php if (!empty($data['nama_hotel'])): ?>
            <hr class="my-3 border-gray-300">
            <h2 class="text-xl font-semibold text-blue-800 mt-4">Hotel yang Dipesan</h2>
            <div><strong>Nama Hotel:</strong> <?= htmlspecialchars($data['nama_hotel']) ?></div>
            <div><strong>Nama Kamar:</strong> <?= htmlspecialchars($data['nama_kamar']) ?></div>
            <div><strong>Jumlah Tamu:</strong> <?= $data['jumlah_tamu'] ?></div>
            <div><strong>Total Harga Hotel:</strong> Rp <?= number_format($data['harga_hotel'], 0, ',', '.') ?></div>
          <?php endif; ?>
        <?php else: ?>
          <p class="text-red-500">Data tiket tidak ditemukan.</p>
        <?php endif; ?>
      </div>

      <!-- Kanan: Form Penumpang -->
      <div class="fade-in">
        <?php if (!empty($data)): ?>
          <form method="POST" action="simpanpenumpang.php" class="space-y-4">
            <?php for ($i = 1; $i <= $jumlahPenumpang; $i++): ?>
              <div class="border p-4 rounded-md bg-gray-50 shadow-sm fade-in">
                <h3 class="font-semibold mb-2 text-blue-700">Penumpang <?= $i ?></h3>
                <input type="text" name="nama_lengkap[]" placeholder="Nama Lengkap" required class="w-full p-2 border rounded mb-2">
                
                <div class="mb-2">
                  <label class="block text-gray-600 mb-1">Jenis Kelamin:</label>
                  <div class="flex items-center space-x-6">
                    <label class="flex items-center space-x-2">
                      <input type="radio" name="jenis_kelamin[<?= $i ?>]" value="Laki-laki" required>
                      <span>Laki-laki</span>
                    </label>
                    <label class="flex items-center space-x-2">
                      <input type="radio" name="jenis_kelamin[<?= $i ?>]" value="Perempuan" required>
                      <span>Perempuan</span>
                    </label>
                  </div>
                </div>
 <input type="text" name="negara[]" placeholder="Negara" required class="w-full p-2 border rounded">
                <input type="text" name="alamat[]" placeholder="Alamat Lengkap" required class="w-full p-2 border rounded mb-2">
              </div>
            <?php endfor; ?>

            <input type="hidden" name="kode_tiket" value="<?= htmlspecialchars($data['kode_tiket']) ?>">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 transition w-full mt-4">
              Simpan Data Penumpang
            </button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>
