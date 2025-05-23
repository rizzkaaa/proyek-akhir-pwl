<?php
$folder = '../../asset/bukti_penerimaan_murid';

if (is_writable($folder)) {
    echo "Folder bisa ditulis (OK)";
} else {
    echo "Folder TIDAK bisa ditulis (PERMISSION ERROR)";
}


$a = 1;
$b = 2;

if($a < $b) {
    echo $a;
}

if($a < $b) {
    echo $b;
}
?>