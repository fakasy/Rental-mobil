<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("location:../login.php");
    exit();
}
include "../koneksi.php";

// Memproses data form saat tombol edit ditekan
if (isset($_POST['edit'])) {
    $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jk = mysqli_real_escape_string($koneksi, $_POST['jk']);
    $telp = mysqli_real_escape_string($koneksi, $_POST['telp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $user = mysqli_real_escape_string($koneksi, $_POST['user']);

    $query = "UPDATE member SET nama='$nama', jk='$jk', telp='$telp', alamat='$alamat', user='$user' WHERE nik='$nik'";
    mysqli_query($koneksi, $query);
    header("location:kelolauser.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    include "../navbar.php";
    ?>
    <?php
    if (isset($_GET['nik'])) {
        $nik = $_GET['nik'];
        $query = "SELECT * FROM member WHERE nik='$nik'";
        $result = mysqli_query($koneksi, $query);
        $row = mysqli_fetch_assoc($result);
    
    ?>
    <div class="flex justify-center items-center h-screen bg-gray-100">
        <div class="bg-white p-4 md:p-8 rounded-lg shadow-md md:max-w-md">
            <h2 class="text-2xl font-bold mb-4">Edit User</h2>
            <form action="" method="POST">
                <div class="mb-4">
                    <label class="block mb-2">NIK</label>
                    <input type="text" name="nik" id="nik" class="w-full p-2 border border-gray-300 rounded-md" value="<?php echo $row['nik']; ?>" readonly>
                </div>
                <div class="mb-4">
                    <label class="block mb-2">Nama</label>
                    <input type="text" name="nama" id="nama" class="w-full p-2 border border-gray-300 rounded-md" value="<?php echo $row['nama']; ?>">
                </div>
                <div class="mb-4">
                    <label class="block mb-2">Jenis Kelamin</label>
                    <select name="jk" id="jk" class="w-full p-2 border border-gray-300 rounded-md">
                        <option value="L" <?php if ($row['jk'] == 'L') echo 'selected'; ?>>Laki-laki</option>
                        <option value="P" <?php if ($row['jk'] == 'P') echo 'selected'; ?>>Perempuan</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-2">Telepon</label>
                    <input type="text" name="telp" id="telp" class="w-full p-2 border border-gray-300 rounded-md" value="<?php echo $row['telp']; ?>">
                </div>
                <div class="mb-4">
                    <label class="block mb-2">Alamat</label>
                    <textarea name="alamat" id="alamat" class="w-full p-2 border border-gray-300 rounded-md"><?php echo $row['alamat']; ?></textarea>
                </div>
                <div class="mb-4">
                    <label class="block mb-2">Username</label>
                    <input type="text" name="user" id="user" class="w-full p-2 border border-gray-300 rounded-md" value="<?php echo $row['user']; ?>">
                </div>
                <div class="flex space-x-2">
                    <button type="submit" name="edit" class="w-1/2 p-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</button>
                    <a href="kelolauser.php" class="w-1/2 p-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md text-center">Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <?php
    } else {
        echo "Data tidak ditemukan.";
    }

    ?>
