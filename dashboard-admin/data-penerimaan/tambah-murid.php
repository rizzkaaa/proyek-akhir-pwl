<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../../db.php";

$id_pendaftar = $_GET['id_pendaftar'];
$dataPendaftar = mysqli_query($connect, "SELECT * FROM data_pendaftar WHERE id_pendaftar = $id_pendaftar");
$row = mysqli_fetch_assoc($dataPendaftar);

$id_paket = $row['id_paket'];
echo $id_paket;
$nama = $row["nama"];
$umur = $row['umur'];
$kelas = $row['kelas'];
$tingkat = $row['tingkat'];
$asal_sekolah = $row['asal_sekolah'];
$mapel_favorit = $row['mapel_favorit'];
$alamat = $row['alamat'];
$nama_ortu = $row['nama_ortu'];
$no_ortu = $row['no_ortu'];
$profil = $row['profil'];

$insertMurid = mysqli_query($connect, "INSERT INTO murid(id_paket, nama_murid, umur, kelas, tingkat, asal_sekolah, mapel_favorit, alamat, nama_ortu, no_ortu, profil) VALUES ('$id_paket', '$nama', $umur, $kelas, '$tingkat', '$asal_sekolah', '$mapel_favorit', '$alamat', '$nama_ortu', $no_ortu, '$profil')");
$deleteQuery = mysqli_query($connect,"DELETE FROM data_pendaftar WHERE id_pendaftar = $id_pendaftar");

$id_murid = mysqli_fetch_assoc(mysqli_query( $connect,"SELECT MAX(id_murid) as id FROM murid"))['id'];
$time = mysqli_fetch_assoc(mysqli_query( $connect,'SELECT * FROM dataBulanTahun'));
$harga = mysqli_fetch_assoc(mysqli_query( $connect,"SELECT b.harga as harga FROM `murid` a INNER JOIN paket_belajar b ON a.id_paket=b.id_paket WHERE id_murid = $id_murid"))['harga'];
$insertTerima = mysqli_query($connect, "INSERT INTO penerimaan_murid (id_murid, bulan, tahun, jumlah_penerimaan, status) VALUES ($id_murid, '{$time['bulan']}', {$time['tahun']}, $harga, 'Proses')");


if($insertMurid){
    header('Location: ../#dari-pendaftar');
}
?>