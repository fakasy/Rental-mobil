<?php
include "koneksi.php";

if (isset($_POST['register'])) {
    $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jk = mysqli_real_escape_string($koneksi, $_POST['jk']);
    $telp = mysqli_real_escape_string($koneksi, $_POST['telp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $user = mysqli_real_escape_string($koneksi, $_POST['user']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO member (nik, nama, jk, telp, alamat, user, password) VALUES ('$nik', '$nama', '$jk', '$telp', '$alamat', '$user', '$password')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("location:member/index.php");
    } else {
        echo "<script>alert('Gagal mendaftar!');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-bold text-center mb-12">Register</h2>
        <form action="" method="post">
            <div class="flex flex-col space-y-4">
                <label for="nik">NIK</label>
                <input type="text" name="nik" id="nik" class="w-full p-3 border border-gray-300 rounded-md" required>
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama" class="w-full p-3 border border-gray-300 rounded-md" required>
                <label for="jk">Jenis Kelamin</label>
                <select name="jk" id="jk" class="w-full p-3 border border-gray-300 rounded-md" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
                <label for="telp">Telepon</label>
                <input type="text" name="telp" id="telp" class="w-full p-3 border border-gray-300 rounded-md" required>
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" class="w-full p-3 border border-gray-300 rounded-md" required></textarea>
                <label for="user">Username</label>
                <input type="text" name="user" id="user" class="w-full p-3 border border-gray-300 rounded-md" required>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="w-full p-3 border border-gray-300 rounded-md" required>
                <button type="submit" name="register" class="w-full p-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Register</button>
            </div>
        </form>
        <p class="text-center mt-4">
            Sudah punya akun? <a href="login.php" class="text-blue-500 hover:text-blue-700">Login</a>
        </p>
    </div>
</body>
</html>
