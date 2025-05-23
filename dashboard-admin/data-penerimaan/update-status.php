<?php
include '../../db.php';

$date = date("Y-m-d");

if(isset($_GET['id_penerimaan'], $_GET['id_admin']) && !empty($_GET['id_penerimaan']) && !empty($_GET['id_admin'])){
    $id_penerimaan = $_GET['id_penerimaan'];
    $id_admin = $_GET['id_admin'];
    $data = mysqli_query($connect,"SELECT * FROM penerimaan_murid WHERE id_penerimaan=$id_penerimaan");
    
    if($data && mysqli_num_rows($data) > 0){
        $row = mysqli_fetch_assoc($data);
        $status = $row['status'];
        if ($status == 'Proses'){
            $updateDataTerima = mysqli_query($connect, "UPDATE penerimaan_murid SET id_admin = $id_admin, tgl_penerimaan = '$date', status = 'Selesai' WHERE id_penerimaan=$id_penerimaan");
            if($updateDataTerima){
                header("Location: ../#dari-murid");
                exit();
            }
        } else{
            $updateDataTerima = mysqli_query($connect, "UPDATE penerimaan_murid SET id_admin = null, tgl_penerimaan = null, status = 'Proses' WHERE id_penerimaan=$id_penerimaan");
            if($updateDataTerima){
                header("Location: ../#dari-murid");
                exit();
            }
        }
    } else {
        echo "Data tidak ditemukan.";
    }
}
?>