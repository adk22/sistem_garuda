<?php
include '../include/koneksi.php';

// Proses tambah berita
if (isset($_POST['submit'])) {
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    $folder = 'berita/';
    $path = $folder . basename($gambar);

    // Pastikan folder 'berita/' ada
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    if (move_uploaded_file($tmp, $path)) {
        $sql = "INSERT INTO berita (gambar) VALUES ('$gambar')";
        mysqli_query($conn, $sql);
    }
}

// Proses hapus berita
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query = mysqli_query($conn, "SELECT gambar FROM berita WHERE id = $id");
    $data = mysqli_fetch_assoc($query);

    if ($data && file_exists("berita/" . $data['gambar'])) {
        unlink("berita/" . $data['gambar']);
    }

    mysqli_query($conn, "DELETE FROM berita WHERE id = $id");
    header("Location: berita.php");
    exit;
}

// Ambil data berita
$berita = mysqli_query($conn, "SELECT * FROM berita ORDER BY tanggal_upload DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">

    <!-- Header dengan tombol kembali dan judul di tengah -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="beranda_control.php" class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            &larr;
        </a>
        <h2 class="text-center flex-grow-1 m-0">Kelola Berita</h2>
        <div style="width: 40px;"></div> <!-- Dummy div untuk keseimbangan layout -->
    </div>

    <!-- Form tambah berita -->
    <form action="" method="POST" enctype="multipart/form-data" class="mb-5 mt-3">
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Berita</label>
            <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Upload Berita</button>
    </form>

    <!-- Tabel daftar berita -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Tanggal Upload</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($berita)) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><img src="berita/<?= htmlspecialchars($row['gambar']) ?>" width="150" class="img-thumbnail"></td>
                    <td><?= $row['tanggal_upload'] ?></td>
                    <td>
                        <a href="?hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus berita ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
