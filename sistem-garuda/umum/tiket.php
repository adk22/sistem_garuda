<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "sistem_garuda");

// Reset hotel saat buka pertama kali dengan kode baru
if (isset($_GET['kode'])) {
    unset($_SESSION['kode_hotel']);
    unset($_SESSION['hotel_selected']);
    $kode = $_GET['kode'];
    $_SESSION['kode_tiket'] = $kode;
} elseif (isset($_SESSION['kode_tiket'])) {
    $kode = $_SESSION['kode_tiket'];
} else {
    die("ID tiket tidak ditemukan di URL atau session.");
}

// Ambil data tiket
$stmt = $koneksi->prepare("
  SELECT l.*, p.diskon_persen 
  FROM list_tiket l 
  LEFT JOIN promo p ON l.kode_promo = p.kode 
  WHERE l.kode = ?
");
$stmt->bind_param("s", $kode);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Tiket dengan kode tersebut tidak ditemukan.");
}

$tiket = $result->fetch_assoc();
$batas_kursi = isset($tiket['jumlah_kursi']) ? (int)$tiket['jumlah_kursi'] : 20;

$hargaPromo = isset($tiket['diskon_persen']) && is_numeric($tiket['diskon_persen']) 
    ? $tiket['harga'] - ($tiket['harga'] * $tiket['diskon_persen'] / 100) 
    : null;

