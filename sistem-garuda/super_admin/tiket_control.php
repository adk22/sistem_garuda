<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: ../umum/loginadmin.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "sistem_garuda");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$batas = $conn->query("SELECT batas_pemesanan FROM tiket_config WHERE id = 1")->fetch_assoc()['batas_pemesanan'];
$promo = $conn->query("SELECT * FROM promo ORDER BY id DESC");
$dataTiket = $conn->query("SELECT * FROM list_tiket ORDER BY id DESC");

if (isset($_POST['simpan_tiket'])) {
    $id = $_POST['id'] ?? '';
    $kode = strtoupper(trim($_POST['kode']));
    $asal = trim($_POST['asal']);
    $tujuan = trim($_POST['tujuan']);
    $jam_berangkat = $_POST['jam_berangkat'];
    $jam_tiba = $_POST['jam_tiba'];
    $harga = intval($_POST['harga']);
    $kode_promo = $_POST['kode_promo'] ?? null;
    $keterangan_waktu = $_POST['keterangan_waktu'];
    $jumlah_kursi = intval($_POST['jumlah_kursi']);
    $kelas = $_POST['kelas'];

    if ($id) {
        $stmt = $conn->prepare("UPDATE list_tiket SET kode=?, asal=?, tujuan=?, jam_berangkat=?, jam_tiba=?, harga=?, keterangan_waktu=?, kelas=?, kode_promo=?, jumlah_kursi=? WHERE id=?");
        $stmt->bind_param("ssssssssssi", $kode, $asal, $tujuan, $jam_berangkat, $jam_tiba, $harga, $keterangan_waktu, $kelas, $kode_promo, $jumlah_kursi, $id);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO list_tiket (kode, asal, tujuan, jam_berangkat, jam_tiba, harga, keterangan_waktu, kelas, kode_promo, jumlah_kursi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssisssi", $kode, $asal, $tujuan, $jam_berangkat, $jam_tiba, $harga, $keterangan_waktu, $kelas, $kode_promo, $jumlah_kursi);
        $stmt->execute();
    }
    echo "<script>alert('Tiket berhasil disimpan.'); window.location.href='tiket_control.php';</script>";
    exit;
}

$editTiket = null;
if (isset($_GET['edit_tiket'])) {
    $id = intval($_GET['edit_tiket']);
    $res = $conn->query("SELECT * FROM list_tiket WHERE id = $id");
    if ($res->num_rows > 0) {
        $editTiket = $res->fetch_assoc();
    }
}

if (isset($_GET['hapus_promo'])) {
    $id = intval($_GET['hapus_promo']);
    $conn->query("DELETE FROM promo WHERE id = $id");
    header("Location: tiket_control.php");
    exit;
}

if (isset($_POST['tambah_promo'])) {
    $kode = strtoupper(trim($_POST['kode']));
    $diskon = intval($_POST['diskon']);
    $stmt = $conn->prepare("INSERT INTO promo (kode, diskon_persen) VALUES (?, ?)");
    $stmt->bind_param("si", $kode, $diskon);
    $stmt->execute();
    header("Location: tiket_control.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kontrol Tiket - Superadmin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Sidebar -->
<?php include '../include/sidebar_admin.php'; ?>

<!-- Konten utama -->
<div class="container py-4" style="padding-left: 270px;">
    <h2 class="mb-4">Kontrol Tiket - Superadmin</h2>

    <!-- Tambah Promo -->
    <div class="card mb-4">
        <div class="card-header">Kode Promo</div>
        <div class="card-body">
            <form method="POST" class="row g-2 align-items-center mb-3">
                <div class="col-md-4">
                    <input type="text" name="kode" class="form-control" placeholder="Kode promo" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="diskon" class="form-control" placeholder="Diskon (%)" min="0" max="100" required>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="tambah_promo" class="btn btn-success">Tambah Promo</button>
                </div>
            </form>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Diskon (%)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $promo->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['kode']) ?></td>
                        <td><?= $row['diskon_persen'] ?>%</td>
                        <td>
                            <a href="?hapus_promo=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus promo ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form Tiket -->
    <div class="card mb-4">
        <div class="card-header">Form Tiket</div>
        <div class="card-body">
            <form method="POST">
                <?php if ($editTiket): ?>
                    <input type="hidden" name="id" value="<?= $editTiket['id'] ?>">
                <?php endif; ?>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label>Kode Penerbangan</label>
                        <input type="text" name="kode" class="form-control" required value="<?= $editTiket['kode'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Asal</label>
                        <input type="text" name="asal" class="form-control" required value="<?= $editTiket['asal'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Tujuan</label>
                        <input type="text" name="tujuan" class="form-control" required value="<?= $editTiket['tujuan'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Jam Berangkat</label>
                        <input type="time" name="jam_berangkat" class="form-control" required value="<?= $editTiket['jam_berangkat'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Jam Tiba</label>
                        <input type="time" name="jam_tiba" class="form-control" required value="<?= $editTiket['jam_tiba'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Keterangan Waktu</label>
                        <select name="keterangan_waktu" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Pagi" <?= isset($editTiket['keterangan_waktu']) && $editTiket['keterangan_waktu'] == 'Pagi' ? 'selected' : '' ?>>Pagi</option>
                            <option value="Siang" <?= isset($editTiket['keterangan_waktu']) && $editTiket['keterangan_waktu'] == 'Siang' ? 'selected' : '' ?>>Siang</option>
                            <option value="Malam" <?= isset($editTiket['keterangan_waktu']) && $editTiket['keterangan_waktu'] == 'Malam' ? 'selected' : '' ?>>Malam</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Kelas</label>
                        <select name="kelas" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Ekonomi" <?= isset($editTiket['kelas']) && $editTiket['kelas'] == 'Ekonomi' ? 'selected' : '' ?>>Ekonomi</option>
                            <option value="Bisnis" <?= isset($editTiket['kelas']) && $editTiket['kelas'] == 'Bisnis' ? 'selected' : '' ?>>Bisnis</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Jumlah Kursi</label>
                        <input type="number" name="jumlah_kursi" class="form-control" min="1" required value="<?= $editTiket['jumlah_kursi'] ?? '20' ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" required value="<?= $editTiket['harga'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Promo (opsional)</label>
                        <select name="kode_promo" class="form-control">
                            <option value="">Tanpa Promo</option>
                            <?php
                            $promo->data_seek(0);
                            while ($p = $promo->fetch_assoc()):
                            ?>
                            <option value="<?= $p['kode'] ?>" <?= (isset($editTiket['kode_promo']) && $editTiket['kode_promo'] == $p['kode']) ? 'selected' : '' ?>>
                                <?= $p['kode'] ?> (<?= $p['diskon_persen'] ?>%)
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" name="simpan_tiket" class="btn btn-success"><?= $editTiket ? 'Simpan Perubahan' : 'Tambah Tiket' ?></button>
                    <?php if ($editTiket): ?>
                        <a href="tiket_control.php" class="btn btn-secondary">Batal</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Tiket -->
    <div class="card mb-5">
        <div class="card-header">Daftar Tiket Penerbangan</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Asal</th>
                        <th>Tujuan</th>
                        <th>Jam Berangkat</th>
                        <th>Jam Tiba</th>
                        <th>Keterangan</th>
                        <th>Kelas</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $dataTiket->data_seek(0); while ($row = $dataTiket->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['kode']) ?></td>
                        <td><?= htmlspecialchars($row['asal']) ?></td>
                        <td><?= htmlspecialchars($row['tujuan']) ?></td>
                        <td><?= $row['jam_berangkat'] ?></td>
                        <td><?= $row['jam_tiba'] ?></td>
                        <td><?= $row['keterangan_waktu'] ?></td>
                        <td><?= $row['kelas'] ?></td>
                        <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td>
                            <a href="?edit_tiket=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
