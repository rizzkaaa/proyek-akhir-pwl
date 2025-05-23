<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../db.php";

if (isset($_GET['id_paket'])) {
    $id_paket = $_GET['id_paket'];
} else {
    $id_paket = 'D';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nama'], $_POST['umur'], $_POST['kelas'], $_POST['tingkat'], $_POST['asal_sekolah'], $_POST['mapel_favorit'], $_POST['alamat'], $_POST['nama_ortu'], $_POST['no_ortu'], $_POST['id_paket'])) {
        $nama = mysqli_real_escape_string($connect, ucwords(strtolower($_POST['nama'])));
        $umur = mysqli_real_escape_string($connect, $_POST['umur']);
        $kelas = mysqli_real_escape_string($connect, $_POST['kelas']);
        $tingkat = mysqli_real_escape_string($connect, $_POST['tingkat']);
        $asal_sekolah = mysqli_real_escape_string($connect, strtoupper($_POST['asal_sekolah']));
        $mapel_favorit = mysqli_real_escape_string($connect, ucwords(strtolower($_POST['mapel_favorit'])));
        $alamat = mysqli_real_escape_string($connect, ucwords(strtolower($_POST['alamat'])));
        $nama_ortu = mysqli_real_escape_string($connect, ucwords(strtolower($_POST['nama_ortu'])));
        $no_ortu = mysqli_real_escape_string($connect, $_POST['no_ortu']);
        $id_paket = mysqli_real_escape_string($connect, $_POST['id_paket']);

        $today = date("Y-m-d");

        $tgl_exp = date("Y-m-d", strtotime("+3 days", strtotime($today)));

        $query = "INSERT INTO data_pendaftar (nama, umur, kelas, tingkat, asal_sekolah, mapel_favorit, alamat, nama_ortu, no_ortu, id_paket, tgl_exp)
        VALUES ('$nama', $umur, $kelas, '$tingkat', '$asal_sekolah', '$mapel_favorit', '$alamat', '$nama_ortu', $no_ortu, '$id_paket', '$tgl_exp')";

        if (mysqli_query($connect, $query)) {
            session_start();
            $_SESSION['form_data'] = [
                'nama' => $nama,
                'umur' => $umur,
                'kelas' => $kelas,
                'tingkat' => $tingkat,
                'asal_sekolah' => $asal_sekolah,
                'mapel_favorit' => $mapel_favorit,
                'alamat' => $alamat,
                'nama_ortu' => $nama_ortu,
                'no_ortu' => $no_ortu,
                'id_paket' => $id_paket,
            ];

            header("Location: download.php");
            exit();

        } else {
            echo "Query gagal: " . mysqli_error($connect);
        }
    } else {
        echo "Data tidak lengkap";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="../asset/thumbnail.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | Insight & Quality Bimbel</title>
    <link rel="stylesheet" href="./daftar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bona+Nova+SC:ital,wght@0,400;0,700;1,400&family=Tuffy:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="container">
        <header>
            <img src="../asset/anak-form.png">
            <h1>Selamat Datang <br> di IQ Bimbel</h1>
            <img src="../asset/guru-form.png">
        </header>

        <form method="POST">
            <div class="head-form">
                <div class="logo">
                    <a href="../"><img src="../asset/iq-bimbel.png" alt="IQ-Bimbel"></a>
                    <div class="judul">Insight & Quality</div>
                </div>
                <h3>Formulir Pendaftaran</h3>
            </div>

            <div class="body-form">
                <div class="wrap">
                    <input type="text" id="nama" class="input" name="nama" required>
                    <label for="nama">Nama:</label>
                </div>
                <div class="wrap">
                    <input type="number" id="umur" class="input" name="umur" required>
                    <label for="umur">Umur:</label>
                </div>
                <div class="wrap">
                    <div class="custom-input">
                        <input type="number" id="kelas" class="input" name="kelas" required>
                        <div>
                            <div class="custom-wrap">
                                <input type="radio" id="SD" name="tingkat"  <?php echo ($id_paket == 'A'? 'checked': '')?> value="SD" required >
                                <label for="SD">SD</label>
                            </div>
                            <div class="custom-wrap">
                                <input type="radio" id="SMP" name="tingkat" <?php echo ($id_paket == 'B'? 'checked': '')?> value="SMP" required>
                                <label for="SMP">SMP</label>
                            </div>
                            <div class="custom-wrap">
                                <input type="radio" id="SMA" name="tingkat" <?php echo ($id_paket == 'C'? 'checked': '')?> value="SMA" required>
                                <label for="SMA">SMA</label>
                            </div>
                        </div>
                    </div>
                    <label for="kelas">Kelas:</label>
                </div>
                <div class="wrap">
                    <input type="text" id="asal_sekolah" class="input" name="asal_sekolah" required>
                    <label for="asal_sekolah">Asal Sekolah:</label>
                </div>
                <div class="wrap">
                    <input type="text" id="mapel_favorit" class="input" name="mapel_favorit" required>
                    <label for="mapel_favorit">Mapel Favorit:</label>
                </div>
                <div class="wrap">
                    <textarea class="input" rows="5" name="alamat" id="alamat" required></textarea>
                    <label for="alamat">Alamat:</label>
                </div>
                <div class="wrap">
                    <input type="text" id="nama_ortu" class="input" name="nama_ortu" required>
                    <label for="nama_ortu">Nama Orang Tua:</label>
                </div>
                <div class="wrap">
                    <input type="text" id="no_ortu" class="input" name="no_ortu" required>
                    <label for="no_ortu">No Telp Orang Tua:</label>
                </div>
                <div class="wrap">
                    <select name="id_paket" id="paket" class="input" required>
                        <option value=""></option>
                        <?php
                        $dataPaket = mysqli_query($connect,"SELECT * FROM paket_belajar");
                        while ($paket = mysqli_fetch_assoc($dataPaket)) {
                        ?>
                        <option value="<?= $paket['id_paket']?>" <?php echo ($id_paket == $paket['id_paket'] ? 'selected': '')?>><?= $paket['nama_paket']?></option>
                        <?php }?>
                    </select>
                    <label for="paket">Paket Yang Dipilih:</label>
                </div>
            </div>

            <center><button type="submit">Download</button></center>

            <hr>
            <ul>
                <li>Silakan cetak formulir ini kemudian bawa ke IQ Bimbel untuk melakukan registrasi ulang dan
                    pembayaran.</li>
                <li>Jika registrasi ulang dilakukan lebih dari 3 hari, harap isi ulang data diri anda.</li>
            </ul>

        </form>

    </div>
</body>

</html>