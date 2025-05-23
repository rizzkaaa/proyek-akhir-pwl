<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="../../asset/thumbnail.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Insight & Quality Bimbel</title>
    <link rel="stylesheet" href="./daftar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bona+Nova+SC:ital,wght@0,400;0,700;1,400&family=Tuffy:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        * {
            padding: 0;
            margin: 0;
            font-family: "Tuffy", sans-serif;
        }

        body {
            display: flex;
            height: 600px;
            background-image: url(../../asset/bg-masuk.png);
        }

        .container {
            margin: auto;
        }

        h1 {
            text-align: center;
            font-family: "Bona Nova SC", serif;
            font-size: 45px;
            color: rgb(58, 58, 58);
        }

        form {
            background-color: rgba(255, 255, 255, 0.445);
            border: 1px solid white;
            margin: 50px;
            padding: 30px;
            box-shadow: 0 0 3px grey;
            backdrop-filter: blur(5px);
            border-radius: 20px;
        }

        .wrap {
            display: flex;
            flex-direction: column-reverse;
            margin: 10px;
        }

        label {
            font-size: 17px;
            transform: translateY(30px) translateX(10px);
            transition: transform 0.3s;
        }

        input,select {
            padding: 5px;
            width: 500px;
            border: 0.5px solid rgb(255, 166, 0);
            border-radius: 5px;
            font-size: 17px;
        }
        select {
            width: 510px;
            background-color: white;
            margin-top: 20px;
        }
        input:focus,
        input:valid,
        select:focus,
        select:valid {
            outline: none;
            border: none;
            border-bottom: 0.5px solid rgb(255, 166, 0);
            border-radius: 0;
        }

        input:focus+label,
        input:valid+label {
            transform: translate(0);
            transition: transform 0.3s;
        }

        button {
            padding: 10px 20px;
            margin: 20px;
            border-radius: 50px;
            border: 2px solid rgb(253, 208, 9);
            backdrop-filter: blur(10px);
            box-shadow: 0 0 3px grey;
            position: relative;
            overflow: hidden;
            background-color: rgba(247, 245, 243, 0.308);
            text-transform: uppercase;
            font-size: 16px;
            transition: 0.3s;
            z-index: 1;
            font-weight: bold;
            color: rgb(39, 37, 37);
            transition: all 1s;
            cursor: pointer;
        }

        button::before {
            content: '';
            width: 105%;
            height: 300%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(45deg);
            background: rgb(253, 208, 9);
            transition: 0.8s ease;
            display: block;
            z-index: -1;
        }

        button:hover::before {
            width: 0;
        }

        button:active {
            background-color: rgb(253, 208, 9);
        }
        p{
            text-align: center;
            margin-top: 10px
        }
        a{
            color: rgb(253, 127, 9);
            text-decoration: none;
            font-weight: bold;
        }
        a i{
            transform: rotateY(180deg);
        }
        a i:hover{
            transform: rotateY(540deg) scale(1.1);
            transition: all 1s;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Isi Data Berikut</h1>
        <form>
            <div class="wrap">
                <input type="text" name="username" id="username" required>
                <label for="username">Username:</label>
            </div>
            <div class="wrap">
                <input type="text" name="no_ortu" id="no_ortu" required>
                <label for="no_ortu">No Telp Orang Tua:</label>
            </div>
            <div class="wrap">
                <select name="id_paket" id="id_paket" required>
                    <option value="">Paket Belajar:</option>
                    <option value="A">Paket A</option>
                    <option value="B">Paket B</option>
                    <option value="C">Paket C</option>
                </select>
            </div>
            <center><button>Cari</button></center>
            <p>Password Anda ********</p>
            <a href="../"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
        </form>
    </div>
</body>

</html>