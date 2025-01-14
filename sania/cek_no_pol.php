<?php
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Nomor Polisi</title>
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
            max-width: 600px;
            margin: 50px auto;
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
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            color: #333;
        }
        input[type="text"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #eaf3ff;
            border: 1px solid #007BFF;
            border-radius: 5px;
        }
        .result h3 {
            margin: 0 0 10px;
            color: #007BFF;
        }
        .result p {
            margin: 5px 0;
            font-size: 14px;
            color: #333;
        }
        .no-result {
            margin-top: 20px;
            padding: 15px;
            background-color: #ffeded;
            border: 1px solid #ff6b6b;
            border-radius: 5px;
            color: #ff6b6b;
            text-align: center;
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
        <h2>Cek Nomor Polisi</h2>
        <form method="get">
            <label for="no_pol">Masukkan No. Polisi:</label>
            <input type="text" id="no_pol" name="no_pol" placeholder="Contoh: AB 1234 CD" required>
            <button type="submit">Cari</button>
        </form>
        <?php
        if (isset($_GET['no_pol'])) {
            $no_pol = $_GET['no_pol'];

            $query = "SELECT * FROM kendaraan WHERE no_pol = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $no_pol);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<div class='result'>
                        <h3>Data Ditemukan:</h3>
                        <p><strong>Nomor Urut:</strong> {$row['nomor_urut']}</p>
                        <p><strong>Nama Pemilik:</strong> {$row['nama_pemilik']}</p>
                        <p><strong>Alamat:</strong> {$row['alamat']}</p>
                        <p><strong>Merk Kendaraan:</strong> {$row['merk_kendaraan']}</p>
                        <p><strong>Tipe Kendaraan:</strong> {$row['tipe_kendaraan']}</p>
                        <p><strong>Keterangan:</strong> {$row['keterangan']}</p>
                        <p><strong>Tanggal:</strong> {$row['tanggal']}</p>
                    </div>";
            } else {
                echo "<div class='no-result'>Data tidak ditemukan.</div>";
            }
        }
        ?>
        <a href="input_data.php">Kembali ke Home</a>
    </div>
</body>
</html>
