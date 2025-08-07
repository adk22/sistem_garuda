<?php
include '../include/koneksi.php';

// Mode edit
$edit_mode = false;
$edit_data = [];

if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM kamar_meru WHERE id=$id");
    $edit_data = mysqli_fetch_assoc($result);
}

// Simpan data
if (isset($_POST['simpan'])) {
    $tipe = $_POST['tipe'];
    $nama_kamar = $_POST['nama_kamar'];
    $deskripsi = $_POST['deskripsi'];
    $fasilitas = $_POST['fasilitas'];
    $jumlah_tamu = $_POST['jumlah_tamu'];
    $harga_asli = $_POST['harga_asli'];
    $harga_diskon = $_POST['harga_diskon'];
    $sisa_kamar = $_POST['sisa_kamar'];

    $gambar = '';
    if (!empty($_FILES['gambar']['name'])) {
        $targetDir = 'gambar_meru/';
        $gambar = basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $targetDir . $gambar);
    }

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        if ($gambar != '') {
            $query = "UPDATE kamar_meru SET tipe='$tipe', nama_kamar='$nama_kamar', deskripsi='$deskripsi',
                      fasilitas='$fasilitas', jumlah_tamu='$jumlah_tamu', harga_asli='$harga_asli',
                      harga_diskon='$harga_diskon', sisa_kamar='$sisa_kamar', gambar='$gambar'
                      WHERE id=$id";
        } else {
            $query = "UPDATE kamar_meru SET tipe='$tipe', nama_kamar='$nama_kamar', deskripsi='$deskripsi',
                      fasilitas='$fasilitas', jumlah_tamu='$jumlah_tamu', harga_asli='$harga_asli',
                      harga_diskon='$harga_diskon', sisa_kamar='$sisa_kamar' WHERE id=$id";
        }
    } else {
        $query = "INSERT INTO kamar_meru (tipe, nama_kamar, deskripsi, fasilitas, jumlah_tamu,
                  harga_asli, harga_diskon, sisa_kamar, gambar)
                  VALUES ('$tipe', '$nama_kamar', '$deskripsi', '$fasilitas', '$jumlah_tamu',
                  '$harga_asli', '$harga_diskon', '$sisa_kamar', '$gambar')";
    }

    mysqli_query($conn, $query);
    header("Location: merusanur_kamar.php");
    exit();
}

// Hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar FROM kamar_meru WHERE id=$id"));
    if ($data && file_exists("gambar_meru/" . $data['gambar'])) {
        unlink("gambar_meru/" . $data['gambar']);
    }
    mysqli_query($conn, "DELETE FROM kamar_meru WHERE id=$id");
    header("Location: merusanur_kamar.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM kamar_meru ORDER BY tipe ASC, id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Kamar Meru Sanur</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6">

  <a href="hotel_control.php" class="fixed top-4 left-4 bg-blue-600 text-white p-3 rounded-full shadow-md hover:bg-blue-700 transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
  </a>

  <h1 class="text-3xl font-bold text-center mb-6">Kelola Kamar - Meru Sanur</h1>

  <div class="bg-white p-6 rounded shadow-md mb-8 max-w-4xl mx-auto">
    <h2 class="text-xl font-semibold mb-4"><?= $edit_mode ? 'Edit Kamar' : 'Tambah Kamar Baru' ?></h2>
    <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-2 gap-4">
      <?php if ($edit_mode): ?>
        <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
      <?php endif; ?>
      <input type="text" name="tipe" placeholder="Tipe Kamar" value="<?= $edit_mode ? $edit_data['tipe'] : '' ?>" required class="p-2 border rounded">
      <input type="text" name="nama_kamar" placeholder="Nama Kamar" value="<?= $edit_mode ? $edit_data['nama_kamar'] : '' ?>" required class="p-2 border rounded">
      <input type="text" name="deskripsi" placeholder="Deskripsi" value="<?= $edit_mode ? $edit_data['deskripsi'] : '' ?>" class="p-2 border rounded">
      <input type="text" name="fasilitas" placeholder="Fasilitas" value="<?= $edit_mode ? $edit_data['fasilitas'] : '' ?>" class="p-2 border rounded">
      <input type="number" name="jumlah_tamu" placeholder="Jumlah Tamu" value="<?= $edit_mode ? $edit_data['jumlah_tamu'] : '' ?>" class="p-2 border rounded">
      <input type="number" name="harga_asli" placeholder="Harga Asli" value="<?= $edit_mode ? $edit_data['harga_asli'] : '' ?>" class="p-2 border rounded">
      <input type="number" name="harga_diskon" placeholder="Harga Diskon" value="<?= $edit_mode ? $edit_data['harga_diskon'] : '' ?>" class="p-2 border rounded">
      <input type="number" name="sisa_kamar" placeholder="Sisa Kamar" value="<?= $edit_mode ? $edit_data['sisa_kamar'] : '' ?>" class="p-2 border rounded">
      <input type="file" name="gambar" accept="image/*" class="p-2 border rounded col-span-2">
      <button type="submit" name="simpan" class="bg-blue-600 text-white px-4 py-2 rounded col-span-2">
        <?= $edit_mode ? 'Update' : 'Tambah' ?>
      </button>
    </form>
  </div>

  <div class="bg-white p-6 rounded shadow-md max-w-6xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">Daftar Kamar</h2>
    <div class="overflow-x-auto">
      <table class="w-full text-sm table-auto">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2">Tipe</th>
            <th class="p-2">Nama</th>
            <th class="p-2">Deskripsi</th>
            <th class="p-2">Tamu</th>
            <th class="p-2">Harga</th>
            <th class="p-2">Diskon</th>
            <th class="p-2">Sisa</th>
            <th class="p-2">Gambar</th>
            <th class="p-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr class="border-b">
              <td class="p-2"><?= htmlspecialchars($row['tipe']) ?></td>
              <td class="p-2"><?= htmlspecialchars($row['nama_kamar']) ?></td>
              <td class="p-2"><?= htmlspecialchars($row['deskripsi']) ?></td>
              <td class="p-2"><?= $row['jumlah_tamu'] ?> org</td>
              <td class="p-2">Rp <?= number_format($row['harga_asli'], 0, ',', '.') ?></td>
              <td class="p-2 text-orange-600">Rp <?= number_format($row['harga_diskon'], 0, ',', '.') ?></td>
              <td class="p-2"><?= $row['sisa_kamar'] ?></td>
              <td class="p-2">
                <?php if ($row['gambar']) : ?>
                  <img src="gambar_meru/<?= $row['gambar'] ?>" class="h-12 w-20 object-cover rounded">
                <?php else : ?>
                  <span class="text-gray-400 italic">Tidak ada</span>
                <?php endif; ?>
              </td>
              <td class="p-2 space-x-2">
                <a href="?edit=<?= $row['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
                <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus kamar ini?')" class="text-red-600 hover:underline">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
