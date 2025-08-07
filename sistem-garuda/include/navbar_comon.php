<?php
session_start();
$isLoggedIn = isset($_SESSION['username']);
$namaUser = $_SESSION['nama'] ?? 'Pengguna';
$emailUser = $_SESSION['email'] ?? '-';
?>

<!-- Bootstrap CSS & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
  .navbar {
    padding: 8px 20px;
    background-color: #52a6fa;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
  }

  .navbar-brand img {
    height: 32px;
    object-fit: contain;
    background-color: transparent;
  }

  .nav-link {
    color: white !important;
    font-size: 0.95rem;
    font-weight: 500;
    transition: all 0.3s ease;
  }

  .nav-link:hover {
    color: #ffc107 !important;
    text-shadow: 0 0 6px rgba(255, 193, 7, 0.6);
  }

  .dropdown-menu {
    background-color: rgba(51, 51, 51, 0.95);
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    z-index: 9999 !important;
    min-width: 240px;
    color: white;
  }

  .dropdown-menu .dropdown-item {
    border-radius: 8px;
    color: white;
    transition: background-color 0.2s;
  }

  .dropdown-menu .dropdown-item:hover {
    background-color: rgba(255, 255, 255, 0.1);
  }

  .dropdown-divider {
    border-top: 1px solid rgba(255, 255, 255, 0.2);
  }

  .profile-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    color: white;
  }

  .dropdown-menu .text-muted {
    color: #ccc !important;
  }

  /* Style tombol login saat belum login (tanpa background) */
  .nav-link.login-plain {
    display: flex;
    align-items: center;
    gap: 6px;
    color: white !important;
    font-weight: 500;
    font-size: 0.95rem;
    transition: color 0.3s ease;
  }

  .nav-link.login-plain:hover {
    color: #ffc107 !important;
    text-shadow: 0 0 6px rgba(255, 193, 7, 0.6);
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand" href="../umum/index.php">
      <img src="../gambar/GA SkyTeam.png" alt="Garuda Logo">
    </a>

    <!-- Toggler (mobile view) -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
      <ul class="navbar-nav mb-2 mb-lg-0 align-items-lg-center">
        <li class="nav-item">
          <a class="nav-link" href="../umum/index.php">Home</a>
        </li>
       <li class="nav-item">
  <?php if (isset($_SESSION['username'])): ?>
    <a class="nav-link" href="list_tiket.php">Tiket</a>
  <?php else: ?>
    <a class="nav-link" href="../umum/login.php" onclick="alert('Silakan login terlebih dahulu untuk memesan tiket.')">Tiket</a>
  <?php endif; ?>
</li>
        <li class="nav-item">
          <a class="nav-link" href="../umum/purchase.php">Purchase</a>
        </li>

        <!-- Login / Profile -->
        <?php if ($isLoggedIn): ?>
          <!-- Dropdown profil -->
          <li class="nav-item dropdown">
            <a class="nav-link p-0" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <div class="profile-icon">
                <i class="bi bi-person-circle fs-4"></i>
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="userDropdown">
              <li class="text-center px-3 pt-3 pb-1">
                <i class="bi bi-person-circle fs-2 text-light"></i>
                <div class="fw-semibold mt-1 text-white"><?= htmlspecialchars($namaUser); ?></div>
                <small class="text-muted"><?= htmlspecialchars($emailUser); ?></small>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="../include/profile.php"><i class="bi bi-person me-2"></i> Profil</a></li>
              <li><a class="dropdown-item" href="../include/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <!-- Tombol login tanpa background -->
          <li class="nav-item">
            <a class="nav-link login-plain" href="../umum/login.php" title="Login">
              <i class="bi bi-person-circle fs-5"></i>
              <span>Login</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
