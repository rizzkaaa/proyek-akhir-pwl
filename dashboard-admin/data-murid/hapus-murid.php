<?php
include '../../db.php';

if(!isset($_GET["id_murid"]) || empty($_GET["id_murid"])){
    die("Error: ID tidak ditemukan.");
}

$id_murid = $_GET["id_murid"];
$delete= "DELETE FROM murid WHERE id_murid=$id_murid";

if(mysqli_query($connect, $delete)){
    header('Location:  ../#data-murid');
} else {
    echo "Error: " . $delete . "<br>" . mysqli_error($connect);
}
?>