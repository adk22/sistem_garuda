<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Halaman Pembelian Tiket</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    />
    <style>
      .btn-print {
        float: right;
        margin-bottom: 15px;
      }
    </style>
  </head>
  <body>
    <div class="container my-5">
      <h2 class="mb-4">Daftar Pembelian Tiket</h2>

      <button class="btn btn-primary btn-print" onclick="cetakPDF()">
        Cetak PDF
      </button>

      <div id="area-tabel">
        <table class="table table-bordered table-striped">
          <thead class="table-dark">
            <tr>
              <th>No</th>
              <th>Nama Pemesan</th>
              <th>Tujuan</th>
              <th>Tanggal Keberangkatan</th>
              <th>Tanggal Pulang</th>
              <th>Waktu Keberangkatan</th>
              <th>Nama Hotel</th>
              <th>Kamar Dipesan</th>
              <th>Status</th>
              <th>Bukti Pembayaran</th>
            </tr>
          </thead>
          <tbody id="tabel-tiket">
            <!-- Baris data tiket akan dimuat secara dinamis -->
          </tbody>
        </table>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
      const tiketData = [
        {
          id: 1,
          nama: "Budi Santoso",
          tujuan: "Jakarta",
          tanggal: "2025-07-10",
          tanggalPulang: "2025-07-15",
          waktu: "08:00",
          status: "Menunggu Pembayaran",
          hotel: "Prama Hotel",
          kamar: "Deluxe",
          buktiPembayaran: "bukti/bukti1.jpg",
        },
        {
          id: 2,
          nama: "Sari Dewi",
          tujuan: "Surabaya",
          tanggal: "2025-07-12",
          tanggalPulang: "2025-07-18",
          waktu: "10:30",
          status: "Lunas",
          hotel: "Hotel Santika",
          kamar: "Superior",
          buktiPembayaran: "bukti/bukti2.jpg",
        },
        {
          id: 3,
          nama: "Agus Wibowo",
          tujuan: "Medan",
          tanggal: "2025-07-15",
          tanggalPulang: "2025-07-20",
          waktu: "13:45",
          status: "Menunggu Pembayaran",
          hotel: "-",
          kamar: "-",
          buktiPembayaran: "",
        },
        {
          id: 4,
          nama: "Rina Lestari",
          tujuan: "Yogyakarta",
          tanggal: "2025-07-20",
          tanggalPulang: "2025-07-26",
          waktu: "07:15",
          status: "Diblokir",
          hotel: "The Alana",
          kamar: "Suite",
          buktiPembayaran: "bukti/bukti4.jpg",
        },
      ];

      function renderTabel() {
        const tbody = document.getElementById("tabel-tiket");
        tbody.innerHTML = "";

        tiketData.forEach((tiket, index) => {
          const tr = document.createElement("tr");

          tr.innerHTML = `
            <td>${index + 1}</td>
            <td>${tiket.nama}</td>
            <td>${tiket.tujuan}</td>
            <td>${tiket.tanggal}</td>
            <td>${tiket.tanggalPulang}</td>
            <td>${tiket.waktu}</td>
            <td>${tiket.hotel}</td>
            <td>${tiket.kamar}</td>
            <td>${tiket.status}</td>
            <td>
              ${
                tiket.buktiPembayaran
                  ? `<a href="${tiket.buktiPembayaran}" target="_blank" class="btn btn-sm btn-info">Lihat</a>`
                  : "-"
              }
            </td>
          `;
          tbody.appendChild(tr);
        });
      }

      async function cetakPDF() {
        const area = document.getElementById("area-tabel");
        const canvas = await html2canvas(area, { scale: 2 });
        const imgData = canvas.toDataURL("image/png");

        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF("l", "mm", "a4");
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        pdf.addImage(imgData, "PNG", 10, 10, pdfWidth - 20, pdfHeight);
        pdf.save("daftar-tiket.pdf");
      }

      // Inisialisasi
      renderTabel();
    </script>
  </body>
</html>
