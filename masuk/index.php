<?php
if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal') {
    echo "<script>alert('Username atau password salah')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="../asset/thumbnail.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | Insight & Quality Bimbel</title>
    <link rel="stylesheet" href="./masuk.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bona+Nova+SC:ital,wght@0,400;0,700;1,400&family=Tuffy:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="container">
        <h1>Selamat Datang Kembali</h1>
        <form method="POST" action="proses-login.php">
            <div class="wrap">
                <input type="text" name="username" id="username" required>
                <label for="username">Username:</label>
            </div>
            <div class="wrap">
                <input type="password" maxlength="8" name="password" id="password" required>
                <label for="password">Password:</label>
            </div>
            <div>
                <div class="wrap">
                    <input type="text" name="captcha" id="captcha" required>
                    <label for="captcha">Masukkan kode di bawah:</label>
                </div>
                <img src="captcha.php?rand=<?= rand(); ?>" alt="captcha">
            </div>
            <center><button type="submit">Masuk</button></center>
            
            <p>
                <a href="./reset-password/">Lupa Password</a>
                <a href="../daftar/">Daftar</a>
            </p>
            <center><a href="../" class="back"><i class="fa-solid fa-arrow-right-from-bracket"></i></a></center>
        </form>
    </div>
</body>

</html>