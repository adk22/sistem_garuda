<?php
session_start();
include '../include/koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'superadmin') {
    die("Akses ditolak.");
}

// Tambah admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_admin'])) {
    $count = $conn->query("SELECT COUNT(*) as total FROM user WHERE role='admin'")->fetch_assoc()['total'];

    if ($count < 2) {
        // Tangkap data dari form
        $namaDepan = $_POST['nama_depan'] ?? '';
        $namaBelakang = $_POST['nama_belakang'] ?? '';
        $jabatan = $_POST['jabatan'] ?? '';
        $kewarganegaraan = $_POST['kewarganegaraan'] ?? '';
        $negara = $_POST['negara'] ?? '';
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $nama = $namaDepan . ' ' . $namaBelakang;

        if (str_starts_with($password, 'GA') && strlen($password) <= 10) {
            $stmt = $conn->prepare("INSERT INTO user (nama, username, email, password, role, nama_depan, nama_belakang, jabatan, kewarganegaraan, negara) VALUES (?, ?, ?, ?, 'admin', ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $nama, $username, $email, $password, $namaDepan, $namaBelakang, $jabatan, $kewarganegaraan, $negara);
            $stmt->execute();
            echo "<script>alert('Admin berhasil ditambahkan!'); window.location.href='akun_admin.php';</script>";
        } else {
            echo "<script>alert('Password harus diawali GA dan maksimal 10 karakter');</script>";
        }
    } else {
        echo "<script>alert('Maksimal hanya 2 admin');</script>";
    }
}

// Hapus admin
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM user WHERE id = $id AND role = 'admin'");
    echo "<script>alert('Admin berhasil dihapus!'); window.location.href='akun_admin.php';</script>";
}

// Ambil semua admin
$admins = $conn->query("SELECT * FROM user WHERE role='admin'");
$adminCount = $conn->query("SELECT COUNT(*) as total FROM user WHERE role='admin'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .main-content {
      margin-left: 240px;
      padding: 20px;
    }
    .admin-header {
      background-color: #004080;
      color: white;
      padding: 15px;
      border-radius: 6px;
      margin-bottom: 20px;
    }
    .table thead {
      background-color: #007bff;
      color: white;
    }
  </style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
  <?php include '../include/sidebar_admin.php'; ?>
</div>

<!-- Main Content -->
<div class="main-content">
  <div class="admin-header">
    <h2>Daftar Akun Admin</h2>
  </div>

  <div class="container-fluid py-2">
    <h5 class="mb-3">Tambah Admin</h5>

    <?php if ($adminCount < 2): ?>
    <form method="POST" class="row g-3 mb-4">
      <div class="col-md-6">
        <input type="text" name="nama_depan" class="form-control" placeholder="Nama Depan" required>
      </div>
      <div class="col-md-6">
        <input type="text" name="nama_belakang" class="form-control" placeholder="Nama Belakang" required>
      </div>
      <div class="col-md-6">
        <input type="text" name="jabatan" class="form-control" placeholder="Jabatan" required>
      </div>
      <div class="col-md-6">
        <input type="text" name="kewarganegaraan" class="form-control" placeholder="Kewarganegaraan" required>
      </div>
      <div class="col-md-6">
        <input type="text" name="negara" class="form-control" placeholder="Negara" required>
      </div>
      <div class="col-md-6">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
      </div>
      <div class="col-md-6">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
      </div>
      <div class="col-md-6">
        <input type="text" name="password" maxlength="10" class="form-control" placeholder="Password (awalan GA, max 10 karakter)" required>
      </div>
      <div class="col-12">
        <button type="submit" name="tambah_admin" class="btn btn-primary">Tambah Admin</button>
      </div>
    </form>
    <?php else: ?>
    <div class="alert alert-warning">Jumlah admin sudah mencapai batas maksimal (2 admin).</div>
    <?php endif; ?>

    <h5>List Admin</h5>
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle text-center">
        <thead>
          <tr>
            <th>No</th>
            <th>Admin</th>
            <th>Username</th>
            <th>Email</th>
            <th>Negara</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; while ($row = $admins->fetch_assoc()): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td class="text-start">
                <div class="d-flex align-items-center">
                  <img src="https://ui-avatars.com/api/?name=<?= urlencode($row['nama']) ?>&background=007bff&color=fff&size=32" class="rounded-circle me-2" alt="avatar">
                  <div>
                    <strong><?= htmlspecialchars($row['nama']) ?></strong><br>
                    <small><?= htmlspecialchars($row['jabatan']) ?></small>
                  </div>
                </div>
              </td>
              <td><?= htmlspecialchars($row['username']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['negara']) ?> (<?= htmlspecialchars($row['kewarganegaraan']) ?>)</td>
              <td>
                <a href="?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus admin ini?')">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <footer class="mt-5">
    <?php include '../include/copyright_admin.php'; ?>
  </footer>
</div>

</body>
</html>
