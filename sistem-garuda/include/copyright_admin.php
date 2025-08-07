<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Footer Kecil & Transparan</title>
    <style>
      body {
        margin: 0;
        font-family: Arial, sans-serif;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background-color: #f0f0f0; /* contoh latar terang */
        color: #000000;
      }

      footer {
        background-color: transparent;
        color: #000000;
        text-align: center;
        padding: 8px 0;
        margin-top: auto;
        border-top: 1px solid #000000;
        border-bottom: 1px solid #000000;
        font-size: 11px; /* Ukuran teks kecil */
      }

      .slogan {
        font-style: italic;
        margin-bottom: 2px;
      }

      .copyright {
        margin: 0;
      }
    </style>
  </head>
  <body>
    <!-- Konten halaman -->

    <!-- copyright_admin.php -->
<footer class="w-full flex justify-center mt-8">
  <div class="text-center text-sm text-gray-500 border-t pt-4 w-full max-w-4xl">
    <p class="italic mb-1">Because you matter</p>
    <p>&copy; <?= date('Y'); ?> Garuda Indonesia Denpasar. Semua hak dilindungi.</p>
  </div>
</footer>
  </body>
</html>
