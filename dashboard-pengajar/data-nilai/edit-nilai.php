<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../../db.php";

if (!isset($_GET["id_nilai"]) || empty($_GET["id_nilai"])) {
    die("Error: ID tidak ditemukan.");
}

$id_nilai = mysqli_real_escape_string($connect, $_GET["id_nilai"]);
$dataNilai = mysqli_query($connect, "SELECT a.*, b.nama_murid, b.id_kelas, c.mata_pelajaran FROM nilai a INNER JOIN murid b ON a.id_murid=b.id_murid INNER JOIN mapel c ON a.id_mapel=c.id_mapel WHERE id_nilai = $id_nilai");
$rowNilai = mysqli_fetch_assoc($dataNilai);

if (!$rowNilai || mysqli_num_rows($dataNilai) == 0) {
    die("Error: Data tidak ditemukan.");
    ;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["latihan"]) || isset($_POST["tugas"]) || isset($_POST["quiz"]) || isset($_POST["ulangan"]) || isset($_POST["keterangan"])) {
        $latihan = !empty($_POST['latihan']) ? mysqli_real_escape_string($connect, $_POST["latihan"]) : 0;
        $tugas = !empty($_POST['tugas']) ? mysqli_real_escape_string($connect, $_POST["tugas"]) : 0;
        $quiz = !empty($_POST['quiz']) ? mysqli_real_escape_string($connect, $_POST["quiz"]) : 0;
        $ulangan = !empty($_POST['ulangan']) ? mysqli_real_escape_string($connect, $_POST["ulangan"]) : 0;
        $keterangan = !empty($_POST['keterangan']) ? mysqli_real_escape_string($connect, $_POST["keterangan"]) : NULL;

        $total_nilai = ($latihan + $tugas + $quiz + $ulangan) / 4;
        if ($total_nilai >= 80) {
            $grade = "A";
        } elseif ($total_nilai >= 60) {
            $grade = "B";
        } elseif ($total_nilai >= 40) {
            $grade = "C";
        } else {
            $grade = "D";
        }

        // $query = "UPDATE nilai SET latihan=$latihan, tugas=$tugas, quiz=$quiz, ulangan=$ulangan, total_nilai=$total_nilai, grade='$grade' WHERE id_nilai=$id_nilai";
        $query = "UPDATE nilai SET latihan=$latihan, tugas=$tugas, quiz=$quiz, ulangan=$ulangan, total_nilai=$total_nilai, grade='$grade', keterangan='$keterangan' WHERE id_nilai=$id_nilai";

    
        
        if (mysqli_query($connect, $query)) {
            header("Location: ../?kelas={$rowNilai['id_kelas']}#kelas");
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
    <title>Input Nilai</title>
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
                <h3>Input Nilai</h3>
            </div>

            <div class="body-form">
                <div class="wrap">
                    <div class="input-read"><?= $rowNilai['id_murid'] ?></div>
                    <label>ID Murid:</label>
                </div>
                <div class="wrap">
                    <div class="input-read"><?= $rowNilai['nama_murid'] ?></div>
                    <label>Nama Murid:</label>
                </div>
                <div class="wrap">
                    <div class="input-read"><?= $rowNilai['id_kelas'] ?></div>
                    <label>ID Kelas:</label>
                </div>
                <div class="wrap">
                    <div class="input-read"><?= $rowNilai['mata_pelajaran'] ?></div>
                    <label for="no_telp">Mata Pelajaran: </label>
                </div>
                <div class="wrap">
                    <input type="number" step="0.01" id="latihan" class="input" value="<?= $rowNilai['latihan'] ?>"
                        name="latihan">
                    <label for="latihan">Latihan:</label>
                </div>
                <div class="wrap">
                    <input type="number" step="0.01" id="tugas" class="input" value="<?= $rowNilai['tugas'] ?>"
                        name="tugas">
                    <label for="tugas">Tugas:</label>
                </div>
                <div class="wrap">
                    <input type="number" step="0.01" id="quiz" class="input" value="<?= $rowNilai['quiz'] ?>"
                        name="quiz">
                    <label for="quiz">Quiz:</label>
                </div>
                <div class="wrap">
                    <input type="number" step="0.01" id="ulangan" class="input" value="<?= $rowNilai['ulangan'] ?>"
                        name="ulangan">
                    <label for="ulangan">Ulangan:</label>
                </div>
                <div class="wrap">
                    <input type="text" id="keterangan" class="input" value="<?= $rowNilai['keterangan'] ?>"
                        name="keterangan">
                    <label for="keterangan">Keterangan:</label>
                </div>
            </div>

            <center><button type="submit">Tambah</button></center>
        </form>

    </div>
</body>

</html>