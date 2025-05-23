<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../db.php';
session_start();

if (isset($_SESSION['peran']) && isset($_SESSION['id_key'])) {

    $role = $_SESSION['peran'];
    $id = $_SESSION['id_key'];
} else {
    header("Location: ../masuk/");
    exit;
}

$tabelPengajar = mysqli_query($connect, "SELECT * FROM pengajar WHERE id_key=$id");
$profilPengajar = mysqli_fetch_assoc($tabelPengajar);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="../asset/thumbnail.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajar Dashboard</title>
    <link rel="stylesheet" href="./header-admin.css">
    <link rel="stylesheet" href="./jadwal.css">
    <link rel="stylesheet" href="./pembayaran.css">
    <link rel="stylesheet" href="./users.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bona+Nova+SC:ital,wght@0,400;0,700;1,400&family=Tuffy:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <header>
        <div class="container">
            <div class="menu side">
                <img class="img-profil" src="../asset/pengajar/<?= $profilPengajar['profil'] ?>" alt="">
                <h3><?= $profilPengajar['nama_pengajar'] ?></h3>
                <p>Pengajar <br> +62 <?= $profilPengajar['no_telp'] ?></p>
                <button onclick="alertConfirm()">Keluar</button>
            </div>
            <div class="side">
                <div class="menu">
                    <div class="logo">
                        <a href="../"><img src="../asset/iq-bimbel.png" alt="IQ-Bimbel"></a>
                        <div class="judul">Insight & Quality</div>
                    </div>
                </div>
                <div class="wrap">
                    <a href="#" class="menu">
                        <div><i class="fa-regular fa-calendar-days"></i></div>
                        <p>Lorem ipsum</p>
                    </a>
                    <a href="#" class="menu">
                        <div><i class="fa-solid fa-server"></i></div>
                        <p>Lorem ipsum</p>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <script>
        function alertConfirm() {
            confirm("Anda yakin ingin keluar?") ? window.location.href = "../logout.php" : null;
        }
    </script>
</body>

</html>