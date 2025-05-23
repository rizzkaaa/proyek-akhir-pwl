<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../../db.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST["username"], $_POST['password'], $_POST['peran'])){
        $username = mysqli_real_escape_string($connect, $_POST['username']);
        $password_before = mysqli_real_escape_string($connect, $_POST['password']);
        $password_after = md5($password_before);
        $peran = mysqli_real_escape_string($connect, $_POST['peran']);

        $query = "INSERT INTO `key` (username, password, peran) VALUES ('$username', '$password_after', '$peran')";

        if(mysqli_query($connect, $query)){
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
    <title>Input Data User</title>
    <link rel="stylesheet" href="../tambah-data.css">
    <link rel="stylesheet" href="./jadwal.css">
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
                <h3>Input Data User</h3>
            </div>

            <div class="body-form">
                <div class="wrap">
                    <input type="text" maxlength="8" id="username" class="input" name="username" required>
                    <label for="username">Username:</label>
                </div>
                <div class="wrap">
                    <input type="text" maxlength="8"  oninput="this.value = this.value.replace(/[^0-9]/g, '')" id="password" class="input" name="password" required>
                    <label for="password">Password:</label>
                </div>
                
                <div class="wrap">
                    <select name="peran" id="peran" class="input" required>
                        <option value=""></option>
                        <option value="Admin">Admin</option>
                        <option value="Pengajar">Pengajar</option>
                        <option value="Murid">Murid</option>
                    </select>
                    <label for="peran">Peran:</label>
                </div>
            </div>

            <center><button type="submit">Tambah</button></center>
        </form>

    </div>
</body>
</html>