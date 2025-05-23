<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../../db.php';

$id_pembayaran = $_POST["id_dituju1"];

if(isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] === UPLOAD_ERR_OK){
    $bukti_pembayaran = $_FILES['bukti_pembayaran'];
    $angka = rand(10, 99);
    $extention = array('png', 'jpg', 'jpeg', 'svg');
    $filename = $_FILES['bukti_pembayaran']['name'];
    $ukuran = $_FILES['bukti_pembayaran']['size'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if(!in_array($ext, $extention)){
        header('Location: ../?pesan=ekstensi_gagal#pembayaran');
    } else {
        if($ukuran < 1044070){
            $savebukti_pembayaran =  $filename . "_" . $angka;
            move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], '../../asset/bukti_pembayaran_gaji/' . $savebukti_pembayaran);
            
            $query = "UPDATE pembayaran_gaji SET bukti_pembayaran = '$savebukti_pembayaran' WHERE id_pembayaran=$id_pembayaran";

            if(mysqli_query($connect, $query)){
                header("Location: ../#pembayaran");
                exit();
            }else{
                echo "Query gagal: " . mysqli_error($connect);
            }
        } else {
            header('Location: ../?alert=gagal_ukuran#pembayaran');
        }
    }
} else {
    header('Location: ../?alert=coba_lagi#pembayaran');
}


?>
