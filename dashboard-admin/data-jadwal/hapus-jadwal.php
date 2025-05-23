<?php
include '../../db.php';

if(!isset($_GET["id_jadwal"]) || empty($_GET["id_jadwal"])){
    die("Error: ID tidak ditemukan.");
}

$id_jadwal = $_GET["id_jadwal"];
$delete= "DELETE FROM jadwal WHERE id_jadwal=$id_jadwal";

if(mysqli_query($connect, $delete)){
    header('Location:  ../#jadwal');
} else {
    echo "Error: " . $delete . "<br>" . mysqli_error($connect);
}
?>