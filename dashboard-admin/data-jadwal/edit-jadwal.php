<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../../db.php";

if(!isset($_GET["id_jadwal"]) || empty($_GET["id_jadwal"])){
    die("Error: ID tidak ditemukan.");
}

$id_jadwal = mysqli_real_escape_string($connect, $_GET["id_jadwal"]);
$query = "SELECT * FROM jadwal WHERE id_jadwal = $id_jadwal";
$result = mysqli_query($connect, $query);

$row = mysqli_fetch_assoc($result);

if(!$result || mysqli_num_rows($result) == 0){
    die("Error: Data tidak ditemukan.");;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST["ruangan"], $_POST["hari"], $_POST['id_kelas'], $_POST['id_mapel'], $_POST['id_pengajar'])) {
        $ruangan = mysqli_real_escape_string($connect, $_POST['ruangan']);
        $hari = mysqli_real_escape_string($connect, $_POST['hari']);
        $id_kelas = mysqli_real_escape_string($connect, $_POST['id_kelas']);
        $id_mapel = mysqli_real_escape_string($connect, $_POST['id_mapel']);
        $id_pengajar = mysqli_real_escape_string($connect, $_POST['id_pengajar']);

        $updateQuery = "UPDATE jadwal SET id_kelas='$id_kelas', id_pengajar=$id_pengajar, id_mapel='$id_mapel', hari='$hari', ruangan='$ruangan'  WHERE id_jadwal=$id_jadwal";

        if(mysqli_query($connect, $updateQuery)){
            header("Location: ../#jadwal");
            exit();
        }else{
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
    <title>Edit Jadwal</title>
    <link rel="stylesheet" href="../tambah-data.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bona+Nova+SC:ital,wght@0,400;0,700;1,400&family=Tuffy:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .container{
            height: 640px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST">
            <div class="head-form">
                <div class="logo">
                    <a href="../"><img src="../../asset/iq-bimbel.png" alt="IQ-Bimbel"></a>
                    <div class="judul">Insight & Quality</div>
                </div>
                <h3>Edit Jadwal</h3>
            </div>

            <div class="body-form">
            <div class="wrap">
                    <select name="id_kelas" id="id_kelas" class="input" required>
                        <option value=""></option>
                        <?php
                        $dataKelas = mysqli_query($connect, "SELECT * FROM kelas");
                        while ($kelas = mysqli_fetch_assoc($dataKelas)) {
                            ?>
                            <option value="<?= $kelas['id_kelas'] ?>" <?= $row['id_kelas'] == $kelas['id_kelas'] ? 'selected' : '' ?>><?= $kelas['nama_kelas'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <label for="id_kelas">Kelas:</label>
                </div>
                <div class="wrap">
                    <select name="id_pengajar" id="id_pengajar" class="input" required>
                        <option value=""></option>
                        <?php
                        $dataPengajar = mysqli_query($connect, "SELECT * FROM pengajar");
                        while ($pengajar = mysqli_fetch_assoc($dataPengajar)) {
                            ?>
                            <option value="<?= $pengajar['id_pengajar'] ?>" <?= $row['id_pengajar'] == $pengajar['id_pengajar'] ? 'selected' : '' ?>><?= $pengajar['nama_pengajar'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <label for="id_pengajar">Nama Pengajar:</label>
                </div>
                <div class="wrap">
                    <select name="id_mapel" id="id_mapel" class="input" required>
                        <option value=""></option>
                        <?php
                        $dataMapel = mysqli_query($connect, "SELECT * FROM mapel");
                        while ($mapel = mysqli_fetch_assoc($dataMapel)) {
                            ?>
                            <option value="<?= $mapel['id_mapel'] ?>" <?= $row['id_mapel'] == $mapel['id_mapel'] ? 'selected' : '' ?>><?= $mapel['mata_pelajaran'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <label for="id_mapel">ID Mata Pelajaran:</label>
                </div>
                <div class="wrap">
                    <select name="hari" id="hari" class="input" required>
                        <option value=""></option>
                        </option>
                        <option value="Senin" <?= $row['hari'] == 'Senin' ? 'selected' : '' ?>>Senin
                    </option>
                    <option value="Selasa" <?= $row['hari'] == 'Selasa'? 'selected' : '' ?>>Selasa
                    </option>
                    <option value="Rabu" <?= $row['hari'] == 'Rabu'? 'selected' : '' ?>>Rabu</option>
                    <option value="Kamis" <?= $row['hari'] == 'Kamis' ? 'selected' : '' ?>>Kamis
                    </option>
                    <option value="Jumat" <?= $row['hari'] == 'Jumat' ? 'selected' : '' ?>>Jumat
                    </option>
                    <option value="Sabtu" <?= $row['hari'] == 'Sabtu' ? 'selected' : '' ?>>Sabtu
                    </option>
                    </select>
                    <label for="hari">Hari:</label>
                </div>
                <div class="wrap">
                    <select name="ruangan" id="ruangan" class="input" required>
                        <option value=""></option>
                        <option value="RK01" <?= $row['ruangan'] == 'RK01' ? 'selected' : '' ?>>RK01</option>
                        <option value="RK02" <?= $row['ruangan'] == 'RK02' ? 'selected' : '' ?>>RK02</option>
                        <option value="RK03" <?= $row['ruangan'] == 'RK03' ? 'selected' : '' ?>>RK03</option>
                        <option value="RK04" <?= $row['ruangan'] == 'RK04' ? 'selected' : '' ?>>RK04</option>
                        <option value="RK05" <?= $row['ruangan'] == 'RK05' ? 'selected' : '' ?>>RK05</option>
                        <option value="RK06" <?= $row['ruangan'] == 'RK06' ? 'selected' : '' ?>>RK06</option>
                    </select>
                    <label for="ruangan">Ruangan:</label>
                </div>
            </div>

            <center><button type="submit">Edit</button></center>
        </form>

    </div>
</body>
</html>