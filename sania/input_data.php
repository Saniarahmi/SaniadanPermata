<?php
session_start();
include 'db_connect.php';

// Cek apakah user sudah login
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

// Variabel untuk menyimpan data edit
$edit = null;

// Proses input data kendaraan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        // Proses update data kendaraan
        $id = $_POST['id']; // Ambil ID untuk update
        $nomor_urut = $_POST['nomor_urut'];
        $no_pol = $_POST['no_pol'];
        $nama_pemilik = $_POST['nama_pemilik'];
        $alamat = $_POST['alamat'];
        $merk_kendaraan = $_POST['merk_kendaraan'];
        $tipe_kendaraan = $_POST['tipe_kendaraan'];
        $keterangan = $_POST['keterangan'];
        $tanggal = $_POST['tanggal'];

        $query = "UPDATE kendaraan SET no_pol=?, nama_pemilik=?, alamat=?, merk_kendaraan=?, tipe_kendaraan=?, keterangan=?, tanggal=? WHERE id=?";
        $stmt = $conn->prepare($query);
        // Pastikan tipe data sesuai
        $stmt->bind_param("sssssssi", $no_pol, $nama_pemilik, $alamat, $merk_kendaraan, $tipe_kendaraan, $keterangan, $tanggal, $id);

        if ($stmt->execute()) {
            $success = "Data berhasil diupdate!";
        } else {
            $error = "Gagal mengupdate data!";
        }
    } elseif (isset($_POST['delete'])) {
        // Proses delete data kendaraan
        $id = $_POST['id']; // Ambil ID untuk delete

        $query = "DELETE FROM kendaraan WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $success = "Data berhasil dihapus!";
        } else {
            $error = "Gagal menghapus data!";
        }
    } elseif (isset($_POST['edit'])) {
        // Proses ambil data untuk di-edit
        $id = $_POST['id']; // Ambil ID untuk edit
        $query = "SELECT * FROM kendaraan WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $edit = $result->fetch_assoc(); // Ambil data untuk diedit
        } else {
            $error = "Data tidak ditemukan!";
        }
    } else {
        // Proses input data kendaraan baru
        $nomor_urut = "";
        $no_pol = $_POST['no_pol'];
        $nama_pemilik = $_POST['nama_pemilik'];
        $alamat = $_POST['alamat'];
        $merk_kendaraan = $_POST['merk_kendaraan'];
        $tipe_kendaraan = $_POST['tipe_kendaraan'];
        $keterangan = $_POST['keterangan'];
        $tanggal = $_POST['tanggal'];

        $query = "INSERT INTO kendaraan (nomor_urut, no_pol, nama_pemilik, alamat, merk_kendaraan, tipe_kendaraan, keterangan, tanggal) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isssssss", $nomor_urut, $no_pol, $nama_pemilik, $alamat, $merk_kendaraan, $tipe_kendaraan, $keterangan, $tanggal);

        if ($stmt->execute()) {
            $success = "Data berhasil disimpan!";
        } else {
            $error = "Gagal menyimpan data!";
        }
    }
}

// Ambil semua data kendaraan
$query = "SELECT * FROM kendaraan ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Kendaraan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #343a40;
        }
        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {
            text-align: center;
            color: #007BFF;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .table-container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #dee2e6;
            text-align: left;
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
        .links {
            text-align: center;
            margin-top: 20px;
        }
        .links a {
            color: #007BFF;
            text-decoration: none;
            margin: 0 10px;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="logout.php" method="post">
            <button type="submit">Logout</button>
        </form>
        <h2>Input Data Kendaraan</h2>
        <div class="content">
            <div class="form-container">
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $edit['id'] ?? ''; ?>"> <!-- Hidden input untuk ID -->
                    <!-- <label>Nomor Urut:</label>
                    <input type="text" name="nomor_urut" value="<?php echo $edit['nomor_urut'] ?? ''; ?>" required> -->
                    <label>No. Polisi:</label>
                    <input type="text" name="no_pol" value="<?php echo $edit['no_pol'] ?? ''; ?>" required>
                    <label>Nama Pemilik:</label>
                    <input type="text" name="nama_pemilik" value="<?php echo $edit['nama_pemilik'] ?? ''; ?>" required>
                    <label>Alamat:</label>
                    <input type="text" name="alamat" value="<?php echo $edit['alamat'] ?? ''; ?>" required>
                    <label>Merk Kendaraan:</label>
                    <input type="text" name="merk_kendaraan" value="<?php echo $edit['merk_kendaraan'] ?? ''; ?>" required>
                    <label>Tipe Kendaraan:</label>
                    <input type="text" name="tipe_kendaraan" value="<?php echo $edit['tipe_kendaraan'] ?? ''; ?>" required>
                    <label>Keterangan:</label>
                    <textarea name="keterangan" required><?php echo $edit['keterangan'] ?? ''; ?></textarea>
                    <label>Tanggal:</label>
                    <input type="date" name="tanggal" value="<?php echo $edit['tanggal'] ?? ''; ?>" required>
                    <button type="submit" name="<?php echo isset($edit) ? 'update' : 'submit'; ?>">
                        <?php echo isset($edit) ? 'Update' : 'Simpan'; ?>
                    </button>
                </form>
                <?php
                if (isset($success)) echo "<div class='message success'>$success</div>";
                if (isset($error)) echo "<div class='message error'>$error</div>";
                ?>
            </div>

            <div class="table-container">
                <h3>Data Kendaraan yang Pernah Didata</h3>
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $no = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['no_pol']}</td>
                                    <td>{$row['nama_pemilik']}</td>
                                    <td>{$row['alamat']}</td>
                                    <td>{$row['merk_kendaraan']}</td>
                                    <td>{$row['tipe_kendaraan']}</td>
                                    <td>{$row['keterangan']}</td>
                                    <td>{$row['tanggal']}</td>
                                    <td>
                                        <form method='post' style='display:inline;'>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <button type='submit' name='edit'>Edit</button>
                                        </form>
                                        <form method='post' style='display:inline;'>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <button type='submit' name='delete' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>Delete</button>
                                        </form>
                                    </td>
                                </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='9' style='text-align:center;'>Tidak ada data kendaraan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="links">
            <a href="riwayat.php">Lihat Riwayat</a> | 
            <a href="cek_no_pol.php">Cek No. Pol</a>
        </div>
    </div>
</body>
</html>