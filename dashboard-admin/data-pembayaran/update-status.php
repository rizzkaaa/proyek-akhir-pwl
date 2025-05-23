<?php
include '../../db.php';

$date = date("Y-m-d");

if(isset($_GET['id_pembayaran'], $_GET['id_admin']) && !empty($_GET['id_pembayaran']) && !empty($_GET['id_admin'])){
    $id_pembayaran = $_GET['id_pembayaran'];
    $id_admin = $_GET['id_admin'];
    $data = mysqli_query($connect,"SELECT * FROM pembayaran_gaji WHERE id_pembayaran=$id_pembayaran");
    
    if($data && mysqli_num_rows($data) > 0){
        $row = mysqli_fetch_assoc($data);
        $status = $row['status'];
        if ($status == 'Proses'){
            $updateDataBayar = mysqli_query($connect, "UPDATE pembayaran_gaji SET id_admin = $id_admin, tgl_pembayaran = '$date', status = 'Selesai' WHERE id_pembayaran=$id_pembayaran");
            if($updateDataBayar){
                header("Location: ../#pembayaran");
                exit();
            }
        } else{
            $updateDataBayar = mysqli_query($connect, "UPDATE pembayaran_gaji SET id_admin = null, tgl_pembayaran = null, status = 'Proses' WHERE id_pembayaran=$id_pembayaran");
            if($updateDataBayar){
                header("Location: ../#pembayaran");
                exit();
            }
        }
    } else {
        echo "Data tidak ditemukan.";
    }
}
?>