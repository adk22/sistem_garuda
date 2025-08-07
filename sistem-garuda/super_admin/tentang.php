<?php
// Koneksi ke database
include '../include/koneksi.php';

$msg = "";

// Proses form jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isi = $conn->real_escape_string($_POST["isi"]);

    // Cek apakah sudah ada data
    $check = $conn->query("SELECT id FROM tentang_kami LIMIT 1");

    if ($check->num_rows > 0) {
        $conn->query("UPDATE tentang_kami SET isi='$isi'");
        $msg = "Data berhasil diperbarui.";
    } else {
        $conn->query("INSERT INTO tentang_kami (isi) VALUES ('$isi')");
        $msg = "Data berhasil ditambahkan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Tentang Kami</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1000px;
            margin: 60px auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .top-bar {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn-back-circle {
            width: 40px;
            height: 40px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
            margin-right: 15px;
            transition: background-color 0.3s;
        }

        .btn-back-circle:hover {
            background-color: #0056b3;
        }

        h2 {
            margin: 0;
            font-size: 28px;
        }

        textarea {
            width: 100%;
            height: 400px;
            padding: 20px;
            font-size: 18px;
            border-radius: 8px;
            border: 1px solid #ccc;
            resize: vertical;
            box-sizing: border-box;
        }

        button {
            padding: 12px 30px;
            margin-top: 20px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 6px;
            font-size: 16px;
        }

        .btn-blue {
            background-color: #007BFF;
            color: white;
        }

        .btn-blue:hover {
            background-color: #0056b3;
        }

        .form-buttons {
            display: flex;
            justify-content: center;
        }

        /* Popup Style */
        .popup {
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.3s ease;
            position: fixed;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #28a745;
            color: white;
            padding: 15px 25px;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            z-index: 1000;
        }

        .popup.show {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>
<body>

<?php if (!empty($msg)): ?>
    <div class="popup" id="popup"><?php echo $msg; ?></div>
    <script>
        window.onload = function() {
            const popup = document.getElementById('popup');
            popup.classList.add('show');
            setTimeout(() => popup.classList.remove('show'), 3000);
        };
    </script>
<?php endif; ?>

<div class="container">
    <div class="top-bar">
        <a href="beranda_control.php" class="btn-back-circle" title="Kembali">&#8592;</a>
        <h2>Upload / Update Tentang Kami</h2>
    </div>

    <form method="POST">
        <textarea name="isi" required><?php
            $result = $conn->query("SELECT isi FROM tentang_kami LIMIT 1");
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo htmlspecialchars($row["isi"]);
            }
        ?></textarea>
        <div class="form-buttons">
            <button type="submit" class="btn-blue">Simpan</button>
        </div>
    </form>
</div>

</body>
</html>
