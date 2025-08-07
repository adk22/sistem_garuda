<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "sistem_garuda");

// Tambah destinasi
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $folder = "gambar_destinasi/";

    if (move_uploaded_file($tmp, $folder . $gambar)) {
        $koneksi->query("INSERT INTO destinasi (nama, deskripsi, gambar) VALUES ('$nama', '$deskripsi', '$gambar')");
        header("Location: destinasidenpasar.php");
        exit;
    } else {
        echo "Upload gambar gagal.";
    }
}

// Hapus destinasi
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $data = $koneksi->query("SELECT * FROM destinasi WHERE id = $id")->fetch_assoc();
    if ($data) {
        unlink("gambar_destinasi/" . $data['gambar']);
        $koneksi->query("DELETE FROM destinasi WHERE id = $id");
    }
    header("Location: destinasidenpasar.php");
    exit;
}

// Ambil data destinasi untuk diedit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_data = $koneksi->query("SELECT * FROM destinasi WHERE id = $id")->fetch_assoc();
}

// Simpan perubahan edit
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];

    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $folder = "gambar_destinasi/";

        if (move_uploaded_file($tmp, $folder . $gambar)) {
            // Hapus gambar lama
            $old = $koneksi->query("SELECT gambar FROM destinasi WHERE id = $id")->fetch_assoc();
            unlink("gambar_destinasi/" . $old['gambar']);

            $koneksi->query("UPDATE destinasi SET nama='$nama', deskripsi='$deskripsi', gambar='$gambar' WHERE id=$id");
        }
    } else {
        $koneksi->query("UPDATE destinasi SET nama='$nama', deskripsi='$deskripsi' WHERE id=$id");
    }

    header("Location: destinasidenpasar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kontrol Destinasi - Superadmin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    img.thumb {
      width: 120px;
      height: auto;
    }
    .back-btn {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      font-size: 22px;
      padding: 6px 0;
      text-align: center;
      line-height: 1.2;
    }
  </style>
</head>
<body class="p-4">
  <div class="container">

    <!-- Header dengan tombol kembali dan judul tengah -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <a href="beranda_control.php" class="btn btn-primary back-btn d-flex align-items-center justify-content-center" title="Kembali">
        &larr;
      </a>
      <h2 class="text-center flex-grow-1 m-0">Kontrol Destinasi Wisata (Superadmin)</h2>
      <div style="width: 40px;"></div> <!-- Placeholder untuk menjaga tengah -->
    </div>

    <!-- Form Tambah/Edit -->
    <div class="card mb-4">
      <div class="card-header">
        <?= $edit_data ? 'Edit Destinasi' : 'Tambah Destinasi Baru' ?>
      </div>
      <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
          <?php if ($edit_data): ?>
            <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
          <?php endif ?>
          <div class="mb-3">
            <label class="form-label">Nama Destinasi</label>
            <input type="text" name="nama" class="form-control" required value="<?= $edit_data['nama'] ?? '' ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required><?= $edit_data['deskripsi'] ?? '' ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Gambar <?= $edit_data ? '(Kosongkan jika tidak diubah)' : '' ?></label>
            <input type="file" name="gambar" accept="image/*" class="form-control" <?= $edit_data ? '' : 'required' ?>>
          </div>
          <button type="submit" name="<?= $edit_data ? 'update' : 'tambah' ?>" class="btn btn-primary">
            <?= $edit_data ? 'Simpan Perubahan' : 'Tambah' ?>
          </button>
          <?php if ($edit_data): ?>
            <a href="destinasidenpasar.php" class="btn btn-secondary ms-2">Batal</a>
          <?php endif ?>
        </form>
      </div>
    </div>

    <!-- Tabel Daftar Destinasi -->
    <h4>Daftar Destinasi</h4>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Deskripsi</th>
          <th>Gambar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $result = $koneksi->query("SELECT * FROM destinasi");
        while ($row = $result->fetch_assoc()):
        ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
            <td><img src="gambar_destinasi/<?= $row['gambar'] ?>" class="thumb"></td>
            <td>
              <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</a>
            </td>
          </tr>
        <?php endwhile ?>
      </tbody>
    </table>
  </div>
</body>
</html>
