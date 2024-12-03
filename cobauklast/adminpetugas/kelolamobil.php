<?php

include("../koneksi.php");
session_start();

if (!isset($_SESSION['userId'])) {
    header("location:../login.php");
    exit();
}

function hapusMobil($id) {
    global $koneksi;
    $query = "DELETE FROM mobil WHERE nopol='$id'";
    mysqli_query($koneksi, $query);
}

if (isset($_GET['hapus'])) {
    hapusMobil($_GET['hapus']);
    header("location:kelolamobil.php");
    exit();
}

$query = "SELECT * FROM mobil";
$result = mysqli_query($koneksi, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Mobil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <?php
    include("../navbar.php");
    ?>
    <section class="py-16">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">Kelola Mobil</h2>
            <a href="tambahmobil.php" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md">Tambah Mobil</a>
            <br><br>
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">No. Pol</th>
                        <th class="px-4 py-2">Brand</th>
                        <th class="px-4 py-2">Type</th>
                        <th class="px-4 py-2">Tahun</th>
                        <th class="px-4 py-2">Harga</th>
                        <th class="px-4 py-2">Foto</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td class="px-4 py-2 border"><?php echo $row['nopol']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $row['brand']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $row['type']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $row['tahun']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $row['harga']; ?></td>
                        <td class="px-4 py-2 border"><img src="../foto/<?php echo $row['foto']; ?>" alt="" class="w-20 h-20"></td>
                        <td class="px-4 py-2 border"><?php echo $row['status']; ?></td>
                        <td class="px-4 py-2 border">
                            <a href="editmobil.php?id=<?php echo $row['nopol']; ?>" class="px-2 py-1 border rounded-md bg-blue-500 text-white hover:bg-blue-600">Edit</a>
                            <a href="?hapus=<?php echo $row['nopol']; ?>" class="px-2 py-1 border rounded-md bg-red-500 text-white hover:bg-red-600">Hapus</a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>

