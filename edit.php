<?php
include "service/database.php";
session_start();

$update_message = "";

$id = $_GET["id"]; 

$sql = "SELECT * FROM printer WHERE no = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no = $_POST["no"];
    $nama = $_POST["nama"];
    $warna = $_POST["warna"];
    $jumlah = $_POST["jumlah"];

    $sql_update = "UPDATE printer SET no = ?, nama = ?, warna = ?, jumlah = ? WHERE no = ?";
    $stmt = $db->prepare($sql_update);
    $stmt->bind_param("ssssi", $no, $nama, $warna, $jumlah, $id);

    if ($stmt->execute()) {
        $update_message = "Data berhasil diperbarui.";
    } else {
        $update_message = "Gagal memperbarui data.";
    }
}

$db->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Barang</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('layout/background.jpg'); 
            background-size: cover;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 500px;
            margin: 30px auto;
            padding: 15px;
            background-color: rgb(195,192,192, 0.7);
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
            font-size: 1.5em;
            color: rgb (0, 0, 0, 0.1);
            margin: 15px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input, select {
            width: 470px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            
        }

        .update-message {
            text-align: center;
            margin-top: 15px;
            font-size: 1em;
            color:rgb(2,0,108);
        }

        .button {
            font-size: 15px;
            padding: 10px;
            text-decoration: none;
            background-color: #1679AB;
            color: #ececec;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        
        .button:hover {
            background-color: #496989; 
        }
        
        .button2 {
            font-size: 13px;
            padding: 5px;
            text-decoration: none;
            background-color: #A8CD9F;
            color: black;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button2:hover {
            background-color: #58A399;
        }

        .button-row {
            display: flex;
            justify-content: space-between; 
            margin-top: 5px;
        }

        .button-row .button {
            max-width: 200px;
            padding: 10px;
        }
    </style>
</head>
<body>
    <?php include "layout/header.html"; ?>

    <div class="container">
        <h3>UBAH DATA BARANG</h3>

        <div class="update-message">
            <?= $update_message ?>
            <?php if ($update_message === "Data berhasil diperbarui.") : ?>
                <a href="tampilkan.php" class="button">Data Barang</a> 
            <?php endif; ?>
        </div>

        <form action="" method="POST">
            <div class="form-group">
                <label for="no">Nomor</label>
                <input type="text" id="no" name="no" value="<?= htmlspecialchars($data['no']) ?>" required>
            </div>
        
            <div class="form-group">
                <label for="nama">Nama Merk Barang</label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
            </div>

            <div class.form-group>
                <label for="warna">Warna Barang</label>
                <input type="text" id="warna" name="warna" value="<?= htmlspecialchars($data['warna']) ?>" required>
            </div>

            <div class="form-group">
                <label for="jumlah">Jumlah Barang</label>
                <input type="number" id="jumlah" name="jumlah" value="<?= htmlspecialchars($data['jumlah']) ?>" required>
            </div>

            <div class="button-row">
                <a href="index.php" class="button">Kembali ke Beranda</a>
                <button type="submit" class="button" style="border:none;">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <?php include "layout/footer.html"; ?>
</body>
</html>
