<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../db.php';
session_start();

if (isset($_SESSION['peran']) && isset($_SESSION['id_key'])) {

    $role = $_SESSION['peran'];
    $id = $_SESSION['id_key'];
} else {
    header("Location: ../masuk/");
    exit;
}

$tabelPengajar = mysqli_query($connect, "SELECT * FROM pengajar WHERE id_key=$id");
$profilPengajar = mysqli_fetch_assoc($tabelPengajar);

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
$tahun = range(2015, 2025);

$status = mysqli_fetch_assoc(mysqli_query($connect, 'SELECT * FROM dataBulanTahun'));
$bulanBerjalan = $status['bulan'];
$tahunBerjalan = $status['tahun']

    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="../asset/thumbnail.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajar Dashboard</title>
    <link rel="stylesheet" href="./header-pengajar.css">
    <link rel="stylesheet" href="./jadwal.css">
    <link rel="stylesheet" href="./kelas.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bona+Nova+SC:ital,wght@0,400;0,700;1,400&family=Tuffy:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <header>
        <div class="container">
            <div class="menu side">
                <img class="img-profil" src="../asset/pengajar/<?= $profilPengajar['profil'] ?>" alt="">
                <h3><?= $profilPengajar['nama_pengajar'] ?></h3>
                <p>Pengajar - <?= $profilPengajar['id_pengajar'] ?></p>
                <button onclick="alertConfirm()">Keluar</button>
            </div>
            <div class="side">
                <div class="menu">
                    <div class="logo">
                        <a href="../"><img src="../asset/iq-bimbel.png" alt="IQ-Bimbel"></a>
                        <div class="judul">Insight & Quality</div>
                    </div>
                </div>
                <div class="wrap">
                    <a href="#jadwal" class="menu">
                        <div><i class="fa-regular fa-calendar-days"></i></div>
                        <p>Jadwal</p>
                    </a>
                    <a href="#kelasPilih" class="menu">
                        <div><i class="fa-solid fa-pen-nib"></i></div>
                        <p>Kelas</p>
                    </a>
                </div>
                <form class="wrap" id="kelasPilih" method="GET" action="#kelas">
                    <?php
                    $kelas = mysqli_query($connect, "SELECT id_kelas FROM jadwal WHERE id_pengajar = {$profilPengajar['id_pengajar']}");
                    while ($row = mysqli_fetch_assoc($kelas)) {
                        ?>
                        <label class="menu" for="<?= $row['id_kelas'] ?>">
                            <input type="radio" name="kelas" id="<?= $row['id_kelas'] ?>" value="<?= $row['id_kelas'] ?>"
                                onchange="document.getElementById('kelasPilih').submit();">
                            <i class="fa-solid fa-users"></i> <?= $row['id_kelas'] ?>
                            
                        </label>
                        <?php
                    }
                    ?>
                </form>
                
            </div>
        </div>
    </header>

    <section id="jadwal">
        <form class="menu filter" id="filterJadwal" method="GET">
            <div class="cari">
                <input type="search" name="cariJadwal"
                    value="<?= isset($_GET['cariJadwal']) ? $_GET['cariJadwal'] : '' ?>" placeholder="Cari...">
                <input type="submit" value="Cari">
            </div>
        </form>
        <table>
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Ruang</th>
            </tr>
            <?php
            $cariJadwal = isset($_GET['cariJadwal']) ? mysqli_real_escape_string($connect, $_GET['cariJadwal']) : '';
            $query = "SELECT a.*, b.mata_pelajaran FROM jadwal a INNER JOIN mapel b ON a.id_mapel=b.id_mapel WHERE id_pengajar = {$profilPengajar['id_pengajar']}";

            if (!empty($cariJadwal)) {
                $query .= " AND (hari LIKE '%$cariJadwal%' 
                        OR ruangan LIKE '%$cariJadwal%'
                        OR id_kelas LIKE '%$cariJadwal%'
                        OR mata_pelajaran LIKE '%$cariJadwal%')";
            }
            $jadwal = mysqli_query($connect, $query);
            if (mysqli_num_rows($jadwal) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_assoc($jadwal)) {
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $row['hari'] ?></td>
                        <td><?= $row['mata_pelajaran'] ?></td>
                        <td><?= $row['id_kelas'] ?></td>
                        <td><?= $row['ruangan'] ?></td>
                    </tr>
                    <?php
                    $no++;
                }
            }
            ?>
        </table>
    </section>

    <section id="kelas">
        <?php
        $id_kelasPilih = isset($_GET['kelas']) && !empty($_GET['kelas']) ? $_GET['kelas'] : '';
        $mapel = mysqli_fetch_assoc(mysqli_query($connect, "SELECT b.* FROM jadwal a INNER JOIN mapel b ON a.id_mapel=b.id_mapel WHERE id_pengajar = {$profilPengajar['id_pengajar']} AND id_kelas='$id_kelasPilih'"));
        $cariBulan = isset($_GET['bulan']) && !empty($_GET['bulan']) ? mysqli_real_escape_string($connect, $_GET['bulan']) : $bulanBerjalan;
        $cariTahun = isset($_GET['tahun']) && !empty($_GET['tahun']) ? mysqli_real_escape_string($connect, $_GET['tahun']) : $tahunBerjalan;
        $queryNilai = "SELECT a.*, b.nama_murid, b.id_kelas FROM nilai a INNER JOIN murid b ON a.id_murid=b.id_murid WHERE b.id_kelas='$id_kelasPilih' AND a.id_mapel='{$mapel["id_mapel"]}' AND a.bulan='$cariBulan' AND a.tahun='$cariTahun'";
        $cariNilai = isset($_GET['cariNilai']) && !empty($_GET['cariNilai']) ? mysqli_real_escape_string($connect, $_GET['cariNilai']) : '';

        if (!empty($cariNilai)) {
            $queryNilai .= " AND (a.id_murid LIKE '%$cariNilai%' 
                            OR nama_murid LIKE '%$cariNilai%'
                            OR latihan LIKE '%$cariNilai%'
                            OR tugas LIKE '%$cariNilai%'
                            OR quiz LIKE '%$cariNilai%'
                            OR ulangan LIKE '%$cariNilai%'
                            OR total_nilai LIKE '%$cariNilai%'
                            OR grade LIKE '%$cariNilai%')";
        }

        $nilai = mysqli_query($connect, $queryNilai);
        ?>

        <div class="head-kelas">
            <div class="wrap">
                <label>Kelas</label>
                <p><?= $id_kelasPilih ?></p>
            </div>
            <div class="wrap">
                <label>Mata Pelajaran</label>
                <p><?= $mapel['mata_pelajaran'] ?></p>
            </div>
            <div class="wrap">
                <label>Jumlah Peserta</label>
                <p><?= mysqli_num_rows($nilai) ?> Peserta</p>
            </div>
        </div>
        <div class="nilai">
            <form class="menu filter" id="filterDataTerima" method="GET">
                <input type="hidden" name="kelas" value="<?= $id_kelasPilih ?>">
                <div>
                    <span class="bulan">
                        <label for="bulan">Bulan: </label>
                        <select name="bulan" id="bulan"
                            onchange="document.getElementById('filterDataTerima').submit();">
                            <option value="">--</option>
                            <?php
                            foreach ($bulan as $nama_bulan) {
                                ?>
                                <option value="<?= $nama_bulan ?>" <?= (isset($_GET['bulan']) && $_GET['bulan'] == $nama_bulan) ? 'selected' : '' ?>>
                                    <?= $nama_bulan ?>
                                </option>
                            <?php } ?>
                        </select>
                    </span>
                    <span class="tahun">
                        <label for="tahun">Tahun: </label>
                        <select name="tahun" id="tahun"
                            onchange="document.getElementById('filterDataTerima').submit();">
                            <option value="">--</option>
                            <?php
                            foreach ($tahun as $tahun_pilih) {
                                ?>
                                <option value="<?= $tahun_pilih ?>" <?= (isset($_GET['tahun']) && $_GET['tahun'] == $tahun_pilih) ? 'selected' : '' ?>>
                                    <?= $tahun_pilih ?>
                                </option>
                            <?php } ?>
                        </select>
                    </span>
                </div>

                <div class="cari">
                    <input type="search" name="cariNilai"
                        value="<?= isset($_GET['cariNilai']) ? $_GET['cariNilai'] : '' ?>">
                    <input type="submit" value="Cari">
                </div>
            </form>

            <table>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">ID Murid</th>
                    <th rowspan="2">Nama Murid</th>
                    <th colspan="4">Penilaian</th>
                    <th rowspan="2">Total Nilai</th>
                    <th rowspan="2">Grade</th>
                </tr>
                <tr>
                    <th>Latihan</th>
                    <th>Tugas</th>
                    <th>Quiz</th>
                    <th>Ulangan</th>
                </tr>

                <?php


                $no = 1;
                while ($dataNilai = mysqli_fetch_assoc($nilai)) {
                    ?>
                    <tbody class="toggle-more-info">
                        <tr class="main-info">
                            <td rowspan="2"><?= $no ?></td>
                            <td><?= $dataNilai['id_murid'] ?></td>
                            <td><?= $dataNilai['nama_murid'] ?></td>
                            <td><?= $dataNilai['latihan'] ?></td>
                            <td><?= $dataNilai['tugas'] ?></td>
                            <td><?= $dataNilai['quiz'] ?></td>
                            <td><?= $dataNilai['ulangan'] ?></td>
                            <td><?= $dataNilai['total_nilai'] ?></td>
                            <td><?= $dataNilai['grade'] ?></td>
                        </tr>
                        <tr class="more-info">
                            <th colspan="2">Keterangan:</th>
                            <td colspan="4"><?= $dataNilai['keterangan'] ?></td>
                            <td colspan="2">
                                <a href="./data-nilai/edit-nilai.php?id_nilai=<?= $dataNilai['id_nilai'] ?>"
                                    class="button-aksi">Edit</a>
                                <span class="button-aksi"
                                    onclick="confirm('Yakin mau menghapus?') ? window.location.href = './data-nilai/hapus-nilai.php?id_nilai=<?= $dataNilai['id_nilai'] ?>' : null">Hapus</span>
                            </td>
                        </tr>
                    </tbody>
                    <?php
                    $no++;
                }
                ?>
            </table>

            <form action="./data-nilai/download.php" method="POST">
                <input type="hidden" name="kelas" value="<?= $id_kelasPilih ?>">
                <input type="hidden" name="mapel" value="<?= $mapel['id_mapel'] ?>">
                <input type="hidden" name="bulan" value="<?= $cariBulan ?>">
                <input type="hidden" name="tahun" value="<?= $cariTahun ?>">
                <center><button type="submit">Rekap Nilai</button></center>
            </form>
        </div>
    </section>
    <script>
        function alertConfirm() {
            confirm("Anda yakin ingin keluar?") ? window.location.href = "../logout.php" : null;
        }
    </script>
</body>

</html>