<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$nama = $_SESSION['nama'] ?? 'Admin';
$role = $_SESSION['role'] ?? '';
?>

<style>
  .sidebar {
    width: 250px;
    height: 100vh;
    background-color: #2f84df;
    color: #fff;
    border-right: 1px solid #0056b3;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: fixed;
    top: 0;
    left: 0;
    overflow-y: auto;
  }

  .sidebar-header {
    padding: 20px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #000;
  }

  .logo-img {
    width: 40px;
    height: 40px;
    object-fit: contain;
    margin-right: 10px;
    border-radius: 4px;
  }

  .logo-text {
    font-size: 16px;
    font-weight: bold;
  }

  .logo-text small {
    display: block;
    font-size: 12px;
    color: #e0e0e0;
  }

  .menu {
    list-style: none;
    padding: 20px;
    margin: 0;
    flex: 1;
  }

  .menu li {
    margin: 10px 0;
  }

  .menu a {
    text-decoration: none;
    color: #fff;
    font-size: 14px;
    display: block;
    transition: color 0.2s ease;
    cursor: pointer;
  }

  .menu a:hover {
    color: #d1ecff;
  }

  .submenu {
    list-style: none;
    padding-left: 20px;
    display: none;
  }

  .submenu li {
    margin: 5px 0;
  }

  .submenu a {
    font-size: 13px;
  }

  .show-submenu > .submenu {
    display: block;
  }

  .sidebar-footer {
    padding: 12px 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    background-color: #1c65b3;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .sidebar-footer .admin-name {
    display: flex;
    align-items: center;
  }

  .sidebar-footer .admin-name i {
    margin-right: 8px;
  }

  .sidebar-footer a {
    color: #fff;
    text-decoration: none;
    display: flex;
    align-items: center;
  }

  .sidebar-footer a:hover {
    text-decoration: underline;
  }

  .sidebar-footer a i {
    margin-right: 6px;
  }

  .bottom-logo {
    padding: 15px;
    text-align: center;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    background-color: #1b5aa0;
  }

  .bottom-logo img {
    width: 80px;
    height: auto;
  }

  .rotate {
    transform: rotate(180deg);
    transition: transform 0.3s ease;
  }
</style>

<!-- Font Awesome Icon -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<div class="sidebar">
  <div>
    <div class="sidebar-header">
      <img src="../gambar/GA SkyTeam.png" alt="Logo" class="logo-img" />
      <div class="logo-text">
        Garuda Indonesia Denpasar
        <small><?= htmlspecialchars($role) ?></small>
      </div>
    </div>

    <ul class="menu">
      <?php if ($role === 'admin') : ?>
        <li><a href="../admin/index_admin.php">Home</a></li>
        <li><a href="../admin/pembelian_tiket.php">Pembelian Tiket</a></li>
        <li><a href="../admin/pemesanan_hotel.php">Pemesanan Hotel</a></li>
        <li><a href="../admin/akun_user.php">Akun User</a></li>
      <?php elseif ($role === 'superadmin') : ?>
        <li><a href="../super_admin/index_superadmin.php">Home</a></li>
        <li><a href="../super_admin/beranda_control.php">Beranda User</a></li>
        <li>
          <div style="display: flex; align-items: center;">
            <a href="../super_admin/hotel_control.php" style="color: white; text-decoration: none; flex-grow: 0;">
              Hotel
            </a>
            <span onclick="toggleSubmenu(this)" style="cursor: pointer; display: left; padding: 5px">
              <i class="fas fa-chevron-down toggle-icon" style="color: white;"></i>
            </span>
          </div>
          <ul class="submenu">
            <li><a href="../super_admin/prama_kamar.php">Prama Kamar</a></li>
            <li><a href="../super_admin/merusanur_kamar.php">Meru Kamar</a></li>
          </ul>
        </li>
        <li><a href="../super_admin/tiket_control.php">Tiket Control</a></li>
        <li><a href="../super_admin/akun_admin.php">Akun Admin</a></li>
      <?php else : ?>
        <li><a href="#">Menu tidak tersedia</a></li>
      <?php endif; ?>
    </ul>
  </div>

  <div>
    <div class="sidebar-footer">
      <div class="admin-name">
        <i class="fas fa-user-circle"></i> <?= htmlspecialchars($nama) ?>
      </div>
      <a href="../umum/loginadmin.php" title="Logout">
        <i class="fas fa-right-from-bracket"></i> Logout
      </a>
    </div>
    <div class="bottom-logo">
      <img src="../gambar/GA SkyTeam.png" alt="Logo Besar">
    </div>
  </div>
</div>

<script>
  function toggleSubmenu(el) {
    const parent = el.closest('li');
    const submenu = parent.querySelector('.submenu');
    submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';

    const icon = el.querySelector('.toggle-icon');
    icon.classList.toggle('rotate');
  }
</script>
