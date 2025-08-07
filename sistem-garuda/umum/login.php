<?php
session_start();
include '../include/koneksi.php';

// Jika sudah login, arahkan ke halaman utama user
if (isset($_SESSION['role']) && $_SESSION['role'] == 'user') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_email = $_POST['username'];
    $password = $_POST['password'];

    if (strlen($password) < 6) {
        echo "<script>alert('Password minimal 6 karakter'); window.history.back();</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username_email, $username_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            // Set semua session setelah login berhasil
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['nama_depan'] = $row['nama_depan'] ?? '';
            $_SESSION['nama_belakang'] = $row['nama_belakang'] ?? '';
            $_SESSION['kewarganegaraan'] = $row['kewarganegaraan'] ?? '-';
            $_SESSION['negara'] = $row['negara'] ?? '-';
            $_SESSION['alamat'] = $row['alamat'] ?? '-';
            $_SESSION['role'] = 'user';

            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Password salah'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Akun tidak ditemukan'); window.history.back();</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Garuda Indonesia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: url('../gambar/banner.jpg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .main-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 20px;
      backdrop-filter: blur(2px);
    }

    .login-box {
      background: rgba(255, 255, 255, 0.85);
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 700px;
      display: flex;
      overflow: hidden;
      flex-direction: row;
    }

    .logo-box {
      background-color: rgba(234, 240, 246, 0.7);
      width: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .logo-box img {
      max-height: 120px;
      width: auto;
    }

    .form-box {
      width: 50%;
      padding: 30px;
    }

    .form-box h2 {
      text-align: center;
      margin-bottom: 10px;
      font-weight: bold;
    }

    .form-box p {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
      font-size: 14px;
    }

    .form-box label {
      font-weight: bold;
      margin-top: 10px;
    }

    .form-box input {
      width: 100%;
      padding: 10px;
      margin: 8px 0 16px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .button-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .login-btn {
      padding: 8px 16px;
      border-radius: 6px;
      border: none;
      background-color: #1d6ebf;
      color: white;
      cursor: pointer;
    }

    .signin-btn {
      background-color: transparent;
      color: #1d6ebf;
      border: none;
      padding: 0;
      font-weight: normal;
      text-decoration: none;
      cursor: pointer;
    }

    .signin-btn:hover {
      color: #004080;
    }

    @media (max-width: 768px) {
      .login-box {
        flex-direction: column;
      }

      .logo-box,
      .form-box {
        width: 100%;
      }

      .logo-box {
        padding: 30px;
      }
    }
  </style>
</head>
<body>

  <div class="main-container">
    <div class="login-box">
      <!-- Logo Garuda -->
      <div class="logo-box">
        <img src="../gambar/GA SkyTeam.png" alt="Garuda Indonesia">
      </div>

      <!-- Form Login -->
      <div class="form-box">
        <h2>LOGIN</h2>
        <p>Silakan isi data berikut</p>
        <form method="POST" action="">
          <label for="username">Email / Username</label>
          <input type="text" name="username" placeholder="Username atau Email" required />

          <label for="password">Password</label>
          <input type="password" name="password" placeholder="Password (min 6 char)" minlength="6" required />

          <div class="button-row">
            <button type="submit" class="login-btn">Login</button>
            <button type="button" class="signin-btn" onclick="window.location.href='register.php'">register?</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
