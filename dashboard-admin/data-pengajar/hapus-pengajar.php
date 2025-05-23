<?php
include '../../db.php';

if(!isset($_GET["id_pengajar"]) || empty($_GET["id_pengajar"])){
    die("Error: ID tidak ditemukan.");
}

$id_pengajar = $_GET["id_pengajar"];
$delete= "DELETE FROM pengajar WHERE id_pengajar=$id_pengajar";

if(mysqli_query($connect, $delete)){
    header('Location:  ../#data-pengajar');
} else {
    echo "Error: " . $delete . "<br>" . mysqli_error($connect);
}
?>