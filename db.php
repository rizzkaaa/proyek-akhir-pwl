<?php
$server = 'localhost';
$usn = 'root';
$pw = '';
$dbname = 'db_bimbel';

$connect = mysqli_connect($server, $usn, $pw, $dbname);
if(!$connect){
    die("Koneksi gagal:" . mysqli_connect_error());
}
?>