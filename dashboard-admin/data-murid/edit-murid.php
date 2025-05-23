<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../../db.php";

if (!isset($_GET["id_murid"]) || empty($_GET["id_murid"])) {
    die("Error: ID tidak ditemukan.");
}

$id_murid = mysqli_real_escape_string($connect, $_GET["id_murid"]);
$query = "SELECT * FROM murid WHERE id_murid = $id_murid";
$result = mysqli_query($connect, $query);

$row = mysqli_fetch_assoc($result);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Error: Data tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nama_murid'], $_POST['id_paket'], $_POST['id_kelas'], $_POST['umur'], $_POST['kelas'], $_POST['tingkat'], $_POST['asal_sekolah'], $_POST['mapel_favorit'], $_POST['alamat'], $_POST['nama_ortu'], $_POST['no_ortu'])) {
        $nama_murid = mysqli_real_escape_string($connect, ucwords(strtolower($_POST['nama_murid'])));
        $id_paket = mysqli_real_escape_string($connect, $_POST['id_paket']);
        $id_kelas = mysqli_real_escape_string($connect, $_POST['id_kelas']);
        $umur = mysqli_real_escape_string($connect, $_POST['umur']);
        $kelas = mysqli_real_escape_string($connect, $_POST['kelas']);
        $tingkat = mysqli_real_escape_string($connect, $_POST['tingkat']);
        $asal_sekolah = mysqli_real_escape_string($connect, strtoupper($_POST['asal_sekolah']));
        $mapel_favorit = mysqli_real_escape_string($connect, ucwords(strtolower($_POST['mapel_favorit'])));
        $alamat = mysqli_real_escape_string($connect, ucwords(strtolower($_POST['alamat'])));
        $nama_ortu = mysqli_real_escape_string($connect, ucwords(strtolower($_POST['nama_ortu'])));
        $no_ortu = mysqli_real_escape_string($connect, $_POST['no_ortu']);

        $query = "UPDATE murid SET 
        nama_murid='$nama_murid',
        id_paket='$id_paket',
        id_kelas='$id_kelas', 
        umur=$umur, 
        kelas='$kelas', 
        tingkat='$tingkat', 
        asal_sekolah='$asal_sekolah', 
        mapel_favorit='$mapel_favorit', 
        alamat='$alamat',  
        nama_ortu='$nama_ortu', 
        no_ortu='$no_ortu' 
        WHERE id_murid=$id_murid";

        if (isset($_POST["id_key"]) && !empty($_POST['id_key'])) {
            $id_key = mysqli_real_escape_string($connect, $_POST['id_key']);
            $query = "UPDATE murid SET 
            nama_murid='$nama_murid',
            id_paket='$id_paket',
            id_kelas='$id_kelas', 
            umur=$umur, 
            kelas='$kelas', 
            tingkat='$tingkat', 
            asal_sekolah='$asal_sekolah', 
            mapel_favorit='$mapel_favorit', 
            alamat='$alamat',  
            nama_ortu='$nama_ortu', 
            no_ortu='$no_ortu' ,
            id_key=$id_key 
            WHERE id_murid=$id_murid";
        }
        if (isset($_FILES['profil']) && $_FILES['profil']['error'] === UPLOAD_ERR_OK) {
            $profil = $_FILES['profil'];
            $angka = rand(10, 99);
            $extention = array('png', 'jpg', 'jpeg', 'svg');
            $filename = $_FILES['profil']['name'];
            $ukuran = $_FILES['profil']['size'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            if (!in_array($ext, $extention)) {
                header('Location: edit-murid.php?pesan=ekstensi_gagal');
            } else {
                if ($ukuran < 1044070) {
                    $saveProfil = $filename . "_" . $angka;
                    move_uploaded_file($_FILES['profil']['tmp_name'], '../../asset/murid/' . $saveProfil);

                    $query = "UPDATE murid SET 
                    nama_murid='$nama_murid',
                    id_paket='$id_paket',
                    id_kelas='$id_kelas', 
                    umur=$umur, 
                    kelas='$kelas', 
                    tingkat='$tingkat', 
                    asal_sekolah='$asal_sekolah', 
                    mapel_favorit='$mapel_favorit', 
                    alamat='$alamat',  
                    nama_ortu='$nama_ortu', 
                    no_ortu='$no_ortu', 
                    profil='$saveProfil' 
                    WHERE id_murid=$id_murid";

                    if (isset($_POST["id_key"]) && !empty($_POST['id_key'])) {
                        $id_key = mysqli_real_escape_string($connect, $_POST['id_key']);
                        $query = "UPDATE murid SET 
                        nama_murid='$nama_murid',
                        id_paket='$id_paket',
                        id_kelas='$id_kelas', 
                        umur=$umur, 
                        kelas='$kelas', 
                        tingkat='$tingkat', 
                        asal_sekolah='$asal_sekolah', 
                        mapel_favorit='$mapel_favorit', 
                        alamat='$alamat',  
                        nama_ortu='$nama_ortu', 
                        no_ortu='$no_ortu', 
                        profil='$saveProfil', 
                        id_key=$id_key 
                        WHERE id_murid=$id_murid";
                    }
                } else {
                    header('Location: index.php?alert=gagal_ukuran');
                }
            }
        }

        if (mysqli_query($connect, $query)) {
            header("Location: ../#data-murid");
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
    <link rel="icon" type="image/png" href="../../asset/thumbnail.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Murid</title>
    <link rel="stylesheet" href="../tambah-data.css">
    <link rel="stylesheet" href="./jadwal.css">
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
        <form method="POST" enctype="multipart/form-data">
            <div class="head-form">
                <div class="logo">
                    <a href="../"><img src="../../asset/iq-bimbel.png" alt="IQ-Bimbel"></a>
                    <div class="judul">Insight & Quality</div>
                </div>
                <h3>Edit Data Murid</h3>
            </div>

            <div class="body-form">
                <div class="wrap">
                    <input type="text" id="nama_murid" value="<?= $row['nama_murid']?>" class="input" name="nama_murid" required>
                    <label for="nama_murid">Nama Murid:</label>
                </div>
                <div class="wrap">
                    <select name="id_paket" id="id_paket" class="input" required>
                        <option value=""></option>
                        <?php
                        $dataPaket = mysqli_query($connect, "SELECT * FROM paket_belajar");
                        while ($paket = mysqli_fetch_assoc($dataPaket)) {
                            ?>
                            <option value="<?= $paket['id_paket'] ?>" <?= $row['id_paket'] == $paket['id_paket'] ? "selected" : ""?>> <?= $paket['nama_paket'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <label for="id_paket">Paket:</label>
                </div>
                <div class="wrap">
                    <select name="id_kelas" id="id_kelas" class="input" required>
                        <option value=""></option>
                        <?php
                        $dataKelas = mysqli_query($connect, "SELECT * FROM kelas");
                        while ($kelas = mysqli_fetch_assoc($dataKelas)) {
                            ?>
                            <option value="<?= $kelas['id_kelas'] ?>" <?= $row['id_kelas'] == $kelas['id_kelas'] ? "selected" : ""?>><?= $kelas['nama_kelas'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <label for="id_kelas">ID Kelas:</label>
                </div>
                <div class="wrap">
                    <input type="text" maxlength="3" value="<?= $row['umur']?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')" id="umur"
                        class="input" name="umur" required>
                    <label for="umur">Umur:</label>
                </div>
                <div class="wrap">
                    <div class="custom-input">
                        <input type="number" value="<?= $row['kelas']?>" id="kelas" class="input" name="kelas" required>
                        <div>
                            <div class="custom-wrap">
                                <input type="radio" id="SD" name="tingkat" <?= $row['tingkat'] == 'SD' ? "checked" : ""?> value="SD" required>
                                <label for="SD">SD</label>
                            </div>
                            <div class="custom-wrap">
                                <input type="radio" id="SMP" name="tingkat" <?= $row['tingkat'] == 'SMP' ? "checked" : ""?> value="SMP" required>
                                <label for="SMP">SMP</label>
                            </div>
                            <div class="custom-wrap">
                                <input type="radio" id="SMA" name="tingkat" <?= $row['tingkat'] == 'SMA' ? "checked" : ""?> value="SMA" required>
                                <label for="SMA">SMA</label>
                            </div>
                        </div>
                    </div>
                    <label for="kelas">Kelas:</label>
                </div>
                <div class="wrap">
                    <input type="text" value="<?= $row['asal_sekolah']?>" id="asal_sekolah" class="input" name="asal_sekolah" required>
                    <label for="asal_sekolah">Asal Sekolah:</label>
                </div>
                <div class="wrap">
                    <input type="text" id="mapel_favorit" value="<?= $row['mapel_favorit']?>" class="input" name="mapel_favorit" required>
                    <label for="mapel_favorit">Mapel Favorit Murid:</label>
                </div>
                <div class="wrap">
                    <textarea name="alamat" id="alamat" class="input" required><?= $row['alamat']?></textarea>
                    <label for="alamat">Alamat:</label>
                </div>
                <div class="wrap">
                    <input type="text" id="nama_ortu" value="<?= $row['nama_ortu']?>" class="input" name="nama_ortu" required>
                    <label for="nama_ortu">Nama Orang Tua:</label>
                </div>
                <div class="wrap">
                    <input type="text" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        id="no_ortu" value="<?= $row['no_ortu']?>" class="input" name="no_ortu" required>
                    <label for="no_ortu">No Orang Tua:</label>
                </div>
                <div class="wrap">
                    <input type="file" name="profil" id="profil" class="input">
                    <label for="profil">Foto Profil:</label>
                </div>
                <div class="wrap">
                    <input type="text" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        id="id_key" value="<?= $row['id_key']?>" class="input" name="id_key">
                    <label for="id_key">ID Key:</label>
                </div>
            </div>

            <center><button type="submit">Tambah</button></center>
        </form>
    </div>
</body>

</html>