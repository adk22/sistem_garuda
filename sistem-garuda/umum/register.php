<?php
include '../include/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_depan = $_POST['namaDepan'];
    $nama_belakang = $_POST['namaBelakang'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password_raw = $_POST['password'];
    $kewarganegaraan = $_POST['kewarganegaraan'];
    $negara = $_POST['negara'];
    $alamat = $_POST['alamat'];
    $role = 'user';
    $nama = $nama_depan . ' ' . $nama_belakang;

    // Validasi panjang password (minimal 6 karakter)
    if (strlen($password_raw) < 6) {
        echo "<script>alert('Password minimal 6 karakter'); window.history.back();</script>";
        exit;
    }

    // Hash password
    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    // Insert ke database
    $query = "INSERT INTO user (nama, email, username, password, role, nama_depan, nama_belakang, kewarganegaraan, negara, alamat)
              VALUES ('$nama', '$email', '$username', '$password', '$role', '$nama_depan', '$nama_belakang', '$kewarganegaraan', '$negara', '$alamat')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='login.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menyimpan data: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Form Register</title>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: Arial, sans-serif;
      max-width: 600px;
      margin: 30px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      background-color: #f9f9f9;
    }
    h2 { text-align: center; }
    label { display: block; margin-top: 10px; font-weight: bold; }
    input, select, button {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      margin-bottom: 15px;
      border: 1px solid #aaa;
      border-radius: 5px;
      font-size: 15px;
    }
    button {
      background-color: #003b7a;
      color: white;
      border: none;
      cursor: pointer;
      font-weight: bold;
    }
    button:hover {
      background-color: #0055aa;
    }
  </style>
</head>
<body>

<h2>Register</h2>
<p>Silakan isi form register di bawah dengan data diri yang benar.</p>

<form method="POST" action="">
  <label for="namaDepan">Nama Depan*</label>
  <input type="text" id="namaDepan" name="namaDepan" required placeholder="Adi" />

  <label for="namaBelakang">Nama Belakang*</label>
  <input type="text" id="namaBelakang" name="namaBelakang" required placeholder="Korsa" />

  <label for="email">Email*</label>
  <input type="email" id="email" name="email" required placeholder="adi@example.com" />

  <label for="username">Username*</label>
  <input type="text" id="username" name="username" required placeholder="adikorsa123" />

  <label for="password">Password* (minimal 6 karakter)</label>
  <input type="password" id="password" name="password" required minlength="6" placeholder="min 6 karakter" />

  <label for="kewarganegaraan">Kewarganegaraan</label>
  <select id="kewarganegaraan" name="kewarganegaraan">
    <option value="" disabled selected hidden>Pilih Kewarganegaraan</option>
    <option value="Indonesia">WNI</option>
    <option value="Asing">WNA</option>
  </select>

  <label for="negara">Negara</label>
  <input type="text" id="negara" name="negara" placeholder="Indonesia" />

  <label for="alamat">Alamat</label>
  <input type="text" id="alamat" name="alamat" placeholder="Jl. Merdeka No.1" />

  <button type="submit">Submit</button>
</form>

</body>
</html>
