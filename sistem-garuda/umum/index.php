<?php
session_start();
echo "Session username: " . ($_SESSION['username'] ?? 'Belum login');

// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sistem_garuda";

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
    // Ambil data dari tabel tentang_kami
$query = "SELECT isi FROM tentang_kami LIMIT 1";
$result = $conn->query($query);
$isi = "";

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $isi = $row["isi"];
}


$berita = mysqli_query($conn, "SELECT * FROM berita ORDER BY tanggal_upload DESC");
?>

?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Beranda</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <style>
      body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f7fc;
      }

      /* Banner */
      .banner {
        position: relative;
        height: 100vh;
        background: url("../gambar/banner.jpg") no-repeat center center/cover;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
      }

      .banner::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* overlay gelap */
        z-index: 1;
      }

      .banner h2 {
        font-size: 2.5rem;
        font-weight: 500;
        animation: fadeIn 2s ease-out;
        position: relative;
        z-index: 2; /* pastikan berada di atas overlay */
      }

      @keyframes fadeIn {
        from {
          opacity: 0;
        }
        to {
          opacity: 1;
        }
      }

      .pesan-tiket-btn {
        background-color:rgb(73, 185, 250) !important; /* Warna kuning (bisa diganti) */
        color: #ffffff !important; /* Warna teks */
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 8px;
        transition: background-color 0.3s ease;
      }

      .pesan-tiket-btn:hover {
        background-color:rgb(225, 169, 0) !important; /* Warna saat hover */
      }

      /* Tentang & Section */
      .section {
        padding: 60px 20px;
        text-align: center;
        background-color: #ffffff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
      }

      .section h2 {
        font-size: 2.5rem;
        margin-bottom: 20px;
        color: #333;
      }

      .section p {
        font-size: 1.2rem;
        color: #666;
      }

      /* Destinasi */
      .destinasi-wrapper {
        position: relative;
        margin: 0 auto;
        overflow: hidden;
        padding: 0 40px; /* beri ruang untuk tombol kiri/kanan */
        max-width: 100%;
      }

      .destinasi-scroll {
        display: flex;
        overflow-x: auto;
        gap: 20px;
        padding-bottom: 10px;
      }

      .destinasi-scroll::-webkit-scrollbar {
        display: none;
      }

      .card {
        flex: 0 0 auto;
        width: 340px;
        margin-right: 20px;
      }

      .card-body {
        padding: 12px;
      }

      .card-img-top {
        height: 140px;
        object-fit: cover;
      }

      /* Tombol scroll kiri & kanan */
      .scroll-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        border: none;
        width: 36px;
        height: 36px;
        font-size: 18px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        z-index: 10;
      }

      .scroll-btn:hover {
        background-color: rgba(0, 0, 0, 0.8);
      }

      .scroll-left {
        left: 10px;
      }

      .scroll-right {
        right: 10px;
      }

      /* Tombol navigasi carousel Berita */
      .carousel-control-prev,
      .carousel-control-next {
        width: 36px;
        height: 36px;
        background-color: #6a6a6a; /* Biru */
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 1;
        padding: 6px;
        font-size: 0.8rem;
      }
      .carousel-control-prev-icon,
      .carousel-control-next-icon {
        background-image: none;
        color: white;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .carousel-control-prev::before,
      .carousel-control-next::before {
        content: "";
      }

      .carousel-control-prev-icon::after {
        content: "<";
        color: white;
        font-size: 30px;
        font-weight: normal;
      }

      .carousel-control-next-icon::after {
        content: ">";
        color: white;
        font-size: 30px;
        font-weight: normal;
      }
      a .carousel-control-prev:hover,
      .carousel-control-next:hover {
        background-color: #000000; /* Biru tua saat hover */
      }

      /* Berita Carousel */
      .carousel-caption h5 {
        font-size: 1.75rem;
        font-weight: 600;
      }

      .carousel-caption p {
        font-size: 1rem;
      }

      .carousel-caption {
        bottom: 20px;
      }

      .map-layout {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 30px;
        flex-wrap: wrap;
        margin-top: 30px;
      }

      .map-box {
        flex: 1 1 55%;
        min-width: 300px;
      }

      .info-box {
        flex: 1 1 40%;
        min-width: 250px;
        text-align: left;
      }

      .info-box h5 {
        color: #1d6ebf;
        margin-top: 10px;
        margin-bottom: 5px;
      }

      .info-box p {
        font-size: 1rem;
        color: #9f9f9f;
      }

      .berita-img {
        max-width: 600px;
        height: auto;
        margin: 0 auto;
        display: block;
      }

      .map-container iframe {
        width: 100%;
        height: 400px;
        border: 0;
        border-radius: 10px;
      }

      @media (max-width: 768px) {
        .card {
          flex: 0 0 80%;
        }
      }

      @media (max-width: 480px) {
        .card {
          flex: 0 0 100%;
        }
      }
    </style>
  </head>
  <body>
    <!--navbar include-->
<?php include '../include/navbar_comon.php'; ?>

    <!-- Banner -->
    <div class="banner text-center flex-column">
      <div style="position: relative; z-index: 2">
        <h2>Selamat Datang di pemesanan Garuda Indonesia Denpasar</h2>
      <?php if (isset($_SESSION['username'])): ?>
  <a class="btn pesan-tiket-btn mt-4 fw-semibold" href="list_tiket.php" class="btn btn-primary">Pesan Tiket</a>
<?php else: ?>
  <button class="btn pesan-tiket-btn mt-4 fw-semibold" onclick="mintaLogin()">Pesan Tiket</button>
<?php endif; ?>

      </div>
    </div>

<section class="tentang section">
    <h2>Tentang Kami</h2>
    <p>
        <?= nl2br(htmlspecialchars($isi)) ?>
    </p>
</section>


    <!-- Destinasi Wisata -->
<section class="destinasi section">
  <h2>Destinasi Wisata di Denpasar</h2>
  <p class="text-muted" style="font-size: 0.95rem">
    Berikut contoh dari wisata yang terdapat di Denpasar
  </p>

  <div class="destinasi-wrapper">
    <button class="scroll-btn scroll-left" onclick="scrollDestinasi(-1)">
      <i class="bi bi-chevron-left"></i>
    </button>

    <div class="destinasi-scroll" id="destinasiScroll">
      <?php
      // Ambil data dari tabel destinasi
      $result = $conn->query("SELECT * FROM destinasi ORDER BY id DESC");
      while ($row = $result->fetch_assoc()):
      ?>
        <div class="card">
          <img src="../super_admin/gambar_destinasi/<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama']) ?>" />
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($row['nama']) ?></h5>
            <p class="card-text"><?= htmlspecialchars($row['deskripsi']) ?></p>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <button class="scroll-btn scroll-right" onclick="scrollDestinasi(1)">
      <i class="bi bi-chevron-right"></i>
    </button>
  </div>
</section>
<!-- Section Berita -->
<section class="section bg-light">
  <div class="container">
    <h2 class="text-center mb-5">Berita Terkini</h2>
    <div id="beritaCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="1000">
          <div class="carousel-inner">
            <?php
            $berita = $conn->query("SELECT * FROM berita ORDER BY id DESC");
            $active = true;
            while ($row = $berita->fetch_assoc()):
            ?>
          <div class="carousel-item <?= $active ? 'active' : '' ?>">
            <div class="row justify-content-center">
              <div class="col-md-8">
                <img 
                  src="../super_admin/berita/<?= htmlspecialchars($row['gambar']) ?>" 
                  class="berita-img rounded w-100" 
                  alt="Gambar Berita" 
                />
              </div>
            </div>
          </div>
        <?php
        $active = false;
        endwhile;
        ?>
      </div>

      <!-- Kontrol Carousel -->
      <button class="carousel-control-prev" type="button" data-bs-target="#beritaCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Sebelumnya</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#beritaCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Selanjutnya</span>
      </button>
    </div>
  </div>
</section>

    <!-- Google Map -->
    <section class="map-container section">
      <h2>Lokasi Garuda Indonesia Denpasar</h2>
      <div class="map-layout">
        <div class="map-box">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.026777258431!2d115.22947007500526!3d-8.672744391356004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2410055b9be67%3A0x502a817012468531!2sGaruda%20Indonesia%20Sales%20Office%20Bali!5e0!3m2!1sid!2sid!4v1746608609343!5m2!1sid!2sid"
            width="100%"
            height="400"
            style="border: 0"
            allowfullscreen=""
            loading="lazy"
          ></iframe>
        </div>
        <div class="info-box">
          <h5>Alamat:</h5>
          <p>
            Jl. Sugianyar No.6, Dangin Puri Klod, Denpasar Timur, Kota Denpasar,
            Bali 80234
          </p>
          <p>
            Kantor ini berada sangat dekat dengan Monumen Bajra Sandhi dan
            Lapangan Puputan Renon — pusat kegiatan masyarakat dan landmark
            terkenal di Kota Denpasar.
          </p>
          <h5>Jam Operasional:</h5>
          <p>Senin - Jumat: 08.00 - 17.00 <br />Sabtu: 08.00 - 12.00</p>
          <h5>Telepon:</h5>
          <p>(0361) 234 317</p>
        </div>
      </div>
    </section>

   <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
    <script>
      function scrollDestinasi(direction) {
        const container = document.getElementById("destinasiScroll");
        const scrollAmount = 360; // lebar 1 card + margin

        container.scrollBy({
          left: direction * scrollAmount,
          behavior: "smooth",
        });
      }
    </script>
<script>
  function mintaLogin() {
    alert("Silakan login terlebih dahulu sebelum memesan tiket.");
    window.location.href = "login.php";
  }
</script>

 <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>    
  </body>
</html>
<?php include '../include/footer_comon.php'; ?>


