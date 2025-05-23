<?php
session_start();
$conn = new mysqli("localhost", "root", "", "kampus_db");

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'dosen') {
    header("Location: ../index.php");
    exit;
}

$id_dosen = $_SESSION['id_dosen'] ?? null;

$qDosen = $conn->query("SELECT nama FROM dosen WHERE id = '$id_dosen'");
$dataDosen = $qDosen->fetch_assoc();
$nama_dosen = $dataDosen['nama'] ?? '';

$qJadwal = $conn->query("SELECT krs.*, matkul.nama_matkul, matkul.sks 
                         FROM krs 
                         JOIN matkul ON krs.kode_matkul = matkul.kode_matkul 
                         WHERE krs.id_dosen = '$id_dosen'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Dosen</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            padding: 30px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
        }
        h2 {
            color: #2c3e50;
        }
        .info {
            margin-bottom: 20px;
            background: #ffffff;
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 14px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .btn-back {
            display: inline-block;
            margin-top: 30px;
            background: #6c757d;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 6px;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📋 Laporan Jadwal Mengajar</h2>
        <div class="info">
            Nama Dosen: <strong><?= $nama_dosen; ?></strong>
        </div>

        <table>
            <tr>
                <th>No</th>
                <th>Kode Mata Kuliah</th>
                <th>Nama Mata Kuliah</th>
                <th>SKS</th>
                <th>Hari</th>
                <th>Ruangan</th>
            </tr>
            <?php $no = 1; while ($row = $qJadwal->fetch_assoc()): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['kode_matkul']; ?></td>
                <td><?= $row['nama_matkul']; ?></td>
                <td><?= $row['sks']; ?></td>
                <td><?= $row['hari']; ?></td>
                <td><?= $row['ruangan']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <a href="dashboard.php" class="btn-back">← Kembali ke Dashboard</a>
    </div>
</body>
</html>