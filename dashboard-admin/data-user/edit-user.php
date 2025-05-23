<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../../db.php";

if(!isset($_GET["id_key"]) || empty($_GET["id_key"])){
    die("Error: ID tidak ditemukan.");
}

$id_key = mysqli_real_escape_string($connect, $_GET["id_key"]);
$query = "SELECT * FROM `key` WHERE id_key = $id_key";
$result = mysqli_query($connect, $query);

$row = mysqli_fetch_assoc($result);

if(!$result || mysqli_num_rows($result) == 0){
    die("Error: Data tidak ditemukan.");;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST["username"], $_POST['peran'])){
        $username = mysqli_real_escape_string($connect, $_POST['username']);
        $peran = mysqli_real_escape_string($connect, $_POST['peran']);
        
        $updateQuery = "UPDATE `key` SET username='$username', peran='$peran' WHERE id_key=$id_key";

        if(isset($_POST["password"])){
            $password_before = mysqli_real_escape_string($connect, $_POST['password']);
            $password_after = md5($password_before);
            
            $updateQuery = "UPDATE `key` SET username='$username', password='$password_after', peran='$peran' WHERE id_key=$id_key";
        }

        if(mysqli_query($connect, $updateQuery)){
            header("Location: ../#data-users");
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
    <title>Edit Data User</title>
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
                <h3>Edit Data User</h3>
            </div>

            <div class="body-form">
                <div class="wrap">
                    <input type="text" value="<?= htmlspecialchars($row['username'])?>"  maxlength="8" id="username" class="input" name="username" required>
                    <label for="username">Username:</label>
                </div>
                <div class="wrap">
                    <input type="text" maxlength="8"  oninput="this.value = this.value.replace(/[^0-9]/g, '')" id="password" class="input" name="password">
                    <label for="password">Password:</label>
                </div>
                
                <div class="wrap">
                    <select name="peran" id="peran" class="input" required>
                        <option value="Admin" <?= $row['peran'] == 'Admin' ? 'selected': ''?>>Admin</option>
                        <option value="Pengajar" <?= $row['peran'] == 'Pengajar' ? 'selected': ''?>>Pengajar</option>
                        <option value="Murid" <?= $row['peran'] == 'Murid' ? 'selected': ''?>>Murid</option>
                    </select>
                    <label for="peran">Peran:</label>
                </div>
            </div>

            <center><button type="submit">Tambah</button></center>
        </form>

    </div>
</body>
</html>