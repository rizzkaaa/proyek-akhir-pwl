<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../../db.php";

if (!isset($_GET["id_nilai"]) || empty($_GET["id_nilai"])) {
    die("Error: ID tidak ditemukan.");
}

$id_nilai = $_GET["id_nilai"];
$dataNilai = mysqli_query($connect, "SELECT b.id_kelas FROM nilai a INNER JOIN murid b ON a.id_murid=b.id_murid WHERE id_nilai = $id_nilai");
$rowNilai = mysqli_fetch_assoc( $dataNilai);
$delete = "UPDATE nilai SET latihan=0, tugas=0, quiz=0, ulangan=0, total_nilai=0, grade='D', keterangan=NULL WHERE id_nilai=$id_nilai";

if (mysqli_query($connect, $delete)) {
    header("Location: ../?kelas={$rowNilai['id_kelas']}#kelas");
} else {
    echo "Error: " . $delete . "<br>" . mysqli_error($connect);
}
?>