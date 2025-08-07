<?php
session_start();
include '../include/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // SUPERADMIN
    if (substr($password, 0, 3) === 'SGA') {
        $query = "SELECT * FROM user WHERE (username = ? OR email = ?) AND role = 'superadmin' LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows === 1) {
            $data = $result->fetch_assoc();
            if ($password === $data['password']) {
                $_SESSION['id'] = $data['id'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['nama'] = $data['nama'];
                $_SESSION['role'] = $data['role'];
                header("Location: ../super_admin/index_superadmin.php");
                exit();
            } else {
                echo "<script>alert('Password superadmin salah!');window.history.back();</script>";
                exit();
            }
        } else {
            echo "<script>alert('Akun superadmin tidak ditemukan!');window.history.back();</script>";
            exit();
        }
    }

    // ADMIN
    if (substr($password, 0, 2) === 'GA') {
        $checkAdmin = $conn->query("SELECT COUNT(*) as total FROM user WHERE role = 'admin'");
        $adminData = $checkAdmin->fetch_assoc();
        if ($adminData['total'] > 2) {
            echo "<script>alert('Jumlah admin melebihi batas maksimal.');window.history.back();</script>";
            exit();
        }

        $query = "SELECT * FROM user WHERE (username = ? OR email = ?) AND role = 'admin'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows === 1) {
            $data = $result->fetch_assoc();
            if ($password === $data['password']) {
                $_SESSION['id'] = $data['id'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['nama'] = $data['nama'];
                $_SESSION['role'] = $data['role'];
                header("Location: ../admin/index_admin.php");
                exit();
            } else {
                echo "<script>alert('Password salah!');window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Akun admin tidak ditemukan!');window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Login gagal! Gunakan password yang valid.');window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Admin - Garuda Indonesia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
    }

    body {
      background: url('../gambar/banner.jpg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: Arial, sans-serif;
      animation: fadeInBody 1s ease-in-out;
    }

    @keyframes fadeInBody {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-container {
      background-color: rgba(255, 255, 255, 0.88);
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      width: 90%;
      max-width: 450px;
      animation: slideFadeIn 1s ease;
    }

    @keyframes slideFadeIn {
      from {
        transform: translateY(30px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .login-header-blue {
      background-color: rgb(122, 188, 255);
      padding: 20px;
      text-align: center;
    }

    .login-header-blue img {
      height: 50px;
      animation: popIn 0.8s ease;
    }

    @keyframes popIn {
      0% { transform: scale(0.5); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }

    .login-body {
      padding: 40px 30px;
    }

    .login-body h2 {
      font-weight: bold;
      text-align: center;
      margin-bottom: 20px;
      animation: fadeInText 1s ease-in-out;
    }

    @keyframes fadeInText {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .form-label {
      font-weight: bold;
      margin-top: 10px;
    }

    .form-control {
      margin-bottom: 16px;
    }

    .login-btn {
      width: 100%;
      padding: 10px;
      background-color: #1d6ebf;
      color: white;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      transition: background-color 0.3s, transform 0.2s;
    }

    .login-btn:hover {
      background-color: #004080;
      transform: scale(1.03);
    }

    .copyright {
      text-align: center;
      margin-top: 15px;
      font-size: 12px;
      color: #777;
      animation: fadeInText 1s ease-in-out 1s;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-header-blue" id="headerBlue">
      <img src="../gambar/GA SkyTeam.png" alt="Garuda Logo" />
    </div>

    <div class="login-body">
      <h2>LOGIN ADMIN</h2>
      <p class="text-center">Silakan isi data untuk masuk</p>

      <?php if (isset($_GET['logout']) && $_GET['logout'] === 'success'): ?>
        <div class="alert alert-success text-center" role="alert">
          Anda telah berhasil logout.
        </div>
      <?php endif; ?>

      <form method="POST" action="loginadmin.php">
        <label for="username" class="form-label">Email / Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan username atau email" required />

        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password" minlength="6" required />

        <button type="submit" class="login-btn">Login</button>
      </form>

      <div class="copyright">
        © Garuda Indonesia. All rights reserved.
      </div>
    </div>
  </div>
</body>
</html>
