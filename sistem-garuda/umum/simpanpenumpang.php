<?php
$koneksi = new mysqli("localhost", "root", "", "sistem_garuda");

$kode_tiket = $_POST['kode_tiket'];
$nama_lengkap_arr = $_POST['nama_lengkap'];
$jenis_kelamin_arr = $_POST['jenis_kelamin'];
$negara_arr = $_POST['negara'];
$alamat_arr = $_POST['alamat'];

$total = count($nama_lengkap_arr);

for ($i = 0; $i < $total; $i++) {
  $nama_lengkap = $koneksi->real_escape_string($nama_lengkap_arr[$i]);
  $jenis_kelamin = $koneksi->real_escape_string($jenis_kelamin_arr[$i]);
  $negara = $koneksi->real_escape_string($negara_arr[$i]);
  $alamat = $koneksi->real_escape_string($alamat_arr[$i]);

  $stmt = $koneksi->prepare("INSERT INTO penumpang (kode_tiket, nama_lengkap, jenis_kelamin, negara, alamat) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $kode_tiket, $nama_lengkap, $jenis_kelamin, $negara, $alamat);
  $stmt->execute();
  $stmt->close();
}

$koneksi->close();
echo "Data semua penumpang berhasil disimpan!";
<script>
  document.getElementById("formPenumpang").addEventListener("submit", async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append("kode_tiket", "<?= $kode_tiket ?>");

    try {
      const response = await fetch("simpanpenumpang.php", {
        method: "POST",
        body: formData
      });

      const result = await response.text();
      alert(result);
      window.location.href = "pembayaran.php?kode_tiket=<?= $kode_tiket ?>";

    } catch (err) {
      alert("Gagal menyimpan data penumpang. Coba lagi.");
      console.error(err);
    }
  });
</script>

?>
