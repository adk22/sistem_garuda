<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: ../umum/login.php");
    exit;
}

$nama = $_SESSION['nama'] ?? '-';
$email = $_SESSION['email'] ?? '-';
$username = $_SESSION['username'] ?? '-';
$namaDepan = $_SESSION['nama_depan'] ?? '-';
$namaBelakang = $_SESSION['nama_belakang'] ?? '-';
$kewarganegaraan = $_SESSION['kewarganegaraan'] ?? '-';
$negara = $_SESSION['negara'] ?? '-';
$alamat = $_SESSION['alamat'] ?? '-';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Pengguna</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    :root {
      --header-color: #007bff;
    }

    body {
      background: linear-gradient(to right, #dceeff, #f4faff);
      font-family: 'Segoe UI', sans-serif;
    }

    .back-button {
      position: absolute;
      top: 20px;
      left: 20px;
      background-color: var(--header-color);
      color: white;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      text-align: center;
      line-height: 40px;
      font-size: 20px;
      text-decoration: none;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease;
      z-index: 1000;
    }

    .back-button:hover {
      background-color: #0056b3;
    }

    .profile-container {
      max-width: 800px;
      margin: 80px auto 60px;
      background: white;
      border-radius: 16px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      position: relative;
    }

    .profile-header {
      padding: 20px;
      text-align: center;
      color: white;
      background-color: var(--header-color);
    }

    .garuda-logo img {
      height: 50px;
      margin-bottom: 10px;
    }

    .profile-title {
      font-size: 22px;
      font-weight: bold;
    }

    .profile-body {
      padding: 30px 40px;
    }

    .profile-row {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 12px 0;
      border-bottom: 1px solid #eee;
      gap: 20px;
    }

    .profile-label {
      flex: 1;
      font-weight: 600;
      color: #555;
      display: flex;
      align-items: center;
    }

    .profile-label i {
      color: var(--header-color);
      margin-right: 10px;
    }

    .profile-value {
      flex: 2;
      font-size: 16px;
      color: #333;
      background-color: #f5f5f5;
      border: 1px solid #ccc;
      border-radius: 6px;
      padding: 8px 12px;
      width: 100%;
      box-sizing: border-box;
      text-align: left;
    }

    @media (max-width: 576px) {
      .profile-row {
        flex-direction: column;
      }

      .profile-value {
        width: 100%;
        margin-top: 6px;
      }
    }
  </style>
</head>
<body>

<!-- Tombol Kembali -->
<a href="../umum/index.php" class="back-button" title="Kembali">
  <i class="bi bi-arrow-left"></i>
</a>

<div class="profile-container">
  <div class="profile-header">
    <div class="garuda-logo">
      <img src="../gambar/GA SkyTeam.png" alt="Garuda Indonesia">
    </div>
    <div class="profile-title">Profil Anda</div>
  </div>

  <div class="profile-body">
    <?php
    $data = [
      ['icon' => 'person-circle', 'label' => 'Nama Lengkap', 'value' => $nama],
      ['icon' => 'person', 'label' => 'Nama Depan', 'value' => $namaDepan],
      ['icon' => 'person', 'label' => 'Nama Belakang', 'value' => $namaBelakang],
      ['icon' => 'envelope', 'label' => 'Email', 'value' => $email],
      ['icon' => 'person-badge', 'label' => 'Username', 'value' => $username],
      ['icon' => 'globe', 'label' => 'Kewarganegaraan', 'value' => $kewarganegaraan],
      ['icon' => 'geo-alt', 'label' => 'Negara', 'value' => $negara],
      ['icon' => 'house-door', 'label' => 'Alamat', 'value' => $alamat],
    ];

    foreach ($data as $item) {
      echo '<div class="profile-row">';
      echo '<div class="profile-label"><i class="bi bi-' . $item['icon'] . '"></i>' . $item['label'] . '</div>';
      echo '<div class="profile-value" readonly>' . htmlspecialchars($item['value']) . '</div>';
      echo '</div>';
    }
    ?>
  </div>
</div>

</body>
</html>
