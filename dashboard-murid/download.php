<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
session_start();
include "../db.php";

$id_murid = $_POST['murid'];
$bulan = $_POST['bulan'];
$tahun = $_POST['tahun'];
$queryNilai = "SELECT a.*, b.mata_pelajaran FROM nilai a INNER JOIN mapel b ON a.id_mapel=b.id_mapel WHERE id_murid=$id_murid AND a.bulan='$bulan' AND a.tahun='$tahun'";

$nilai = mysqli_query($connect, $queryNilai);

ob_start();
?>
<html>

<head>
  <meta charset="UTF-8" />
  <style>
    .container {
      background-color: rgb(255, 255, 255);
      width: 660px;
      border: 1px solid yellow;
      border-radius: 20px;
      padding: 20px;
      font-family: Arial, Helvetica, sans-serif;
    }

    .head-form {
      width: 100%;
    }

    .head-form img {
      width: 320px;
    }

    .head-form h3 {
      font-size: 23px;
      text-decoration: underline;
    }

    .logo {
      display: flex;
      align-items: center;
    }

    .logo .judul {
      font-size: 23px;
      font-weight: bold;
      color: rgb(253, 208, 9);
      text-shadow: 20px 16px 3px #302e2e5e;
      font-family: "Times New Roman", Times, serif;
    }
    .container div{
      margin: 20px 0;
    }
    .input {
      border: 1px solid rgb(255, 136, 0);
      font-size: 15px;
      border-radius: 5px;
      padding: 3px 5px;
    }

    table {
      border-spacing: 0;
    }

    th,
    td {
      padding: 10px;
      text-align: center;
    }

    th {
      border-bottom: 3px double rgb(255, 136, 0);
      background-color: rgba(255, 251, 0, 0.493);
    }

    table:last-child td {
      border-bottom: 1px solid rgb(255, 136, 0);
    }
    .more-info td{
      font-weight: bold;
    }
  </style>
</head>

<body>
  <div class="container">
    <table class="head-form" cellpadding="5">
      <tr>
        <td>
          <img src="data:image/png;base64,<?= base64_encode(file_get_contents('../asset/full-logo.png')) ?>"
            alt="IQ-Bimbel" />
        </td>
        <td>
          <h3>Rekap Nilai <?= $id_murid ?></h3>
        </td>
      </tr>
    </table>
    <div>
      <span class="bulan">
        <label for="bulan">Bulan: </label>
        <span class="input"><?= $bulan ?></span>
      </span>
      <span class="tahun">
        <label for="tahun">Tahun: </label>
        <span class="input"><?= $tahun ?></span>
      </span>
    </div>
    <table>
      <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Mata Pelajaran</th>
        <th colspan="4">Penilaian</th>
        <th rowspan="2">Total Nilai</th>
        <th rowspan="2">Grade</th>
      </tr>
      <tr>
        <th>Latihan</th>
        <th>Tugas</th>
        <th>Quiz</th>
        <th>Ulangan</th>
      </tr>
      <?php
      $no = 1;
      while ($dataNilai = mysqli_fetch_assoc($nilai)) {

        ?>
        <tbody class="toggle-more-info">
          <tr class="main-info">
            <td rowspan="2"><?= $no ?></td>
            <td><?= $dataNilai['mata_pelajaran'] ?></td>
            <td><?= $dataNilai['latihan'] ?></td>
            <td><?= $dataNilai['tugas'] ?></td>
            <td><?= $dataNilai['quiz'] ?></td>
            <td><?= $dataNilai['ulangan'] ?></td>
            <td><?= $dataNilai['total_nilai'] ?></td>
            <td><?= $dataNilai['grade'] ?></td>
          </tr>
          <tr class="more-info">
            <th>Keterangan:</th>
            <td colspan="6"><?= $dataNilai['keterangan'] ?></td>
          </tr>
        </tbody>
        <?php
        $no++;
      }
      ?>
    </table>
  </div>
</body>

</html>

<?php
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// output ke browser sebagai PDF download
$dompdf->stream("rekap_nilai_$id_murid.pdf", array("Attachment" => 1));

exit();
?>