<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include '../db.php';

$username = $_POST["username"];
$password = md5($_POST["password"]);
$captcha_input = $_POST["captcha"];
$captcha_session = $_SESSION["captcha"] ?? '';

if($captcha_input != $captcha_session){
    $_SESSION['error'] = "Captcha Salah!";
    header("Location: ./");
    exit;
}

$query = "SELECT * FROM `key` WHERE username = '$username' AND password = '$password'";
$result = mysqli_query($connect, $query);
$cek = mysqli_num_rows($result);

if($cek > 0){
    $data = mysqli_fetch_assoc($result);
    $_SESSION['peran'] = $data['peran'];
    $_SESSION['id_key'] = $data['id_key'];
    unset($_SESSION['captcha']);

    if($data['peran'] == "Admin"){
        header("location: ../dashboard-admin/");
    } elseif($data['peran'] == "Pengajar"){
        header("location: ../dashboard-pengajar/");
    }elseif($data['peran'] == "Murid"){
        header("location: ../dashboard-murid/");
    } else{
        echo "Peran tidak dikenali.";
    }
} else {
    header('Location:index.php?pesan=gagal');
}
?>