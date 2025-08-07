<?php
session_start();
include '../include/koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../umum/loginadmin.php");
    exit();
}

// Ambil jumlah akun user dari database
$userCountQuery = $conn->query("SELECT COUNT(*) as total_user FROM user WHERE role = 'user'");
$userData = $userCountQuery->fetch_assoc();
$totalUser = $userData['total_user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
    }

    .content-wrapper {
      margin-left: 250px;
      padding: 20px;
    }
  </style>
</head>

<body class="bg-gray-100">

  <!-- Sidebar -->
  <?php include '../include/sidebar_admin.php'; ?>

  <!-- Konten Utama -->
  <div class="content-wrapper">
    <h1 class="text-2xl font-bold mb-6 text-gray-700">Dashboard Admin</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
      <!-- Tiket Terjual -->
      <div class="bg-green-100 rounded-2xl shadow p-5">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Tiket Terjual</h2>
        <p class="text-3xl font-bold text-green-600" id="tiketTerjual">0</p>
      </div>

      <!-- Jumlah Akun User (realtime) -->
      <div class="bg-pink-100 rounded-2xl shadow p-5">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Jumlah Akun User</h2>
        <p class="text-3xl font-bold text-pink-600"><?= $totalUser ?></p>
      </div>

      <!-- Hotel Merusanur -->
      <div class="bg-blue-100 rounded-2xl shadow p-5">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Hotel Merusanur</h2>
        <p class="text-gray-700">Jumlah Pemesanan: <span class="font-bold text-blue-700" id="pesananMerusanur">0</span></p>
        <p class="text-gray-700">Sisa Kamar: <span class="font-bold text-green-700" id="sisaMerusanur">0</span></p>
        <p class="text-gray-700">Kamar Tersedia: <span class="font-bold text-green-700" id="tersediaMerusanur">0</span></p>
      </div>

      <!-- Hotel Prama -->
      <div class="bg-yellow-100 rounded-2xl shadow p-5">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Hotel Prama</h2>
        <p class="text-gray-700">Jumlah Pemesanan: <span class="font-bold text-yellow-800" id="pesananPrama">0</span></p>
        <p class="text-gray-700">Sisa Kamar: <span class="font-bold text-green-700" id="sisaPrama">0</span></p>
        <p class="text-gray-700">Kamar Tersedia: <span class="font-bold text-green-700" id="tersediaPrama">0</span></p>
      </div>
    </div>

    <!-- Grafik -->
    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Grafik Statistik</h2>
      <canvas id="grafikDashboard" height="100"></canvas>
      <p class="text-sm text-right text-gray-500 mt-4" id="updateTime"></p>
    </div>

    <!-- Footer -->
    <?php include '../include/copyright_admin.php'; ?>
  </div>

  <script>
    const dataDashboard = {
      tiketTerjual: 27,
      pesananHotel: { prama: 10, merusanur: 8 },
      hotel: {
        merusanur: { sisa: 5, tersedia: 15 },
        prama: { sisa: 3, tersedia: 12 },
      },
    };

    const setText = (id, val) => {
      const el = document.getElementById(id);
      if (el) el.textContent = val;
    };

    setText("tiketTerjual", dataDashboard.tiketTerjual);
    setText("pesananMerusanur", dataDashboard.pesananHotel.merusanur);
    setText("pesananPrama", dataDashboard.pesananHotel.prama);
    setText("sisaMerusanur", dataDashboard.hotel.merusanur.sisa);
    setText("tersediaMerusanur", dataDashboard.hotel.merusanur.tersedia);
    setText("sisaPrama", dataDashboard.hotel.prama.sisa);
    setText("tersediaPrama", dataDashboard.hotel.prama.tersedia);

    const now = new Date();
    setText("updateTime", "Terakhir diperbarui: " + now.toLocaleString("id-ID"));

    const ctx = document.getElementById("grafikDashboard").getContext("2d");
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["Tiket Terjual", "Hotel Prama", "Hotel Merusanur"],
        datasets: [{
          label: "Statistik",
          data: [
            dataDashboard.tiketTerjual,
            dataDashboard.pesananHotel.prama,
            dataDashboard.pesananHotel.merusanur
          ],
          backgroundColor: [
            "rgba(34,197,94,0.7)",
            "rgba(253,224,71,0.7)",
            "rgba(96,165,250,0.7)"
          ],
          borderColor: [
            "rgba(34,197,94,1)",
            "rgba(253,224,71,1)",
            "rgba(96,165,250,1)"
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 5 } } }
      }
    });
  </script>
</body>
</html>
