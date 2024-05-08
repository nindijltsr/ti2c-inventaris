<?php
include "service/database.php";

if (isset($_GET["delete"])) {
    $no = $_GET["delete"];
    $sql_delete = "DELETE FROM printer WHERE no = ?";
    $stmt = $db->prepare($sql_delete);
    $stmt->bind_param("i", $no);

    if ($stmt->execute()) {
        $delete_message = "Data barang berhasil dihapus.";
    } else {
        $delete_message = "Gagal menghapus data barang.";
    }
}

$sql = "SELECT * FROM printer";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/pen.css' rel='stylesheet'>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('layout/background.jpg');
            background-size: cover;
            font-family: Arial, sans-serif;
        }

        table {
            width: 90%;
            position: center;
            border-collapse: collapse;
            margin: 20px auto;
        }

        tr {
            color: #ececec;
        }

        table,
        th,
        td {
            border: 1px solid #ececec;
        }

        h2 {
            color: #ececec;
        }

        th {
            background-color: rgb(34, 43, 78, 0.7);
            font-weight: bold;
            text-align: center;
        }

        th,
        td {
            padding: 12px;
        }

        td {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin-top: 15px;

        }

        .btn:hover {
            background-color: #0056b3;
        }

        .center {
            text-align: center;
        }

        .delete-btn {
            height: 15px;
            background-color: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        .edit-btn {
            height: 15px;
            background-color: #329932;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
            display: inline-flex;
            align-items: center;
        }

        .edit-btn i {
            margin-right: 8px;
        }

        .edit-btn:hover {
            background-color: #008000;
        }

        .gg-pen {
            box-sizing: border-box;
            display: block;
            transform: rotate(-45deg) scale(var(--ggs, 1));
            width: 10px;
            height: 4px;
            border-right: 2px solid transparent;
            box-shadow:
                0 0 0 2px,
                inset -2px 0 0;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 1px;
            margin-right: -6px
        }

        .gg-pen::after,
        .gg-pen::before {
            content: "";
            display: block;
            box-sizing: border-box;
            position: absolute
        }

        .gg-pen::before {
            background: currentColor;
            border-left: 0;
            right: -6px;
            width: 3px;
            height: 4px;
            border-radius: 1px;
            top: 0
        }

        .gg-pen::after {
            width: 8px;
            height: 7px;
            border-top: 4px solid transparent;
            border-bottom: 4px solid transparent;
            border-right: 7px solid;
            left: -11px;
            top: -2px
        }
    </style>
</head>

<body>
    <?php include "layout/header.html"; ?>

    <div class="center">
        <h2>Data Barang</h2>

        <?php if (isset($delete_message)): ?>
            <p style="color:#ececec;"><?= $delete_message ?></p>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>NO</th>
                    <th>Nama Merk Barang</th>
                    <th>Warna</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
                <?php
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row["no"] ?></td>
                        <td><?= $row["nama"] ?></td>
                        <td><?= $row["warna"] ?></td>
                        <td><?= $row["jumlah"] ?></td>
                        <td>
                            <a class="btn delete-btn" href="?delete=<?= $row["no"] ?>">(-) Hapus Data</a>
                            <a class="btn edit-btn" href="edit.php?id=<?= $row["no"] ?>"><i class="gg-pen"></i>Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p style="color: #ececec;">Tidak ada data yang ditemukan.</p>
        <?php endif; ?>

        <a href="register.php" class="btn">(+) Tambah Data Barang</a>
        <br>
        <a class="btn" href="index.php"> >> Kembali ke Halaman Utama</a>
    </div>

    <?php
    $db->close();
    ?>

    <?php include "layout/footer.html"; ?>
</body>

</html>