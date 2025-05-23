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

$tabelAdmin = mysqli_query($connect, "SELECT * FROM admin WHERE id_key=$id");
$profilAdmin = mysqli_fetch_assoc($tabelAdmin);

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
$tahun = range(2015, 2025);

$bulanBaru = $bulan[(date("m")) - 1];
$tahunBaru = date("Y");

if ($bulanBerjalan != $bulanBaru || $tahunBerjalan != $tahunBaru) {
    $dataGajiPengajar = mysqli_query($connect, "SELECT * FROM pengajar");
    $dataTerimaMurid = mysqli_query($connect, "SELECT * FROM murid");

    while ($row = mysqli_fetch_assoc($dataGajiPengajar)) {
        $id_pengajar = $row['id_pengajar'];
        $dataGaji = mysqli_query($connect, "INSERT INTO pembayaran_gaji (id_pengajar, bulan, tahun, jumlah_pembayaran, status) VALUES ($id_pengajar, '$bulanBaru', $tahunBaru, 0, 'Proses')");
    }

    $jamKerja = mysqli_query($connect, 'SELECT id_pengajar, COUNT(*) AS jumlah FROM jadwal GROUP BY id_pengajar;');
    while ($rowPengajar = mysqli_fetch_assoc($jamKerja)) {
        $totalGaji = $rowPengajar['jumlah'] * 150000;
        $id_pengajar = $rowPengajar['id_pengajar'];
        $updateGaji = mysqli_query($connect, "UPDATE pembayaran_gaji SET jumlah_pembayaran=$totalGaji WHERE id_pengajar=$id_pengajar AND bulan = '$bulanBaru' AND tahun = $tahunBaru");
    }

    while ($row = mysqli_fetch_assoc($dataTerimaMurid)) {
        $id_murid = $row['id_murid'];
        $dataTerima = mysqli_query($connect, "INSERT INTO penerimaan_murid (id_murid, bulan, tahun, jumlah_penerimaan, status) VALUES ($id_murid, '$bulanBaru', $tahunBaru, 0, 'Proses')");
    }

    $hargaPaket = mysqli_query($connect, "SELECT a.id_murid, b.harga FROM `murid` a INNER JOIN paket_belajar b ON a.id_paket=b.id_paket");
    while ($rowMurid = mysqli_fetch_assoc($hargaPaket)) {
        $harga = $rowMurid['harga'];
        $id_murid = $rowMurid['id_murid'];
        $updateTerima = mysqli_query($connect, "UPDATE penerimaan_murid SET jumlah_penerimaan=$harga WHERE id_murid=$id_murid AND bulan = '$bulanBaru' AND tahun = $tahunBaru");
    }
    mysqli_query($connect, "UPDATE dataBulanTahun SET bulan = '$bulanBaru', tahun = $tahunBaru");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="../asset/thumbnail.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./header-admin.css">
    <link rel="stylesheet" href="./jadwal.css">
    <link rel="stylesheet" href="./pembayaran.css">
    <link rel="stylesheet" href="./users.css">
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
                <img class="img-profil" src="../asset/admin/<?= $profilAdmin['profil'] ?>" alt="">
                <h3><?= $profilAdmin['nama_admin'] ?></h3>
                <p><?= $profilAdmin['posisi'] ?> <br> +62 <?= $profilAdmin['no_telp'] ?></p>
                <button onclick="alertConfirm()">Keluar</button>
            </div>
            <div class="side <?= $profilAdmin['posisi'] == 'Admin Keuangan' ? 'notShow' : '' ?> ">
                <div class="menu">
                    <div class="logo">
                        <a href="../"><img src="../asset/iq-bimbel.png" alt="IQ-Bimbel"></a>
                        <div class="judul">Insight & Quality</div>
                    </div>
                </div>
                <div class="wrap">
                    <a href="#jadwal" class="menu">
                        <div><i class="fa-regular fa-calendar-days"></i></div>
                        <p>Atur Jadwal</p>
                    </a>
                    <a href="#datas" class="menu">
                        <div><i class="fa-solid fa-server"></i></div>
                        <p>Edit Data</p>
                    </a>
                </div>
                <div class="wrap datas" id="datas">
                    <a href="#data-users" class="menu">
                        <p>Data User<i class="fa-solid fa-key"></i></p>
                    </a>
                    <a href="#data-admin" class="menu">
                        <p>Data Admin<i class="fa-solid fa-unlock"></i></p>
                    </a>
                    <a href="#data-murid" class="menu">
                        <p>Data Murid<i class="fa-solid fa-graduation-cap"></i></p>
                    </a>
                    <a href="#data-pengajar" class="menu">
                        <p>Data Pengajar<i class="fa-solid fa-school"></i></p>
                    </a>
                </div>
            </div>
            <div class="side <?= $profilAdmin['posisi'] == 'Admin Operasional' ? 'notShow' : '' ?> ">
                <div class="menu">
                    <div class="logo">
                        <a href="../"><img src="../asset/iq-bimbel.png" alt="IQ-Bimbel"></a>
                        <div class="judul">Insight & Quality</div>
                    </div>
                </div>
                <div class="wrap">
                    <a href="#pembayaran" class="menu">
                        <div><i class="fa-solid fa-money-bill"></i></div>
                        <p>Pembayaran</p>
                    </a>
                    <a href="#penerimaan" class="menu">
                        <div><i class="fa-solid fa-receipt"></i></div>
                        <p>Penerimaan</p>
                    </a>
                </div>
                <div class="wrap datas" id="penerimaan">
                    <a href="#dari-pendaftar" class="menu">
                        <p>Pendaftar<i class="fa-solid fa-users"></i></p>
                    </a>
                    <a href="#dari-murid" class="menu">
                        <p>Murid<i class="fa-solid fa-graduation-cap"></i></p>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <section id="jadwal">
        <form class="menu filter" id="filterJadwal" method="GET">
            <div class="hari">
                <label for="hari">Hari: </label>
                <?php
                $today = date("l");

                $translate = [
                    'Monday' => 'Senin',
                    'Tuesday' => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday' => 'Kamis',
                    'Friday' => 'Jumat',
                    'Saturday' => 'Sabtu'
                ];

                $hariIni = $translate[$today];
                ?>

                <select name="hari" id="hari" onchange="document.getElementById('filterJadwal').submit();">
                    <option value="">--</option>
                    <?php
                    foreach ($translate as $key => $value) {
                        ?>
                    <option value="<?= $value ?>" <?= isset($_GET['hari']) && $_GET['hari'] == $value || $hariIni == $value ? 'selected' : '' ?>><?= $value ?></option>
                    <?php } ?>

                </select>
            </div>
            <div class="cari">
                <input type="search" name="cariJadwal"
                    value="<?= isset($_GET['cariJadwal']) ? $_GET['cariJadwal'] : '' ?>" placeholder="Cari ruangan, nama kelas, mata pelajarn dan nama pengajar">
                <input type="submit" value="Cari">
            </div>
        </form>

        <table>
            <tr>
                <th>No</th>
                <th>Ruangan</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Pengajar</th>
                <th>Aksi</th>
            </tr>
            <?php
            $cariJadwal = isset($_GET['cariJadwal']) ? mysqli_real_escape_string($connect, $_GET['cariJadwal']) : '';
            $hari = isset($_GET['hari']) ? mysqli_real_escape_string($connect, $_GET['hari']) : $hariIni;

            $query = "SELECT * FROM jadwal a
                    LEFT JOIN kelas b ON a.id_kelas = b.id_kelas
                    LEFT JOIN mapel c ON a.id_mapel = c.id_mapel
                    LEFT JOIN pengajar d ON a.id_pengajar = d.id_pengajar
                    WHERE 1";

            if (!empty($cariJadwal)) {
                $query .= " AND (ruangan LIKE '%$cariJadwal%' 
                        OR nama_kelas LIKE '%$cariJadwal%' 
                        OR mata_pelajaran LIKE '%$cariJadwal%' 
                        OR nama_pengajar LIKE '%$cariJadwal%')";
            }

            if (!empty($hari)) {
                $query .= " AND a.hari = '$hari'";
            }
            $query .= " ORDER BY a.ruangan";

            $tabelJadwal = mysqli_query($connect, $query);
            $no = 1;
            while ($dataJadwal = mysqli_fetch_assoc($tabelJadwal)) {
                ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= $dataJadwal['ruangan'] ?></td>
                    <td><?= $dataJadwal['nama_kelas'] ?></td>
                    <td><?= $dataJadwal['mata_pelajaran'] ?></td>
                    <td><?= $dataJadwal['nama_pengajar'] ?></td>
                    <td><a class="button-aksi"
                            href="./data-jadwal/edit-jadwal.php?id_jadwal=<?= $dataJadwal['id_jadwal'] ?> "
                            class="button-aksi">Edit</a>
                        <span class="button-aksi"
                            onclick="confirm('Yakin mau menghapus?') ? window.location.href = './data-jadwal/hapus-jadwal.php?id_jadwal=<?= $dataJadwal['id_jadwal'] ?>' : null">Hapus</span>
                    </td>
                </tr>
                <?php
                $no++;
            }
            ?>
        </table>
        <button><a href="./data-jadwal/tambah-jadwal.php">Tambah</a></button>
    </section>

    <section id="data-users">
        <form class="menu filter" id="filterDataUsers" method="GET">
            <div class="peran">
                <label for="peran">Peran: </label>
                <select name="peran" id="peran" onchange="document.getElementById('filterDataUsers').submit();">
                    <option value="">--</option>
                    <option value="Admin" <?= isset($_GET['peran']) && $_GET['peran'] == 'Admin' ? 'selected' : '' ?>>Admin
                    </option>
                    <option value="Pengajar" <?= isset($_GET['peran']) && $_GET['peran'] == 'Pengajar' ? 'selected' : '' ?>>Pengajar
                    </option>
                    <option value="Murid" <?= isset($_GET['peran']) && $_GET['peran'] == 'Murid' ? 'selected' : '' ?>>Murid</option>
                </select>
            </div>
            <div class="cari">
                <input type="search" name="cariDataUsers"
                    value="<?= isset($_GET['cariDataUsers']) ? $_GET['cariDataUsers'] : '' ?>" placeholder="Cari nama user dan username">
                <input type="submit" value="Cari">
            </div>
        </form>

        <table>
            <tr>
                <th>No</th>
                <th>Nama Pengguna</th>
                <th>Username</th>
                <th>Peran</th>
                <th>Aksi</th>
            </tr>
            <?php
            $cariDataUsers = isset($_GET['cariDataUsers']) ? mysqli_real_escape_string($connect, $_GET['cariDataUsers']) : '';
            $peran = isset($_GET['peran']) ? mysqli_real_escape_string($connect, $_GET['peran']) : '';

            $query = "SELECT a.*, b.nama_murid, c.nama_pengajar, d.nama_admin FROM `key` a
                    LEFT JOIN murid b ON a.id_key = b.id_key
                    LEFT JOIN pengajar c ON a.id_key = c.id_key
                    LEFT JOIN admin d ON a.id_key = d.id_key
                    WHERE 1";

            if (!empty($cariDataUsers)) {
                $query .= " AND (nama_murid LIKE '%$cariDataUsers%' 
                        OR nama_admin LIKE '%$cariDataUsers%'
                        OR nama_pengajar LIKE '%$cariDataUsers%'
                        OR username LIKE '%$cariDataUsers%')";
            }

            if (!empty($peran)) {
                $query .= " AND a.peran = '$peran'";
            }

            $tabelUsers = mysqli_query($connect, $query);
            $no = 1;
            while ($dataUsers = mysqli_fetch_assoc($tabelUsers)) {
                ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= $dataUsers['nama_murid'] ?? $dataUsers['nama_pengajar'] ?? $dataUsers['nama_admin'] ?></td>
                    <td><?= $dataUsers['username'] ?></td>
                    <td><?= $dataUsers['peran'] ?></td>
                    <td><a href="./data-user/edit-user.php?id_key=<?= $dataUsers['id_key'] ?> " class="button-aksi">Edit</a>
                        <span class="button-aksi"
                            onclick="confirm('Yakin mau menghapus?') ? window.location.href = './data-user/hapus-user.php?id_key=<?= $dataUsers['id_key'] ?>' : null">Hapus</span>
                    </td>

                </tr>
                <?php
                $no++;
            }
            ?>
        </table>

        <button><a href="./data-user/tambah-user.php">Tambah User</a></button>
    </section>

    <section id="data-admin">
        <form class="menu filter" id="filterDataAdmin" method="GET">
            <div class="cari">
                <input type="search" name="cariDataAdmin"
                    value="<?= isset($_GET['cariDataAdmin']) ? $_GET['cariDataAdmin'] : '' ?>" placeholder="Cari admin">
                <input type="submit" value="Cari">
            </div>
        </form>

        <table>
            <tr>
                <th>No</th>
                <th>Profil</th>
                <th>ID Admin</th>
                <th>Nama Admin</th>
                <th>Posisi</th>
                <th>ID User</th>
            </tr>
            <?php
            $cariDataAdmin = isset($_GET['cariDataAdmin']) ? mysqli_real_escape_string($connect, $_GET['cariDataAdmin']) : '';

            $query = "SELECT * FROM admin WHERE 1";

            if (!empty($cariDataAdmin)) {
                $query .= " AND (id_admin LIKE '%$cariDataAdmin%' 
                        OR nama_admin LIKE '%$cariDataAdmin%'
                        OR umur LIKE '%$cariDataAdmin%'
                        OR alamat LIKE '%$cariDataAdmin%'
                        OR no_telp LIKE '%$cariDataAdmin%'
                        OR posisi LIKE '%$cariDataAdmin%'
                        OR id_key LIKE '%$cariDataAdmin%')";
            }

            $tabelAdmin = mysqli_query($connect, $query);
            $no = 1;
            while ($dataAdmin = mysqli_fetch_assoc($tabelAdmin)) {
                ?>
                <tbody class="toggle-more-info">
                    <tr class="main-info">
                        <td rowspan="4"><?= $no ?></td>
                        <td>
                            <?php
                            if (!empty($dataAdmin['profil'])) { ?>
                                <img src="../asset/admin/<?= $dataAdmin['profil'] ?>" alt="admin">
                                <?php
                            } else { ?>
                                <img src="../asset/default.jpeg" alt="default">
                            <?php }
                            ?>
                        </td>
                        <td><?= $dataAdmin['id_admin'] ?></td>
                        <td><?= $dataAdmin['nama_admin'] ?></td>
                        <td><?= $dataAdmin['posisi'] ?></td>
                        <td><?= $dataAdmin['id_key'] ?></td>
                    </tr>
                    <tr class="more-info">
                        <th colspan="2">Umur</th>
                        <td><?= $dataAdmin['umur'] ?></td>
                        <td colspan="2" rowspan="3">
                            <a href="./data-admin/edit-admin.php?id_admin=<?= $dataAdmin['id_admin'] ?> "
                                class="button-aksi">Edit</a>
                            <span class="button-aksi"
                                onclick="confirm('Yakin mau menghapus?') ? window.location.href = './data-admin/hapus-admin.php?id_admin=<?= $dataAdmin['id_admin'] ?>' : null">Hapus</span>
                        </td>
                    </tr>
                    <tr class="more-info">
                        <th colspan="2">Alamat</th>
                        <td><?= $dataAdmin['alamat'] ?></td>
                    </tr>
                    <tr class="more-info">
                        <th colspan="2">No Telp</th>
                        <td><?= $dataAdmin['no_telp'] ?></td>
                    </tr>
                </tbody>
                <?php
                $no++;
            }
            ?>
        </table>

        <button><a href="./data-admin/tambah-admin.php">Tambah Admin</a></button>
    </section>

    <section id="data-murid">
        <form class="menu filter" id="filterDataMurid" method="GET">
            <div class="kelas">
                <label for="kelas">kelas: </label>
                <select name="kelas" id="kelas" onchange="document.getElementById('filterDataMurid').submit();">
                    <option value="">--</option>
                    <?php
                    $dataKelas = mysqli_query($connect, 'SELECT * FROM kelas');
                    while ($kelas = mysqli_fetch_assoc($dataKelas)) {
                        ?>
                        <option value="<?= $kelas['id_kelas'] ?>" <?= isset($_GET['kelas']) && $_GET['kelas'] == $kelas['id_kelas'] ? 'selected' : '' ?>><?= $kelas['nama_kelas'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="cari">
                <input type="search" name="cariDataMurid"
                    value="<?= isset($_GET['cariDataMurid']) ? $_GET['cariDataMurid'] : '' ?>" placeholder="Cari murid">
                <input type="submit" value="Cari">
            </div>
        </form>

        <table>
            <tr>
                <th>No</th>
                <th>Profil</th>
                <th>ID Murid</th>
                <th>Nama Murid</th>
                <th>ID Kelas</th>
                <th>Paket</th>
                <th>ID User</th>
            </tr>
            <?php
            $cariDataMurid = isset($_GET['cariDataMurid']) ? mysqli_real_escape_string($connect, $_GET['cariDataMurid']) : '';
            $kelas = isset($_GET['kelas']) ? mysqli_real_escape_string($connect, $_GET['kelas']) : '';

            $query = "SELECT a.*, b.nama_paket FROM murid a 
                        LEFT JOIN paket_belajar b 
                        ON a.id_paket=b.id_paket
                        WHERE 1";

            if (!empty($cariDataMurid)) {
                $query .= " AND (id_murid LIKE '%$cariDataMurid%' 
                        OR nama_murid LIKE '%$cariDataMurid%'
                        OR id_kelas LIKE '%$cariDataMurid%'
                        OR a.id_paket LIKE '%$cariDataMurid%'
                        OR nama_paket LIKE '%$cariDataMurid%'
                        OR umur LIKE '%$cariDataMurid%'
                        OR alamat LIKE '%$cariDataMurid%'
                        OR asal_sekolah LIKE '%$cariDataMurid%'
                        OR nama_ortu LIKE '%$cariDataMurid%'
                        OR no_ortu LIKE '%$cariDataMurid%'
                        OR id_key LIKE '%$cariDataMurid%')";
            }

            if (!empty($kelas)) {
                $query .= " AND a.id_kelas = '$kelas'";
            }

            $tabelMurid = mysqli_query($connect, $query);
            $no = 1;
            while ($dataMurid = mysqli_fetch_assoc($tabelMurid)) {
                ?>
                <tbody class="toggle-more-info">
                    <tr class="main-info">
                        <td rowspan="8"><?= $no ?></td>
                        <td>
                            <?php
                            if (!empty($dataMurid['profil'])) { ?>
                                <img src="../asset/murid/<?= $dataMurid['profil'] ?>" alt="murid">
                                <?php
                            } else { ?>
                                <img src="../asset/default.jpeg" alt="default">
                            <?php }
                            ?>
                        </td>
                        <td><?= $dataMurid['id_murid'] ?></td>
                        <td><?= $dataMurid['nama_murid'] ?></td>
                        <td><?= $dataMurid['id_kelas'] ?></td>
                        <td><?= $dataMurid['nama_paket'] ?></td>
                        <td><?= $dataMurid['id_key'] ?></td>
                    </tr>
                    <tr class="more-info">
                        <th colspan="2">Umur</th>
                        <td colspan="2"><?= $dataMurid['umur'] ?></td>
                        <td rowspan="7" colspan="2">
                            <a href="./data-murid/edit-murid.php?id_murid=<?= $dataMurid['id_murid'] ?> "
                                class="button-aksi">Edit</a>
                            <span class="button-aksi"
                                onclick="confirm('Yakin mau menghapus?') ? window.location.href = './data-murid/hapus-murid.php?id_murid=<?= $dataMurid['id_murid'] ?>' : null">Hapus</span>
                        </td>
                    </tr>
                    <tr class="more-info">
                        <th colspan="2">Kelas</th>
                        <td colspan="2"><?= $dataMurid['kelas'] . " " . $dataMurid['tingkat'] ?></td>
                    </tr>
                    <tr class="more-info">
                        <th colspan="2">Asal Sekolah</th>
                        <td colspan="2"><?= $dataMurid['asal_sekolah'] ?></td>
                    </tr>
                    <tr class="more-info">
                        <th colspan="2">Mapel Favorit</th>
                        <td colspan="2"><?= $dataMurid['mapel_favorit'] ?></td>
                    </tr>

                    <tr class="more-info">
                        <th colspan="2">Alamat</th>
                        <td colspan="2"><?= $dataMurid['alamat'] ?></td>
                    </tr>
                    <tr class="more-info">
                        <th colspan="2">Nama Orang Tua</th>
                        <td colspan="2"><?= $dataMurid['nama_ortu'] ?></td>
                    </tr>

                    <tr class="more-info">
                        <th colspan="2">No Orang Tua</th>
                        <td colspan="2"><?= $dataMurid['no_ortu'] ?></td>
                    </tr>
                </tbody>
                <?php
                $no++;
            }
            ?>
        </table>
    </section>

    <section id="data-pengajar">
        <form class="menu filter" id="filterDataPengajar" method="GET">
            <div class="cari">
                <input type="search" name="cariDataPengajar"
                    value="<?= isset($_GET['cariDataPengajar']) ? $_GET['cariDataPengajar'] : '' ?>" placeholder="Cari pengajar">
                <input type="submit" value="Cari">
            </div>
        </form>

        <table>
            <tr>
                <th>No</th>
                <th>Profil</th>
                <th>ID Pengajar</th>
                <th>Nama Pengajar</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>ID User</th>
            </tr>
            <?php
            $cariDataPengajar = isset($_GET['cariDataPengajar']) ? mysqli_real_escape_string($connect, $_GET['cariDataPengajar']) : '';

            $query = "SELECT 
                        b.*, 
                        GROUP_CONCAT(DISTINCT c.nama_kelas ORDER BY c.nama_kelas SEPARATOR ', ') AS kelas,
                        GROUP_CONCAT(DISTINCT d.mata_pelajaran ORDER BY d.mata_pelajaran SEPARATOR ', ') AS mapel
                        FROM pengajar b 
                        LEFT JOIN jadwal a ON b.id_pengajar = a.id_pengajar 
                        LEFT JOIN kelas c ON a.id_kelas = c.id_kelas 
                        LEFT JOIN mapel d ON a.id_mapel = d.id_mapel 
                        WHERE 1";

            if (!empty($cariDataPengajar)) {
                $query .= " AND (id_pengajar LIKE '%$cariDataPengajar%' 
                        OR nama_pengajar LIKE '%$cariDataPengajar%'
                        OR umur LIKE '%$cariDataPengajar%'
                        OR alamat LIKE '%$cariDataPengajar%'
                        OR no_telp LIKE '%$cariDataPengajar%'
                        OR id_key LIKE '%$cariDataPengajar%')";
            }

            $query .= " GROUP BY b.id_pengajar";

            $tabelPengajar = mysqli_query($connect, $query);
            $no = 1;
            while ($dataPengajar = mysqli_fetch_assoc($tabelPengajar)) {
                ?>
                <tbody class="toggle-more-info">
                    <tr class="main-info">
                        <td rowspan="4"><?= $no ?></td>
                        <td>
                            <?php
                            if (!empty($dataPengajar['profil'])) { ?>
                                <img src="../asset/pengajar/<?= $dataPengajar['profil'] ?>" alt="Pengajar">
                                <?php
                            } else { ?>
                                <img src="../asset/default.jpeg" alt="default">
                            <?php }
                            ?>
                        </td>
                        <td><?= $dataPengajar['id_pengajar'] ?></td>
                        <td><?= $dataPengajar['nama_pengajar'] ?></td>
                        <td><?= $dataPengajar['kelas'] ?></td>
                        <td><?= $dataPengajar['mapel'] ?></td>
                        <td><?= $dataPengajar['id_key'] ?></td>
                    </tr>
                    <tr class="more-info">
                        <th colspan="2">Umur</th>
                        <td colspan="2"><?= $dataPengajar['umur'] ?></td>
                        <td rowspan="3" colspan="2">
                            <a href="./data-pengajar/edit-pengajar.php?id_pengajar=<?= $dataPengajar['id_pengajar'] ?> "
                                class="button-aksi">Edit</a>
                            <span class="button-aksi"
                                onclick="confirm('Yakin mau menghapus?') ? window.location.href = './data-pengajar/hapus-pengajar.php?id_pengajar=<?= $dataPengajar['id_pengajar'] ?>' : null">Hapus</span>
                        </td>
                    </tr>
                    <tr class="more-info">
                        <th colspan="2">Alamat</th>
                        <td colspan="2"><?= $dataPengajar['alamat'] ?></td>
                    </tr>
                    <tr class="more-info">
                        <th colspan="2">No Telp</th>
                        <td colspan="2"><?= $dataPengajar['no_telp'] ?></td>
                    </tr>
                </tbody>
                <?php
                $no++;
            }
            ?>
        </table>

        <button><a href="./data-pengajar/tambah-pengajar.php">Tambah</a></button>
    </section>

    <section id="pembayaran">
        <form class="input-file" id="input-file1" method="POST" action="./data-pembayaran/input-bukti.php"
            enctype="multipart/form-data">
            <div class="wrap-input-file">
                <h1>Input Bukti Pembayaran</h1>
                <div>
                    <span>
                        <i class="fa-solid fa-upload"></i>
                        <p>Seret file kesini atau klik ...</p>
                        <p>(Hanya menerima jpg, png, jpeg)</p>
                    </span>
                    <input type="hidden" name="id_dituju1" id="id_dituju1">
                    <input type="file" name="bukti_pembayaran"
                        oninput="document.getElementById('input-file1').submit();">
                </div>
            </div>
        </form>

        <form class="menu filter" id="filterDataBayar" method="GET">
            <div>
                <span class="bulan">
                    <label for="bulan">Bulan: </label>
                    <select name="bulan" id="bulan" onchange="document.getElementById('filterDataBayar').submit();">
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
                    <select name="tahun" id="tahun" onchange="document.getElementById('filterDataBayar').submit();">
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
                <input type="search" name="cariDataBayar"
                    value="<?= isset($_GET['cariDataBayar']) ? $_GET['cariDataBayar'] : '' ?>">
                <input type="submit" value="Cari">
            </div>
        </form>

        <table>
            <tr>
                <th>No</th>
                <th>Pengajar</th>
                <th>ID Admin</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Bukti</th>
                <th>Status</th>
            </tr>

            <?php
            $cariDataBayar = isset($_GET['cariDataBayar']) ? mysqli_real_escape_string($connect, $_GET['cariDataBayar']) : '';
            $cariBulan = isset($_GET['bulan']) ? mysqli_real_escape_string($connect, $_GET['bulan']) : '';
            $cariTahun = isset($_GET['tahun']) ? mysqli_real_escape_string($connect, $_GET['tahun']) : '';
            $query = "SELECT a.*, b.nama_pengajar, c.nama_admin FROM pembayaran_gaji a 
                            LEFT JOIN pengajar b 
                            ON a.id_pengajar=b.id_pengajar
                            LEFT JOIN admin c 
                            ON a.id_admin=c.id_admin
                            WHERE 1";

            if (!empty($cariDataBayar)) {
                $query .= " AND (id_pembayaran LIKE '%$cariDataBayar%' 
                            OR a.id_pengajar LIKE '%$cariDataBayar%'
                            OR nama_pengajar LIKE '%$cariDataBayar%'
                            OR a.id_admin LIKE '%$cariDataBayar%'
                            OR tgl_pembayaran LIKE '%$cariDataBayar%')";
            }

            if (!empty($cariBulan)) {
                $query .= " AND bulan = '$cariBulan'";
            }
            if (!empty($cariTahun)) {
                $query .= " AND tahun = '$cariTahun'";
            }
            $tabelPembayaran = mysqli_query($connect, $query);
            $no = 1;
            while ($dataPembayaran = mysqli_fetch_assoc($tabelPembayaran)) {
                ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= $dataPembayaran['nama_pengajar'] ?></td>
                    <td><?= $dataPembayaran['id_admin'] ?></td>
                    <td><?= $dataPembayaran['tgl_pembayaran'] ?></td>
                    <td>Rp <?= $dataPembayaran['jumlah_pembayaran'] ?></td>
                    <td>
                        <div
                            class=" <?= $dataPembayaran['status'] == 'Proses' ? 'input-bukti' : 'input-bukti-disabled' ?> <?= !empty($dataPembayaran['bukti_pembayaran']) ? 'temp-hide' : '' ?>">
                            <button onclick="inputBukti(<?= $dataPembayaran['id_pembayaran'] ?>, 1)"><i
                                    class="fa-solid fa-file"></i></button>
                        </div>
                        <img src="../asset/bukti_pembayaran_gaji/<?= $dataPembayaran['bukti_pembayaran'] ?>"
                            class="<?= empty($dataPembayaran['bukti_pembayaran']) ? 'notShow' : '' ?>">

                    </td>
                    <td>
                        <div class="status-gaji <?= $dataPembayaran['status'] == 'Proses' ? 'proses' : 'selesai' ?> <?= empty($dataPembayaran['bukti_pembayaran']) ? 'disabled' : '' ?>"
                            onclick="updateStatus(<?= $dataPembayaran['id_pembayaran'] ?>, 'pembayaran', <?= $profilAdmin['id_admin'] ?>)">
                            <?= $dataPembayaran['status'] ?>
                        </div>
                    </td>
                </tr>
                <?php $no++;
            } ?>
        </table>
    </section>

    <section id="dari-pendaftar">

        <form class="menu filter" id="filterIDPendaftar" method="GET">
            <div class="wrap">
                <?php
                $tanggalHariIni = date('Y-m-d');
                ?>

                <label>Tanggal:</label>
                <span class="input"><?= $tanggalHariIni?></span>
            </div>
            <div class="cari">
                <input type="search" name="cariIDPendaftar"
                    value="<?= isset($_GET['cariIDPendaftar']) ? $_GET['cariIDPendaftar'] : '' ?>"
                    placeholder="Cari ID Pendaftar">
                <input type="submit" value="Cari">
            </div>
        </form>

        <table>
            <tr>
                <th>No</th>
                <th>Profil</th>
                <th>ID Pendaftar</th>
                <th>Nama Pendaftar</th>
                <th>Paket</th>
                <th>Tanggal EXP</th>
            </tr>
            <?php
            $cariIDPendaftar = isset($_GET['cariIDPendaftar']) ? mysqli_real_escape_string($connect, $_GET['cariIDPendaftar']) : '';

            $query = "SELECT a.*, b.nama_paket FROM data_pendaftar a 
                        LEFT JOIN paket_belajar b 
                        ON a.id_paket=b.id_paket
                        WHERE 1";

            if (!empty($cariIDPendaftar)) {
                $query .= " AND (id_pendaftar LIKE '%$cariIDPendaftar%')";
            }

            $tabelPendaftar = mysqli_query($connect, $query);
            $no = 1;
            while ($dataPendaftar = mysqli_fetch_assoc($tabelPendaftar)) {
            if($dataPendaftar['tgl_exp'] <= $tanggalHariIni){
                $exp = $dataPendaftar['tgl_exp'];
                mysqli_query($connect, "DELETE FROM data_pendaftar WHERE tgl_exp = '$exp'");
            }
                ?>
                <tbody class="toggle-more-info">
                    <tr class="main-info">
                        <td rowspan="8"><?= $no ?></td>
                        <td>
                            <?php
                            if (!empty($dataPendaftar['profil'])) { ?>
                                <img src="../asset/pendaftar/<?= $dataPendaftar['profil'] ?>" alt="pendaftar">
                                <?php
                            } else { ?>
                                <img src="../asset/default.jpeg" alt="default">
                            <?php }
                            ?>
                        </td>
                        <td><?= $dataPendaftar['id_pendaftar'] ?></td>
                        <td><?= $dataPendaftar['nama'] ?></td>
                        <td><?= $dataPendaftar['nama_paket'] ?></td>
                        <td><?= $dataPendaftar['tgl_exp'] ?></td>
                    </tr>
                    <tr class="more-info">
                        <th colspan="1">Umur</th>
                        <td colspan="2"><?= $dataPendaftar['umur'] ?></td>
                        <td rowspan="7" colspan="2">
                            <a href="./data-penerimaan/tambah-murid.php?id_pendaftar=<?= $dataPendaftar['id_pendaftar'] ?> "
                                class="button-resmi">Resmikan!</a>
                        </td>
                    </tr>
                    <tr class="more-info">
                        <th colspan="1">Kelas</th>
                        <td colspan="2"><?= $dataPendaftar['kelas'] . " " . $dataPendaftar['tingkat'] ?></td>
                    </tr>
                    <tr class="more-info">
                        <th colspan="1">Asal Sekolah</th>
                        <td colspan="2"><?= $dataPendaftar['asal_sekolah'] ?></td>
                    </tr>
                    <tr class="more-info">
                        <th colspan="1">Mapel Favorit</th>
                        <td colspan="2"><?= $dataPendaftar['mapel_favorit'] ?></td>
                    </tr>

                    <tr class="more-info">
                        <th colspan="1">Alamat</th>
                        <td colspan="2"><?= $dataPendaftar['alamat'] ?></td>
                    </tr>
                    <tr class="more-info">
                        <th colspan="1">Nama Orang Tua</th>
                        <td colspan="2"><?= $dataPendaftar['nama_ortu'] ?></td>
                    </tr>

                    <tr class="more-info">
                        <th colspan="1">No Orang Tua</th>
                        <td colspan="2"><?= $dataPendaftar['no_ortu'] ?></td>
                    </tr>
                </tbody>
                <?php
                $no++;
            }
            ?>
        </table>
    </section>

    <section id="dari-murid">
        <form class="input-file" id="input-file2" method="POST" action="./data-penerimaan/input-bukti.php"
            enctype="multipart/form-data">
            <div class="wrap-input-file">
                <h1>Input Bukti Pembayaran</h1>
                <div>
                    <span>
                        <i class="fa-solid fa-upload"></i>
                        <p>Seret file kesini atau klik ...</p>
                        <p>(Hanya menerima jpg, png, jpeg)</p>
                    </span>
                    <input type="hidden" name="id_dituju2" id="id_dituju2">
                    <input type="file" name="bukti_penerimaan"
                        oninput="document.getElementById('input-file2').submit();">
                </div>
            </div>
        </form>

        <form class="menu filter" id="filterDataTerima" method="GET">
            <div>
                <span class="bulan">
                    <label for="bulan">Bulan: </label>
                    <select name="bulan" id="bulan" onchange="document.getElementById('filterDataTerima').submit();">
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
                    <select name="tahun" id="tahun" onchange="document.getElementById('filterDataTerima').submit();">
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
                <input type="search" name="cariDataTerima"
                    value="<?= isset($_GET['cariDataTerima']) ? $_GET['cariDataTerima'] : '' ?>">
                <input type="submit" value="Cari">
            </div>
        </form>

        <table>
            <tr>
                <th>No</th>
                <th>Murid</th>
                <th>ID Admin</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Bukti</th>
                <th>Status</th>
            </tr>

            <?php
            $cariDataTerima = isset($_GET['cariDataTerima']) ? mysqli_real_escape_string($connect, $_GET['cariDataTerima']) : '';
            $cariBulan = isset($_GET['bulan']) ? mysqli_real_escape_string($connect, $_GET['bulan']) : '';
            $cariTahun = isset($_GET['tahun']) ? mysqli_real_escape_string($connect, $_GET['tahun']) : '';
            $query = "SELECT a.*, b.nama_murid, c.nama_admin FROM penerimaan_murid a 
                            LEFT JOIN murid b 
                            ON a.id_murid=b.id_murid
                            LEFT JOIN admin c 
                            ON a.id_admin=c.id_admin
                            WHERE 1";

            if (!empty($cariDataTerima)) {
                $query .= " AND (id_penerimaan LIKE '%$cariDataTerima%' 
                            OR a.id_murid LIKE '%$cariDataTerima%'
                            OR nama_murid LIKE '%$cariDataTerima%'
                            OR a.id_admin LIKE '%$cariDataTerima%'
                            OR tgl_penerimaan LIKE '%$cariDataTerima%')";
            }

            if (!empty($cariBulan)) {
                $query .= " AND bulan = '$cariBulan'";
            }
            if (!empty($cariTahun)) {
                $query .= " AND tahun = '$cariTahun'";
            }
            $tabelPenerimaan = mysqli_query($connect, $query);

            $no = 1;
            while ($dataPenerimaan = mysqli_fetch_assoc($tabelPenerimaan)) {
                ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= $dataPenerimaan['nama_murid'] ?></td>
                    <td><?= $dataPenerimaan['id_admin'] ?></td>
                    <td><?= $dataPenerimaan['tgl_penerimaan'] ?></td>
                    <td>Rp <?= $dataPenerimaan['jumlah_penerimaan'] ?></td>
                    <td>
                        <div
                            class=" <?= $dataPenerimaan['status'] == 'Proses' ? 'input-bukti' : 'input-bukti-disabled' ?> <?= !empty($dataPenerimaan['bukti_penerimaan']) ? 'temp-hide' : '' ?>">
                            <button onclick="inputBukti(<?= $dataPenerimaan['id_penerimaan'] ?>, 2)"><i
                                    class="fa-solid fa-file"></i></button>
                        </div>
                        <img src="../asset/bukti_penerimaan_murid/<?= $dataPenerimaan['bukti_penerimaan'] ?>"
                            class="<?= empty($dataPenerimaan['bukti_penerimaan']) ? 'notShow' : '' ?>">

                    </td>
                    <td>
                        <div class="status-gaji <?= $dataPenerimaan['status'] == 'Proses' ? 'proses' : 'selesai' ?> <?= empty($dataPenerimaan['bukti_penerimaan']) ? 'disabled' : '' ?>"
                            onclick="updateStatus(<?= $dataPenerimaan['id_penerimaan'] ?>, 'penerimaan', <?= $profilAdmin['id_admin'] ?>)">
                            <?= $dataPenerimaan['status'] ?>
                        </div>
                    </td>
                </tr>
                <?php $no++;
            } ?>
        </table>
    </section>

    <script>
        document.querySelectorAll('.input-file')
            .forEach(input => input.addEventListener('click', () => input.style.display = 'none'))

        function inputBukti(id, i) {
            document.getElementById(`input-file${i}`).style.display = 'flex';
            document.getElementById(`id_dituju${i}`).value = id;
        }

        function updateStatus(id, tujuan, id_admin) {
            confirm("Anda yakin ingin melanjutkan?") ? window.location.href = `./data-${tujuan}/update-status.php?id_${tujuan}=${id}&id_admin=${id_admin}` : null;
        }
        function alertConfirm() {
            confirm("Anda yakin ingin keluar?") ? window.location.href = "../logout.php" : null;
        }
    </script>
</body>

</html>