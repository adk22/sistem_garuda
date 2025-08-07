<?php include '../include/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hotel</title>
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

      .judul {
        padding-top: 120px;
        text-align: center;
        margin-bottom: 20px;
      }

      .judul h2 {
        font-weight: 700;
        color: #1d6ebf;
      }

      .hotel-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
      }

      .hotel-card img {
        object-fit: cover;
        height: 150px;
        width: 100%;
      }

      .hotel-info {
        padding: 20px;
      }

      .rating i {
        margin-right: 2px;
      }

      .harga {
        color: orange;
        font-weight: bold;
        font-size: 1rem;
      }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <?php include '../include/navbar_comon.php'; ?>

    <!-- Judul -->
    <div class="judul">
      <h2>Hotel</h2>
    </div>

    <!-- Daftar Hotel -->
    <div class="container mb-5">
      <?php
      $query = mysqli_query($conn, "SELECT * FROM hotel_control");
      while ($row = mysqli_fetch_assoc($query)) {
        $nama = htmlspecialchars($row['nama']);
        $deskripsi = nl2br(htmlspecialchars($row['deskripsi']));
        $gambar = '../super_admin/hotel_control/' . $row['gambar'];
        $rating = $row['rating'];
        $harga = number_format($row['harga'], 0, ',', '.');
        $link = htmlspecialchars($row['link_kamar']);

        // Tentukan icon bintang
        $fullStars = floor($rating);
        $halfStar = ($rating - $fullStars) >= 0.5;
      ?>
      <div class="card hotel-card mb-4">
        <div class="row g-0 align-items-center">
          <div class="col-md-3">
            <img src="<?= $gambar ?>" alt="<?= $nama ?>" />
          </div>
          <div class="col-md-9">
            <div class="hotel-info d-flex flex-column justify-content-between h-100">
              <div>
                <h5 class="card-title"><?= $nama ?></h5>
                <p class="card-text"><?= $deskripsi ?></p>
                <div class="rating text-warning mb-2">
                  <?php for ($i = 0; $i < $fullStars; $i++): ?>
                    <i class="bi bi-star-fill"></i>
                  <?php endfor; ?>
                  <?php if ($halfStar): ?>
                    <i class="bi bi-star-half"></i>
                  <?php endif; ?>
                  <span class="text-dark ms-2"><?= $rating ?></span>
                </div>
              </div>
              <div class="d-flex justify-content-end align-items-center gap-3">
                <span class="harga">Rp <?= $harga ?></span>
                <a href="<?= $row['link_kamar'] ?>" class="btn btn-success">Pesan kamar</a>

              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>

    <!-- Footer -->
    <?php include '../include/footer_comon.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
