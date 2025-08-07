<?php
$koneksi = new mysqli("localhost", "root", "", "sistem_garuda");

$edit = false;
$edit_data = null;

// Ambil data untuk diedit
if (isset($_GET['edit'])) {
  $edit_id = $_GET['edit'];
  $result = $koneksi->query("SELECT * FROM hotel_control WHERE id = $edit_id");
  $edit_data = $result->fetch_assoc();
  $edit = true;
}

// Simpan data baru
if (isset($_POST['simpan'])) {
  $nama = $_POST['nama'];
  $deskripsi = $_POST['deskripsi'];
  $rating = $_POST['rating'];
  $harga = $_POST['harga'];
  $link_kamar = $_POST['link_kamar'];

  $gambar = $_FILES['gambar']['name'];
  $tmp = $_FILES['gambar']['tmp_name'];
  $folder = "hotel_control/" . $gambar;

  if (move_uploaded_file($tmp, $folder)) {
    $koneksi->query("INSERT INTO hotel_control (nama, deskripsi, gambar, rating, harga, link_kamar) 
                     VALUES ('$nama', '$deskripsi', '$gambar', '$rating', '$harga', '$link_kamar')");
    echo "<script>alert('Data berhasil disimpan!'); window.location='hotel_control.php';</script>";
  } else {
    echo "<script>alert('Gagal upload gambar.');</script>";
  }
}

// Update data hotel
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $nama = $_POST['nama'];
  $deskripsi = $_POST['deskripsi'];
  $rating = $_POST['rating'];
  $harga = $_POST['harga'];
  $link_kamar = $_POST['link_kamar'];

  if (!empty($_FILES['gambar']['name'])) {
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $folder = "hotel_control/" . $gambar;

    if (move_uploaded_file($tmp, $folder)) {
      $koneksi->query("UPDATE hotel_control SET nama='$nama', deskripsi='$deskripsi', gambar='$gambar',
                        rating='$rating', harga='$harga', link_kamar='$link_kamar' WHERE id=$id");
    }
  } else {
    $koneksi->query("UPDATE hotel_control SET nama='$nama', deskripsi='$deskripsi',
                      rating='$rating', harga='$harga', link_kamar='$link_kamar' WHERE id=$id");
  }

  echo "<script>alert('Data berhasil diperbarui!'); window.location='hotel_control.php';</script>";
}

// Hapus data hotel
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $koneksi->query("DELETE FROM hotel_control WHERE id=$id");
  echo "<script>window.location='hotel_control.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Kontrol Hotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .main-content {
      margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
      padding: 20px;
    }
  </style>
</head>
<body>
  <?php include '../include/sidebar_admin.php'; ?>

  <div class="main-content">
    <div class="container">
      <h2 class="mb-4 text-center">Kontrol Hotel</h2>

      <!-- Form tambah/edit hotel -->
      <form method="post" enctype="multipart/form-data" class="card p-4 shadow-sm mb-5">
        <h4 class="mb-3"><?= $edit ? 'Edit Hotel' : 'Tambah Hotel' ?></h4>
        <?php if ($edit): ?>
          <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
        <?php endif; ?>
        <div class="mb-2">
          <label>Nama Hotel</label>
          <input type="text" name="nama" required class="form-control"
                 value="<?= $edit ? htmlspecialchars($edit_data['nama']) : '' ?>">
        </div>
        <div class="mb-2">
          <label>Deskripsi</label>
          <textarea name="deskripsi" required class="form-control"><?= $edit ? htmlspecialchars($edit_data['deskripsi']) : '' ?></textarea>
        </div>
        <div class="mb-2">
          <label>Rating</label>
          <input type="number" step="0.1" name="rating" required class="form-control"
                 value="<?= $edit ? $edit_data['rating'] : '' ?>">
        </div>
        <div class="mb-2">
          <label>Harga</label>
          <input type="number" name="harga" required class="form-control"
                 value="<?= $edit ? $edit_data['harga'] : '' ?>">
        </div>
        <div class="mb-2">
          <label>Link Kamar</label>
          <input type="text" name="link_kamar" required class="form-control"
                 value="<?= $edit ? htmlspecialchars($edit_data['link_kamar']) : '' ?>">
        </div>
        <div class="mb-3">
          <label>Gambar <?= $edit ? '(opsional jika tidak ingin ganti)' : '' ?></label>
          <input type="file" name="gambar" accept="image/*" class="form-control">
          <?php if ($edit): ?>
            <small class="text-muted">Gambar sekarang: <?= $edit_data['gambar'] ?></small>
          <?php endif; ?>
        </div>
        <button type="submit" name="<?= $edit ? 'update' : 'simpan' ?>" class="btn btn-<?= $edit ? 'warning' : 'primary' ?>">
          <?= $edit ? 'Update' : 'Simpan' ?>
        </button>
        <?php if ($edit): ?>
          <a href="hotel_control.php" class="btn btn-secondary ms-2">Batal</a>
        <?php endif; ?>
      </form>

      <!-- Tabel hotel -->
      <div class="card p-4 shadow-sm">
        <h4 class="mb-3">Data Hotel</h4>
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Gambar</th>
                <th>Deskripsi</th>
                <th>Rating</th>
                <th>Harga</th>
                <th>Link Kamar</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $data = $koneksi->query("SELECT * FROM hotel_control");
              while ($row = $data->fetch_assoc()) {
              ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= htmlspecialchars($row['nama']) ?></td>
                  <td><img src="hotel_control/<?= $row['gambar'] ?>" width="100" class="img-thumbnail"></td>
                  <td><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></td>
                  <td><?= $row['rating'] ?></td>
                  <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                  <td><?= htmlspecialchars($row['link_kamar']) ?></td>
                  <td>
                    <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-danger btn-sm">Hapus</a>
                  </td>
                </tr>
              <?php } ?>
              <?php if ($data->num_rows == 0): ?>
                <tr><td colspan="8" class="text-center text-muted">Belum ada data hotel</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
