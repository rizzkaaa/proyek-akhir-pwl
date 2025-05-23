<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "db.php";

$data = mysqli_query($connect, "SELECT * FROM data_pendaftar");

?>
<!DOCTYPE html>
<html>
<head>
  <title>RSA Encryption Demo</title>
</head>
<body>
    <table>
      <?php
        $exp = date("Y-m-d");
        echo $exp;
          while ($row = mysqli_fetch_assoc($data)){
            if($exp >= $row['tgl_exp']){
              echo $row['tgl_exp'] . " | ";

              // mysqli_query($connect, "DELETE FROM data_pendaftar WHERE tgl_exp = '$exp'");
              // continue;
            }
            ?>
          <tr>
        <td><?= $row['nama']?></td>
        <td><?= $row['tgl_exp']?></td>
        </tr>
        <?php
          }

          
          ?>

    </table>

    <?php
    $id_murid = mysqli_fetch_assoc(mysqli_query( $connect,"SELECT MAX(id_murid) as id FROM murid"))['id'];
$time = mysqli_fetch_assoc(mysqli_query( $connect,'SELECT * FROM dataBulanTahun'));
echo $time['bulan'].''.$time['tahun'].''.$id_murid;
    ?>
</body>
</html>
