<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../../db.php';

$id_penerimaan = $_POST["id_dituju2"];

if(isset($_FILES['bukti_penerimaan']) && $_FILES['bukti_penerimaan']['error'] === UPLOAD_ERR_OK){
    $bukti_penerimaan = $_FILES['bukti_penerimaan'];
    $angka = rand(10, 99);
    $extention = array('png', 'jpg', 'jpeg', 'svg');
    $filename = $_FILES['bukti_penerimaan']['name'];
    $ukuran = $_FILES['bukti_penerimaan']['size'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if(!in_array($ext, $extention)){
        header('Location: ../?pesan=ekstensi_gagal#penerimaan');
    } else {
        if($ukuran < 1044070){
            $savebukti_penerimaan =  $filename . "_" . $angka;
            move_uploaded_file($_FILES['bukti_penerimaan']['tmp_name'], '../../asset/bukti_penerimaan_murid/' . $savebukti_penerimaan);
            
            $query = "UPDATE penerimaan_murid SET bukti_penerimaan = '$savebukti_penerimaan' WHERE id_penerimaan=$id_penerimaan";

            if(mysqli_query($connect, $query)){
                header("Location: ../#dari-murid");
                exit();
            }else{
                echo "Query gagal: " . mysqli_error($connect);
            }
        } else {
            header('Location: ../?alert=gagal_ukuran#dari-murid');
        }
    }
} else {
    header('Location: ../?alert=coba_lagi#dari-murid');
}


?>
