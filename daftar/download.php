<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
session_start();

if (!isset($_SESSION['form_data'])) {
    echo "Data tidak ditemukan.";
    exit();
}

$data = $_SESSION['form_data'];
include '../db.php';

$id = mysqli_query($connect, "SELECT * FROM data_pendaftar WHERE id_pendaftar=(SELECT MAX(id_pendaftar) FROM data_pendaftar)");
$id ? $rowid = mysqli_fetch_assoc($id) : '';

$paket = mysqli_query($connect, "SELECT * FROM paket_belajar WHERE id_paket='" . $data['id_paket'] . "'");
$paket ? $rowpaket = mysqli_fetch_assoc($paket) : '';

$html = "
<html>

<head>
    <meta charset='UTF-8' />
    <style>
        .container {
            background-color: rgb(255, 255, 255);
            width: 650px;
            border: 1px solid yellow;
            border-radius: 20px;
            padding: 20px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .head-form img{
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
            font-family: 'Times New Roman', Times, serif;
        }
        .body-form {
            margin: 20px;
        }
        .body-form tr td:first-child{
            font-size: 17px;
            width: 200px;
        }
        .body-form tr td:last-child{
            height: fit-content;
        }
        .body-form tr td:last-child div {
            padding: 5px;
            width: 350px;
            border-bottom: 0.5px solid rgb(255, 166, 0);
            font-size: 17px;
        }

        .container p{
            margin-top: 60px;
            font-size: 12px;
            color: rgb(92, 92, 92);
        } 
    </style>
</head>

<body>
    <div class='container'>
        <table class='head-form' cellpadding='5'>
            <tr>
                <td><img src='data:image/png;base64," . base64_encode(file_get_contents('../asset/full-logo.png')) . "' alt='IQ-Bimbel' /></td>
                <td><h3>Formulir Pendaftaran</h3></td>
            </tr>
        </table>

        <table class='body-form' cellpadding='10'>
            <tr>
                <td>Nama:</td>
                <td><div>{$data['nama']}</div></td>
                
            </tr>
            <tr>
                <td>Umur:</td>
                <td><div>{$data['umur']}</div></td>
            </tr>
            <tr>
                <td>Kelas:</td>
                <td><div>{$data['kelas']} {$data['tingkat']}</div></td>
            </tr>
            <tr>
                <td>Asal Sekolah:</td>
                <td><div>{$data['asal_sekolah']}</div></td>
            </tr>
            <tr>
                <td>Mapel Favorit:</td>
                <td><div>{$data['mapel_favorit']}</div></td>
            </tr>
            
            <tr>
                <td>Alamat:</td>
                <td><div>{$data['alamat']}</div></td>
                
            </tr>
            <tr>
                <td>Nama Orang Tua:</td>
                <td><div>{$data['nama_ortu']}</div></td>
            </tr>
            <tr>
                <td>No Telp Orang Tua:</td>
                <td><div>{$data['no_ortu']}</div></td>
            </tr>
            <tr>
                <td>Paket Yang Dipilih:</td>
                <td><div>{$rowpaket['nama_paket']}</div></td>
            </tr>
            
        </table>


        <p>Kode: {$rowid['id_pendaftar']}</p>
    </div>
</body>

</html>
</body>

</html>
";
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// output ke browser sebagai PDF download
$dompdf->stream("formulir_pendaftaran.pdf", array("Attachment" => 1));

unset($_SESSION['form_data']);
exit();
?>