// Ambil data hotel jika belum pernah dipilih di session
$hotelData = null;
if (!isset($_SESSION['hotel_selected'])) {
    $q2 = $koneksi->prepare("SELECT nama_hotel, nama_kamar, jumlah_tamu, harga_hotel FROM pemesanan WHERE kode_tiket = ?");
    $q2->bind_param("s", $kode);
    $q2->execute();
    $res2 = $q2->get_result();
    if ($res2 && $res2->num_rows) {
        $hotelData = $res2->fetch_assoc();
        $_SESSION['hotel_selected'] = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pemesanan Tiket</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .counter button {
      width: 30px;
      height: 30px;
      font-size: 18px;
      border: none;
      background: #007bff;
      color: white;
    }
    .counter span {
      margin: 0 10px;
      width: 30px;
      display: inline-block;
      text-align: center;
    }
    #pilihan-kursi {
      display: none;
      margin-top: 10px;
    }
    .baris-kursi {
      display: flex;
      flex-direction: row;
      margin-bottom: 6px;
      justify-content: center;
      align-items: center;
    }
    .kursi {
      width: 35px;
      height: 35px;
      background-color: #f0f0f0;
      border: 1px solid #ccc;
      margin: 2px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 12px;
    }
    .kursi.selected {
      background-color: #007bff;
      color: white;
    }
    .jarak {
      width: 20px;
    }
  </style>
</head>
<body class="bg-light">
<div class="container my-5">
  <div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
      <h4 class="mb-0">Pemesanan Tiket</h4>
    </div>
    <div class="card-body">
      <div class="row">
        <!-- Form Tiket -->
        <div class="col-md-8">
          <form id="formTiket">
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Dari</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($tiket['asal']) ?>" readonly>
              </div>
              <div class="col-md-6">
                <label>Tujuan</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($tiket['tujuan']) ?>" readonly>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label>Jam Berangkat</label>
                <input type="text" class="form-control" value="<?= substr($tiket['jam_berangkat'], 0, 5) ?>" readonly>
              </div>
              <div class="col-md-6">
                <label>Jam Tiba</label>
                <input type="text" class="form-control" value="<?= substr($tiket['jam_tiba'], 0, 5) ?>" readonly>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label>Keterangan Waktu</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($tiket['keterangan_waktu']) ?>" readonly>
              </div>
              <div class="col-md-6">
                <label>Kelas</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($tiket['kelas']) ?>" readonly>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label>Tanggal Berangkat</label>
                <input type="date" class="form-control" id="tanggal_berangkat" min="<?= date('Y-m-d') ?>" required>
              </div>
              <div class="col-md-6">
                <label>Tanggal Pulang</label>
                <input type="date" class="form-control" id="tanggal_pulang" min="<?= date('Y-m-d') ?>">
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label>Jumlah Penumpang</label>
                <div class="counter">
                  <button type="button" onclick="ubahJumlah(-1)">−</button>
                  <span id="jumlahPenumpang">1</span>
                  <button type="button" onclick="ubahJumlah(1)">+</button>
                </div>
              </div>
              <div class="col-md-6">
                <label>Pilih Kursi</label>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 mt-1" onclick="toggleKursi()">Pilih Kursi</button>
                <input type="hidden" id="kursi" required>
                <div id="pilihan-kursi" class="border rounded p-2">
                  <?php for ($i = 1; $i <= $batas_kursi; $i += 4): ?>
                    <div class="baris-kursi">
                      <?php for ($j = 0; $j < 2; $j++):
                        $nomor = $i + $j;
                        if ($nomor <= $batas_kursi): ?>
                          <div class="kursi" onclick="pilihKursi(<?= $nomor ?>)" id="kursi<?= $nomor ?>">K<?= $nomor ?></div>
                      <?php endif; endfor; ?>
                      <div class="jarak"></div>
                      <?php for ($j = 2; $j < 4; $j++):
                        $nomor = $i + $j;
                        if ($nomor <= $batas_kursi): ?>
                          <div class="kursi" onclick="pilihKursi(<?= $nomor ?>)" id="kursi<?= $nomor ?>">K<?= $nomor ?></div>
                      <?php endif; endfor; ?>
                    </div>
                  <?php endfor; ?>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label>Harga per Tiket</label>
              <input type="text" class="form-control" value="Rp <?= number_format($hargaPromo ?? $tiket['harga'], 0, ',', '.') ?>" readonly>
            </div>

            <input type="hidden" id="kode_tiket" value="<?= $tiket['kode'] ?>">
            <button type="submit" class="btn btn-primary w-100">Pesan Sekarang</button>
          </form>
        </div>

        <!-- Sisi Kanan: Hotel -->
        <div class="col-md-4 border-start mt-4 mt-md-0">
          <div class="text-center">
            <?php if ($hotelData && isset($_SESSION['hotel_selected'])): ?>
              <h5 class="mb-3">Hotel yang Sudah Dipilih</h5>
              <div class="card shadow-sm">
                <img src="../super_admin/gambar_<?= strtolower($hotelData['nama_hotel']) ?>/default.jpg" class="card-img-top" alt="Hotel <?= $hotelData['nama_hotel'] ?>">
                <div class="card-body text-start">
                  <h6 class="card-title"><?= htmlspecialchars($hotelData['nama_hotel']) ?></h6>
                  <p class="mb-1"><strong>Kamar:</strong> <?= htmlspecialchars($hotelData['nama_kamar']) ?></p>
                  <p class="mb-1"><strong>Tamu:</strong> <?= $hotelData['jumlah_tamu'] ?></p>
                  <p class="mb-2"><strong>Total Harga Hotel:</strong> Rp <?= number_format($hotelData['harga_hotel'], 0, ',', '.') ?></p>
                  <a href="hotel.php" class="btn btn-outline-primary mt-2 w-100">Ubah / Pilih Hotel Lain</a>
                </div>
              </div>
            <?php else: ?>
              <h5 class="mb-3">Butuh penginapan?</h5>
              <img src="https://source.unsplash.com/400x200/?hotel" class="img-fluid rounded mb-3" alt="Hotel">
              <p class="text-muted mb-3">Nikmati kenyamanan ekstra selama perjalanan Anda dengan hotel pilihan kami.</p>
              <a href="hotel.php" class="btn btn-success">Lihat dan Pesan Hotel</a>
            <?php endif; ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
let jumlah = 1;
let kursiTerpilih = [];

function ubahJumlah(delta) {
  jumlah += delta;
  if (jumlah < 1) jumlah = 1;
  const maxKursi = <?= $batas_kursi ?>;
  if (jumlah > maxKursi) jumlah = maxKursi;

  document.getElementById("jumlahPenumpang").textContent = jumlah;
  kursiTerpilih = [];
  document.querySelectorAll('.kursi').forEach(k => k.classList.remove('selected'));
  document.getElementById("kursi").value = "";
}

function toggleKursi() {
  const div = document.getElementById("pilihan-kursi");
  div.style.display = (div.style.display === "none") ? "block" : "none";
}

function pilihKursi(nomor) {
  const id = "kursi" + nomor;
  const kursi = document.getElementById(id);
  if (kursi.classList.contains("selected")) {
    kursi.classList.remove("selected");
    kursiTerpilih = kursiTerpilih.filter(k => k !== nomor);
  } else {
    if (kursiTerpilih.length < jumlah) {
      kursi.classList.add("selected");
      kursiTerpilih.push(nomor);
    } else {
      alert("Jumlah kursi tidak boleh lebih dari jumlah penumpang.");
    }
  }
  document.getElementById("kursi").value = kursiTerpilih.join(",");
}

document.getElementById("formTiket").addEventListener("submit", function(e) {
  e.preventDefault();
  if (kursiTerpilih.length !== jumlah) {
    alert("Jumlah kursi yang dipilih harus sama dengan jumlah penumpang.");
    return;
  }

  const data = {
    id_tiket: <?= $tiket['id'] ?>,
    kode: "<?= $tiket['kode'] ?>",
    asal: "<?= $tiket['asal'] ?>",
    tujuan: "<?= $tiket['tujuan'] ?>",
    jam_berangkat: "<?= substr($tiket['jam_berangkat'], 0, 5) ?>",
    jam_tiba: "<?= substr($tiket['jam_tiba'], 0, 5) ?>",
    tanggal_berangkat: document.getElementById("tanggal_berangkat").value,
    tanggal_pulang: document.getElementById("tanggal_pulang").value,
    jumlah_penumpang: jumlah,
    kursi: kursiTerpilih.join(","),
    harga: <?= $hargaPromo ?? $tiket['harga'] ?>,
    kelas: "<?= $tiket['kelas'] ?>",
    keterangan_waktu: "<?= $tiket['keterangan_waktu'] ?>"
  };

  localStorage.setItem("dataTiket", JSON.stringify(data));
  alert("Tiket berhasil disimpan!");
  window.location.href = "isi_nama.php";
});
</script>
</body>
</html>
