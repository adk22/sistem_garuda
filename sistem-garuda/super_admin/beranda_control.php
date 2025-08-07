<?php
session_start();
$_SESSION['role'] = 'superadmin'; // pastikan role terset, bisa dari login
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Superadmin - Cabang Bali</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      background-color: #f1f3f5;
    }
    .main-content {
    margin-left: 250px; /* Atur sesuai lebar sidebar kamu */
    padding: 30px;
    transition: margin-left 0.3s ease;
    }
    .header {
      background-color: #1d3557;
      color: white;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 30px;
    }

 .card-click {
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .card-click:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
  }
  </style>
</head>
<body>

<?php include '../include/sidebar_admin.php'; ?>

  <div class="main-content">  
  <!-- Konten Dinamis -->
    <div class="row">
      <!-- Kartu Tentang Sistem -->
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card shadow-sm border-0 card-click" onclick="location.href='tentang.php'">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-info-square text-primary"></i> Tentang Kami</h5>
            <p class="card-text">deskripsi tentang kami atau about pada halaman beranda user.</p>
          </div>
        </div>
      </div>

      <!-- Kartu Manajemen Destinasi -->
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card shadow-sm border-0 card-click" onclick="location.href='destinasidenpasar.php'">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-map text-success"></i> Manajemen Destinasi denpasar</h5>
            <p class="card-text">Tambah, edit, dan hapus destinasi wisata yang terdapat di denpasar.</p>
          </div>
        </div>
      </div>

      <!-- Kartu Berita & Pengumuman -->
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card shadow-sm border-0 card-click" onclick="location.href='berita.php'">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-megaphone text-warning"></i> Berita & Pengumuman</h5>
            <p class="card-text">Publikasikan berita terbaru dan pengumuman penting untuk pelanggan.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function showSection(id) {
    const sections = document.querySelectorAll('.section-content');
    sections.forEach(sec => sec.classList.add('d-none'));
    const target = document.getElementById(id);
    if (target) target.classList.remove('d-none');
    // Scroll otomatis ke bagian bawah saat tampilkan detail
    target.scrollIntoView({ behavior: 'smooth' });
  }
</script>
</body>
</html>
