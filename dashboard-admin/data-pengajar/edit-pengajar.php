<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../../db.php";

if(!isset($_GET["id_pengajar"]) || empty($_GET["id_pengajar"])){
    die("Error: ID tidak ditemukan.");
}

$id_pengajar = mysqli_real_escape_string($connect, $_GET["id_pengajar"]);
$query = "SELECT * FROM pengajar WHERE id_pengajar = $id_pengajar";
$result = mysqli_query($connect, $query);

$row = mysqli_fetch_assoc($result);

if(!$result || mysqli_num_rows($result) == 0){
    die("Error: Data tidak ditemukan.");;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['nama_pengajar'], $_POST['umur'], $_POST['alamat'], $_POST['no_telp'])){
        $nama_pengajar = mysqli_real_escape_string($connect, $_POST['nama_pengajar']);
        $umur = mysqli_real_escape_string($connect, $_POST['umur']);
        $alamat = mysqli_real_escape_string($connect, $_POST['alamat']);
        $no_telp = mysqli_real_escape_string($connect, $_POST['no_telp']);
        
        $query = "UPDATE pengajar SET nama_pengajar='$nama_pengajar', umur=$umur, alamat='$alamat', no_telp='$no_telp' WHERE id_pengajar=$id_pengajar";
        
        if(isset($_POST["id_key"]) && !empty($_POST['id_key'])){
            $id_key = mysqli_real_escape_string($connect, $_POST['id_key']);
            $query = "UPDATE pengajar SET nama_pengajar='$nama_pengajar', umur=$umur, alamat='$alamat', no_telp='$no_telp', id_key=$id_key WHERE id_pengajar=$id_pengajar";
        }
        if(isset($_FILES['profil']) && $_FILES['profil']['error'] === UPLOAD_ERR_OK){
            $profil = $_FILES['profil'];
            $angka = rand(10, 99);
            $extention = array('png', 'jpg', 'jpeg', 'svg');
            $filename = $_FILES['profil']['name'];
            $ukuran = $_FILES['profil']['size'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            if(!in_array($ext, $extention)){
                header('Location: edit-pengajar.php?pesan=ekstensi_gagal');
            } else {
                if($ukuran < 1044070){
                    $saveProfil =  $filename . "_" . $angka;
                    move_uploaded_file($_FILES['profil']['tmp_name'], '../../asset/pengajar/' . $saveProfil);
                    
                    $query = "UPDATE pengajar SET nama_pengajar='$nama_pengajar', umur=$umur, alamat='$alamat', no_telp='$no_telp', profil='$saveProfil' WHERE id_pengajar=$id_pengajar";

                    if(isset($_POST["id_key"]) && !empty($_POST['id_key'])){
                        $id_key = mysqli_real_escape_string($connect, $_POST['id_key']);
                        $query = "UPDATE pengajar SET nama_pengajar='$nama_pengajar', umur=$umur, alamat='$alamat', no_telp='$no_telp', profil='$saveProfil', id_key=$id_key WHERE id_pengajar=$id_pengajar";
                    }
                } else {
                    header('Location: index.php?alert=gagal_ukuran');
                }
            }
        } 

        if(mysqli_query($connect, $query)){
            header("Location: ../#data-pengajar");
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
    <title>Edit Data pengajar</title>
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
                <h3>Edit Data pengajar</h3>
            </div>

            <div class="body-form">
                <div class="wrap">
                    <input type="text" id="nama_pengajar" value="<?= $row['nama_pengajar']?>" class="input" name="nama_pengajar" required>
                    <label for="nama_pengajar">Nama pengajar:</label>
                </div>
                <div class="wrap">
                    <input type="text" maxlength="3"  oninput="this.value = this.value.replace(/[^0-9]/g, '')" id="umur" value="<?= $row['umur']?>" class="input" name="umur" required>
                    <label for="umur">Umur:</label>
                </div>
                <div class="wrap">
                    <textarea name="alamat" id="alamat" class="input" required><?= $row['alamat']?></textarea>
                    <label for="alamat">Alamat:</label>
                </div>
                <div class="wrap">
                    <input type="text" maxlength="13"  oninput="this.value = this.value.replace(/[^0-9]/g, '')" id="no_telp" value="<?= $row['no_telp']?>" class="input" name="no_telp" required>
                    <label for="no_telp">No Telp:</label>
                </div>
                <div class="wrap">
                    <input type="file" name="profil" id="profil" value="<?= $row['profil']?>" class="input">
                    <label for="profil">Foto Profil:</label>
                </div>
                <div class="wrap">
                    <input type="text" maxlength="11"  oninput="this.value = this.value.replace(/[^0-9]/g, '')" id="id_key" value="<?= $row['id_key']?>" class="input" name="id_key">
                    <label for="id_key">ID Key:</label>
                </div>
            </div>

            <center><button type="submit">Edit</button></center>
        </form>

    </div>
</body>
</html>