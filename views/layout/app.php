<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title ?? 'Vin web') ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidenav {
            width: 250px;
            height: 100vh;
            background-color: #333;
            color: white;
            padding: 20px;
            box-sizing: border-box;
        }

        .sidenav h2 {
            margin-top: 0;
            color: #fff;
        }

        .sidenav a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 0;
            border-bottom: 1px solid #555;
        }

        .sidenav a:hover {
            background-color: #575757;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-btn {
            background: none;
            border: none;
            color: white;
            padding: 10px 0;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-family: inherit;
            font-size: inherit;
        }

        .dropdown-btn:hover {
            background-color: #575757;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content {
            display: none;
            background-color: #444;
            padding-left: 20px;
        }

        .dropdown-content a {
            padding: 8px 0;
            border-bottom: none;
        }

        .dropdown-content a:hover {
            background-color: #666;
        }

        main {
            flex: 1;
        }

        .container {
            margin: 20px;
            padding: 20px;
            border-radius: 15px;
            background-color: #f4f4f4;
            color: #333;
            min-height: 70vh;
        }

        <style>.btn-word {
            background: #007bff;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 12px;
            display: inline-block;
        }

        .btn-word:hover {
            background: #0056b3;
            color: white;
        }
    </style>

    </style>

    <!-- Font Awesome 6 FREE CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="sidenav">
        <h2>Navigation</h2>
        <a href="?page=dashboard">Dashboard</a>
        <a href="?page=pelanggaran">pelanggaran</a>
        <div class="dropdown">
            <button class="dropdown-btn">data filler</button>
            <div class="dropdown-content">
                <a href="?page=kelas">kelas</a>
                <a href="?page=jenis_pelanggaran">jenis pelanggaran</a>
                <a href="?page=alasan_pelanggaran">alasan pelanggaran</a>
                <a href="?page=mapel">mapel</a>
            </div>
        </div>

        <div class="dropdown">
            <button class="dropdown-btn">Siswa</button>
            <div class="dropdown-content">
                <a href="?page=siswa">dashboard</a>
                <a href="?page=siswa_table">Table</a>
            </div>
        </div>

        <div class="dropdown">
            <button class="dropdown-btn">guru</button>
            <div class="dropdown-content">
                <a href="?page=guru">dashboard</a>
                <a href="?page=guru_table">Table</a>
            </div>
        </div>

        <a href="?page=users">user</a>
    </div>

    <main>
        <div class="container">
            <?= $this->section('main') ?>
        </div>
    </main>

</body>

</html>