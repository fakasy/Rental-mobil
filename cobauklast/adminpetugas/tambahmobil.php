<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("location:../login.php");
    exit();
}
if (isset($_POST['tambah'])) {
    $nopol = mysqli_real_escape_string($koneksi, $_POST['nopol']);
    $brand = mysqli_real_escape_string($koneksi, $_POST['brand']);
    $type = mysqli_real_escape_string($koneksi, $_POST['type']);
    $tahun = mysqli_real_escape_string($koneksi, $_POST['tahun']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $foto = $_FILES['foto']['name'];
    $tmpName = $_FILES['foto']['tmp_name'];

    // Validasi ekstensi file gambar
    $allowed = array('png', 'jpg', 'jpeg');
    $ext = pathinfo($foto, PATHINFO_EXTENSION);

    if (in_array($ext, $allowed)) {
        // Menentukan path untuk menyimpan file gambar
        $targetPath = "../foto/$foto";

        // Mengupload file gambar
        $upload = move_uploaded_file($tmpName, $targetPath);

        if ($upload) {
            // Menyimpan data mobil ke database
            $query = "INSERT INTO mobil (nopol, brand, type, tahun, harga, foto) VALUES ('$nopol', '$brand', '$type', '$tahun', '$harga', '$foto')";
            $result = mysqli_query($koneksi, $query);

            if ($result) {
                echo "<script>alert('Mobil berhasil ditambahkan!');</script>";
                header("location:kelolamobil.php");
                exit();
            } else {
                echo "<script>alert('Gagal menambahkan mobil!');</script>";
            }
        } else {
            echo "<script>alert('Gagal upload foto!');</script>";
        }
    } else {
        echo "<script>alert('Format foto tidak diperbolehkan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="max-w-7xl mx-auto py-12">
        <h2 class="text-3xl font-bold text-center mb-12">Tambah Mobil</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="flex flex-col space-y-4">
                <label for="nopol" class="block text-sm font-medium">Nopol</label>
                <input type="text" name="nopol" id="nopol" class="w-full p-3 border border-gray-300 rounded-md" required>
                <label for="brand" class="block text-sm font-medium">Brand</label>
                <input type="text" name="brand" id="brand" class="w-full p-3 border border-gray-300 rounded-md" required>
                <label for="type" class="block text-sm font-medium">Type</label>
                <input type="text" name="type" id="type" class="w-full p-3 border border-gray-300 rounded-md" required>
                <label for="tahun" class="block text-sm font-medium">Tahun</label>
                <input type="date" name="tahun" id="tahun" class="w-full p-3 border border-gray-300 rounded-md" required>
                <label for="harga" class="block text-sm font-medium">Harga</label>
                <input type="number" name="harga" id="harga" class="w-full p-3 border border-gray-300 rounded-md" required>
                <label for="foto" class="block text-sm font-medium">Foto</label>
                <input type="file" name="foto" id="foto" accept=".png,.jpg" class="w-full p-3 border border-gray-300 rounded-md" required>
                <button type="submit" name="tambah" class="w-full p-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Tambah</button>
                <a href="kelolamobil.php" class="w-full p-3 bg-gray-500 hover:bg-gray-600 text-white rounded-md">Kembali</a>
            </div>
        </form>
    </div>

</html>

