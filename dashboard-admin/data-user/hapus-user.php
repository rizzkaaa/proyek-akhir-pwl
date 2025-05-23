<?php
include '../../db.php';

if(!isset($_GET["id_key"]) || empty($_GET["id_key"])){
    die("Error: ID tidak ditemukan.");
}

$id_key = $_GET["id_key"];
$delete= "DELETE FROM `key` WHERE id_key=$id_key";

if(mysqli_query($connect, $delete)){
    header('Location:  ../#data-users');
} else {
    echo "Error: " . $delete . "<br>" . mysqli_error($connect);
}
?>