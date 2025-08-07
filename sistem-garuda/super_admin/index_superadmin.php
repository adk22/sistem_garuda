<?php
session_start();
$_SESSION['role'] = 'superadmin'; // Set session role

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "sistem_garuda");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Hitung jumlah gambar di tabel destinasi
$gambarDestinasi = 0;
$result1 = $koneksi->query("SELECT COUNT(*) AS total FROM destinasi WHERE gambar IS NOT NULL AND gambar != ''");
if ($result1) {
    $gambarDestinasi = $result1->fetch_assoc()['total'];
}

// Hitung jumlah gambar di tabel berita
$gambarBerita = 0;
$result2 = $koneksi->query("SELECT COUNT(*) AS total FROM berita WHERE gambar IS NOT NULL AND gambar != ''");
if ($result2) {
    $gambarBerita = $result2->fetch_assoc()['total'];
}

// Hitung jumlah admin
$jumlahAdmin = 0;
$result3 = $koneksi->query("SELECT COUNT(*) AS total FROM user WHERE role = 'admin'");
if ($result3) {
    $jumlahAdmin = $result3->fetch_assoc()['total'];
}

$totalGambarBeranda = $gambarDestinasi + $gambarBerita;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Superadmin</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 font-sans">

<!-- Sidebar -->
<?php include '../include/sidebar_admin.php'; ?>

<!-- Konten utama -->
<div style="margin-left: 250px;">
  <div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-2 text-gray-700">Halo, <?= htmlspecialchars($_SESSION['nama'] ?? 'Superadmin'); ?></h1>
    <p class="mb-6">Selamat datang di dashboard Superadmin.</p>

    <?php
    if (isset($_SESSION['popup']) && $_SESSION['popup'] === 'superadmin') {
        echo "<script>
          window.addEventListener('DOMContentLoaded', () => {
              alert('Selamat datang, Superadmin!');
          });
        </script>";
        unset($_SESSION['popup']);
    }
    ?>

    <!-- Box Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-10">
      <!-- Box Jumlah Gambar -->
      <div class="bg-green-100 rounded-2xl shadow p-5">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Jumlah Gambar di Beranda</h2>
        <p class="text-3xl font-bold text-green-700"><?= $totalGambarBeranda; ?></p>
        <small class="text-gray-600 text-sm">
          Destinasi: <?= $gambarDestinasi; ?> | Berita: <?= $gambarBerita; ?>
        </small>
      </div>

      <!-- Box Jumlah Admin -->
      <div class="bg-pink-100 rounded-2xl shadow p-5">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Jumlah Akun Admin</h2>
        <p class="text-3xl font-bold text-pink-700"><?= $jumlahAdmin; ?></p>
      </div>

      <!-- Hotel Merusanur (Contoh statis) -->
      <div class="bg-blue-100 rounded-2xl shadow p-5">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Hotel Merusanur</h2>
        <p>Jumlah Pemesanan: <span class="font-bold text-blue-700">8</span></p>
        <p>Sisa Kamar: <span class="font-bold text-green-700">5</span></p>
        <p>Kamar Tersedia: <span class="font-bold text-green-700">15</span></p>
      </div>

      <!-- Hotel Prama (Contoh statis) -->
      <div class="bg-yellow-100 rounded-2xl shadow p-5">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Hotel Prama</h2>
        <p>Jumlah Pemesanan: <span class="font-bold text-yellow-800">10</span></p>
        <p>Sisa Kamar: <span class="font-bold text-green-700">3</span></p>
        <p>Kamar Tersedia: <span class="font-bold text-green-700">12</span></p>
      </div>
    </div>

    <!-- Chart -->
    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Grafik Statistik</h2>
      <canvas id="grafikDashboard" height="100"></canvas>
    </div>
  </div>

  <!-- Footer -->
  <?php include '../include/copyright_admin.php'; ?>
</div>

<!-- ChartJS Script -->
<script>
  const ctx = document.getElementById("grafikDashboard").getContext("2d");
  new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["Gambar Beranda", "Admin", "Hotel Prama", "Hotel Merusanur"],
      datasets: [{
        label: "Statistik",
        data: [<?= $totalGambarBeranda ?>, <?= $jumlahAdmin ?>, 10, 8],
        backgroundColor: [
          "rgba(34,197,94,0.7)",
          "rgba(236,72,153,0.7)",
          "rgba(253,224,71,0.7)",
          "rgba(96,165,250,0.7)",
        ],
        borderColor: [
          "rgba(34,197,94,1)",
          "rgba(236,72,153,1)",
          "rgba(253,224,71,1)",
          "rgba(96,165,250,1)",
        ],
        borderWidth: 1,
      }],
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: { stepSize: 5 }
        }
      }
    }
  });
</script>
</body>
</html>
