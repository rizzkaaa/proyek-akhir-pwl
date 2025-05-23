<?php
include '../../db.php';

if(!isset($_GET["id_admin"]) || empty($_GET["id_admin"])){
    die("Error: ID tidak ditemukan.");
}

$id_admin = $_GET["id_admin"];
$delete= "DELETE FROM admin WHERE id_admin=$id_admin";

if(mysqli_query($connect, $delete)){
    header('Location:  ../#data-admin');
} else {
    echo "Error: " . $delete . "<br>" . mysqli_error($connect);
}
?>