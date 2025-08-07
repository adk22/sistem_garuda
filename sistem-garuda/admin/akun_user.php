<?php
include '../include/koneksi.php';

// Proses hapus jika ada parameter GET 'hapus'
if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  $conn->query("DELETE FROM user WHERE id = $id");
  header("Location: akun_user.php");
  exit;
}

// Ambil data user
$result = $conn->query("SELECT * FROM user WHERE role = 'user'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin - List Akun User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f4f7fc;
      font-family: "Segoe UI", sans-serif;
    }
    .admin-header {
      background-color: #004080;
      color: white;
      padding: 20px;
      text-align: center;
      margin-left: 250px;
    }
    .table-container {
      padding: 40px;
      margin-left: 250px;
    }
    .table th {
      background-color: #007bff;
      color: white;
      vertical-align: middle;
    }
    .btn-action {
      margin: 0 3px;
    }
    .table td,
    .table th {
      vertical-align: middle;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <!-- Sidebar Admin -->
  <?php include '../include/sidebar_admin.php'; ?>

  <!-- Header -->
  <div class="admin-header">
    <h2>Daftar Akun User</h2>
  </div>

  <!-- Tabel User -->
  <div class="table-container">
    <div class="table-responsive">
      <table class="table table-bordered table-hover text-center align-middle">
        <thead>
          <tr>
            <th>No</th>
            <th>Username</th>
            <th>Email</th>
            <th>Nama Depan</th>
            <th>Nama Belakang</th>
            <th>Nama Lengkap</th>
            <th>Kewarganegaraan</th>
            <th>Negara</th>
            <th>Alamat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>$no</td>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['nama_depan']}</td>";
            echo "<td>{$row['nama_belakang']}</td>";
            echo "<td>{$row['nama']}</td>";
            echo "<td>{$row['kewarganegaraan']}</td>";
            echo "<td>{$row['negara']}</td>";
            echo "<td>{$row['alamat']}</td>";
            echo "<td>
              <a href='akun_user.php?hapus={$row['id']}' 
                class='btn btn-danger btn-sm' 
                onclick=\"return confirm('Yakin ingin menghapus akun ini?')\">
                Hapus
              </a>
            </td>";
            echo "</tr>";
            $no++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
 <!-- Copyright -->
  <?php include '../include/copyright_admin.php'; ?>
</body>
</html>
