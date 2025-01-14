<?php
include 'db_connect.php';

// Variabel untuk menyimpan filter
$merk_kendaraan = '';
$tipe_kendaraan = '';
$tanggal = '';

// Proses filter jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $merk_kendaraan = $_POST['merk_kendaraan'] ?? '';
    $tipe_kendaraan = $_POST['tipe_kendaraan'] ?? '';
    $tanggal = $_POST['tanggal'] ?? '';
}

// Query untuk mengambil data kendaraan berdasarkan filter
$query = "SELECT * FROM kendaraan WHERE 1=1";
if ($merk_kendaraan) {
    $query .= " AND merk_kendaraan LIKE ?";
}
if ($tipe_kendaraan) {
    $query .= " AND tipe_kendaraan LIKE ?";
}
if ($tanggal) {
    $query .= " AND tanggal = ?";
}

$stmt = $conn->prepare($query);
$param1 = "%" . $merk_kendaraan . "%";
$param2 = "%" . $tipe_kendaraan . "%";
$params = [];
if ($merk_kendaraan) $params[] = $param1;
if ($tipe_kendaraan) $params[] = $param2;
if ($tanggal) $params[] = $tanggal;

// Bind parameters
if ($params) {
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Data Kendaraan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
            border-bottom: 2px solid #007BFF;
            display: inline-block;
            padding-bottom: 5px;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="date"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
            font-size: 14px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 14px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            color: black;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #eaf3ff;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            background-color: #007BFF;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Riwayat Data Kendaraan</h2>
        <form method="post">
            <input type="text" name="merk_kendaraan" placeholder="Cari Merk Kendaraan" value="<?php echo htmlspecialchars($merk_kendaraan); ?>">
            <input type="text" name="tipe_kendaraan" placeholder="Cari Tipe Kendaraan" value="<?php echo htmlspecialchars($tipe_kendaraan); ?>">
            <input type="date" name="tanggal" value="<?php echo htmlspecialchars($tanggal); ?>">
            <button type="submit">Filter</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Nomor Urut</th>
                    <th>No. Polisi</th>
                    <th>Nama Pemilik</th>
                    <th>Alamat</th>
                    <th>Merk Kendaraan</th>
                    <th>Tipe Kendaraan</th>
                    <th>Keterangan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['nomor_urut']}</td>
                            <td>{$row['no_pol']}</td>
                            <td>{$row['nama_pemilik']}</td>
                            <td>{$row['alamat']}</td>
                            <td>{$row['merk_kendaraan']}</td>
                            <td>{$row['tipe_kendaraan']}</td>
                            <td>{$row['keterangan']}</td>
                            <td>{$row['tanggal']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' style='text-align:center;'>Tidak ada data riwayat kendaraan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="input_data.php">Kembali ke Home</a>
    </div>
</body>
</html>