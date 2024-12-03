<?php

include "../koneksi.php";

session_start();

if (!isset($_SESSION['userId'])) {
    header("location:../login.php");
    exit();
}



if (isset($_GET['hapus'])) {
    $nik = $_GET['hapus'];
    $query = "DELETE FROM member WHERE nik='$nik'";
    mysqli_query($koneksi, $query);
    header("location:kelolauser.php");
    exit();
}

$query = "SELECT nik, nama, jk, telp, alamat, user FROM member";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body>
    <?php include "../navbar.php"; ?>
<div class="container mx-auto p-4">
    <h2 class="text-3xl font-bold text-center my-4">Tabel Pengguna</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-2">NIK</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Jenis Kelamin</th>
                    <th class="px-4 py-2">Telepon</th>
                    <th class="px-4 py-2">Alamat</th>
                    <th class="px-4 py-2">Username</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 border"><?php echo $row['nik']; ?></td>
                    <td class="px-4 py-2 border"><?php echo $row['nama']; ?></td>
                    <td class="px-4 py-2 border"><?php echo $row['jk']; ?></td>
                    <td class="px-4 py-2 border"><?php echo $row['telp']; ?></td>
                    <td class="px-4 py-2 border"><?php echo $row['alamat']; ?></td>
                    <td class="px-4 py-2 border"><?php echo $row['user']; ?></td>
                    <td class="px-4 py-2 border">
                        <a href="edituser.php?nik=<?php echo $row['nik']; ?>" class="px-2 py-1 border rounded-md bg-blue-500 text-white hover:bg-blue-600">Edit</a>
                        <a href="?hapus=<?php echo $row['nik']; ?>" class="px-2 py-1 border rounded-md bg-red-500 text-white hover:bg-red-600">Hapus</a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>



