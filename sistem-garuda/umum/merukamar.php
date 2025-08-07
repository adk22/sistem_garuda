<?php
session_start();
include '../include/koneksi.php';

$query = "SELECT * FROM kamar_meru";
$result = mysqli_query($conn, $query);

$kamar_by_tipe = [];
while ($row = mysqli_fetch_assoc($result)) {
    $tipe = $row['tipe'];
    $kamar_by_tipe[$tipe][] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pemesanan Kamar Meru</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6">
  <div class="mb-8 text-center">
    <h1 class="text-4xl font-bold text-gray-800">MERU</h1>
    <p class="text-gray-500">Pilih kamar sesuai kebutuhan Anda</p>
  </div>

  <?php foreach ($kamar_by_tipe as $tipe => $kamars): ?>
    <div class="bg-white shadow-md rounded-xl p-6 mb-8">
      <h2 class="text-2xl font-semibold mb-4"><?= htmlspecialchars($tipe) ?></h2>
      <div class="grid grid-cols-5 gap-4">
        <div class="col-span-1 flex flex-col items-center space-y-2">
          <?php if (!empty($kamars[0]['gambar'])): ?>
            <img src="../super_admin/gambar_meru/<?= htmlspecialchars($kamars[0]['gambar']) ?>"
                 class="h-40 w-full object-cover rounded-md bg-gray-200"
                 alt="Gambar <?= htmlspecialchars($tipe) ?>">
          <?php else: ?>
            <div class="h-40 w-full bg-gray-200 rounded-md flex items-center justify-center text-gray-400">
              Tidak ada gambar
            </div>
          <?php endif; ?>
        </div>

        <div class="col-span-4 space-y-4">
          <div class="text-sm text-gray-600">
            <?= htmlspecialchars($kamars[0]['fasilitas']) ?>
          </div>

          <table class="w-full table-auto text-sm">
            <thead>
              <tr class="bg-gray-100 text-left">
                <th class="p-2">Pilih Kamar</th>
                <th class="p-2">Tamu</th>
                <th class="p-2">Harga/malam</th>
                <th class="p-2"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($kamars as $kamar): ?>
                <tr class="border-b align-top">
                  <td class="p-2 w-1/2">
                    <div class="font-medium"><?= htmlspecialchars($kamar['nama_kamar']) ?></div>
                    <div class="text-xs text-gray-500"><?= htmlspecialchars($kamar['deskripsi']) ?></div>
                  </td>
                  <td class="p-2">
                    <?= str_repeat("👤", intval($kamar['jumlah_tamu'])) ?>
                  </td>
                  <td class="p-2">
                    <div class="flex flex-col">
                      <?php if ($kamar['harga_diskon'] > 0): ?>
                        <span class="text-sm text-gray-400 line-through">
                          Rp <?= number_format($kamar['harga_asli'], 0, ',', '.') ?>
                        </span>
                        <span class="text-orange-500 font-semibold">
                          Rp <?= number_format($kamar['harga_diskon'], 0, ',', '.') ?>
                        </span>
                      <?php else: ?>
                        <span class="text-orange-500 font-semibold">
                          Rp <?= number_format($kamar['harga_asli'], 0, ',', '.') ?>
                        </span>
                      <?php endif; ?>
                      <span class="text-xs text-gray-500">di luar pajak & biaya</span>
                    </div>
                  </td>
                  <td class="p-2">
                    <?php if ($kamar['sisa_kamar'] > 0): ?>
                      <form method="POST" action="simpan_kamar.php">
                        <input type="hidden" name="hotel" value="Meru">
                        <input type="hidden" name="tipe" value="<?= htmlspecialchars($kamar['tipe']) ?>">
                        <input type="hidden" name="nama_kamar" value="<?= htmlspecialchars($kamar['nama_kamar']) ?>">
                        <input type="hidden" name="jumlah_tamu" value="<?= intval($kamar['jumlah_tamu']) ?>">
                        <input type="hidden" name="harga_diskon" value="<?= $kamar['harga_diskon'] ?>">
                        <input type="hidden" name="harga_asli" value="<?= $kamar['harga_asli'] ?>">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                          Pilih
                        </button>
                      </form>
                    <?php else: ?>
                      <button class="bg-gray-400 cursor-not-allowed text-white px-3 py-1 rounded" disabled>
                        Habis
                      </button>
                    <?php endif; ?>
                    <span class="text-xs text-red-500 mt-1 block">
                      Sisa <?= $kamar['sisa_kamar'] ?> kamar
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

</body>
</html>
