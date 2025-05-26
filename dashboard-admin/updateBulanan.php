<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// include "../db.php";
function updateData($connect)
{
    $dataBulanTahun = mysqli_query($connect, 'SELECT * FROM dataBulanTahun');
    $status = mysqli_fetch_assoc($dataBulanTahun);
    $bulanBerjalan = $status['bulan'];
    $tahunBerjalan = $status['tahun'];

    $bulan = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    ];

    $bulanBaru = $bulan[(date("m")) - 1];
    $tahunBaru = date("Y");

    if ($bulanBerjalan == $bulanBaru && $tahunBerjalan == $tahunBaru) {
        return;
    }

    // Pembayaran Gaji
    $dataGajiPengajar = mysqli_query($connect, "SELECT * FROM pengajar");
    while ($row = mysqli_fetch_assoc($dataGajiPengajar)) {
        $id_pengajar = $row['id_pengajar'];
        mysqli_query($connect, "INSERT INTO pembayaran_gaji (id_pengajar, bulan, tahun, jumlah_pembayaran, status) VALUES ($id_pengajar, '$bulanBaru', $tahunBaru, 0, 'Proses')");
    }

    $jamKerja = mysqli_query($connect, 'SELECT id_pengajar, COUNT(*) AS jumlah FROM jadwal GROUP BY id_pengajar;');
    while ($rowPengajar = mysqli_fetch_assoc($jamKerja)) {
        $totalGaji = $rowPengajar['jumlah'] * 150000;
        $id_pengajar = $rowPengajar['id_pengajar'];
        mysqli_query($connect, "UPDATE pembayaran_gaji SET jumlah_pembayaran=$totalGaji WHERE id_pengajar=$id_pengajar AND bulan = '$bulanBaru' AND tahun = $tahunBaru");
    }

    // Penerimaan Murid
    $dataTerimaMurid = mysqli_query($connect, "SELECT * FROM murid");
    while ($row = mysqli_fetch_assoc($dataTerimaMurid)) {
        $id_murid = $row['id_murid'];
        mysqli_query($connect, "INSERT INTO penerimaan_murid (id_murid, bulan, tahun, jumlah_penerimaan, status) VALUES ($id_murid, '$bulanBaru', $tahunBaru, 0, 'Proses')");
    }

    $hargaPaket = mysqli_query($connect, "SELECT a.id_murid, b.harga FROM `murid` a INNER JOIN paket_belajar b ON a.id_paket=b.id_paket");
    while ($rowMurid = mysqli_fetch_assoc($hargaPaket)) {
        $harga = $rowMurid['harga'];
        $id_murid = $rowMurid['id_murid'];
        mysqli_query($connect, "UPDATE penerimaan_murid SET jumlah_penerimaan=$harga WHERE id_murid=$id_murid AND bulan = '$bulanBaru' AND tahun = $tahunBaru");
    }

    // Nilai
    $jadwal = mysqli_query($connect, "SELECT id_kelas, id_mapel FROM jadwal");
    while ($rowJadwal = mysqli_fetch_assoc($jadwal)) {
        $murid = mysqli_query($connect, "SELECT id_murid FROM murid WHERE id_kelas='{$rowJadwal['id_kelas']}'");
        while ($rowMurid = mysqli_fetch_assoc($murid)) {
            $id_murid = $rowMurid['id_murid'];
            $id_mapel = $rowJadwal['id_mapel'];

            mysqli_query($connect, "INSERT INTO nilai (id_murid, id_mapel, bulan, tahun) 
                VALUES ($id_murid, '$id_mapel', '$bulanBaru', '$tahunBaru')");

        }
    }

    mysqli_query($connect, "UPDATE dataBulanTahun SET bulan = '$bulanBaru', tahun = $tahunBaru");
}

// $jadwal = mysqli_query($connect,"SELECT id_kelas, id_mapel FROM jadwal");
// while ($row = mysqli_fetch_assoc($jadwal)) {
//     $murid = mysqli_query($connect, "SELECT nama_murid FROM murid WHERE id_kelas='{$row['id_kelas']}'");
//     echo "<p>kelas: ".$row["id_kelas"]." mapel: ".$row["id_mapel"]."</p>";
//     echo "<ul>";
//     while($row1 = mysqli_fetch_assoc($murid)){
//         echo "<li>{$row1['nama_murid']}</li>";
//     }
//     echo "</ul>";
// }
?>