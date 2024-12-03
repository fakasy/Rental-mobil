<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("location:../login.php");
    exit();
}
// Memproses data form saat tombol edit ditekan
if (isset($_POST['edit'])) {
    $nopol = $_POST['nopol'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $tahun = $_POST['tahun'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];



    // Menangani upload foto jika ada
    $foto = $_FILES['foto']['name'];
    $tmpName = $_FILES['foto']['tmp_name'];
    $uploadDir = "../foto/";

    if (!empty($foto)) {
        $allowed = array('png', 'jpg', 'jpeg');
        $ext = pathinfo($foto, PATHINFO_EXTENSION);

        if (in_array($ext, $allowed)) {
            // Upload file
            move_uploaded_file($tmpName, $uploadDir . $foto);
            // Update data mobil dengan foto baru
            $query = "UPDATE mobil SET brand=?, type=?, tahun=?, harga=?, status=?, foto=? WHERE nopol=?";
            $stmt = mysqli_stmt_init($koneksi);
            if (!mysqli_stmt_prepare($stmt, $query)) {
                echo "Gagal update data: " . mysqli_error($koneksi);
            } else {
                mysqli_stmt_bind_param($stmt, 'sssssss', $brand, $type, $tahun, $harga, $status, $foto, $nopol);
                if (!mysqli_stmt_execute($stmt)) {
                    echo "Gagal update data: " . mysqli_error($koneksi);
                }
                mysqli_stmt_close($stmt);
                header("Location: kelolamobil.php");
                exit();
            }
        } else {
            echo "<script>alert('Format foto tidak diperbolehkan!');</script>";
        }
    } else {
        // Update data mobil tanpa mengubah foto
        $query = "UPDATE mobil SET brand=?, type=?, tahun=?, harga=?, status=? WHERE nopol=?";
        $stmt = mysqli_stmt_init($koneksi);
        if (!mysqli_stmt_prepare($stmt, $query)) {
            echo "Gagal update data: " . mysqli_error($koneksi);
        } else {
            mysqli_stmt_bind_param($stmt, 'ssssss', $brand, $type, $tahun, $harga, $status, $nopol);
            if (!mysqli_stmt_execute($stmt)) {
                echo "Gagal update data: " . mysqli_error($koneksi);
            }
            mysqli_stmt_close($stmt);
            header("Location: kelolamobil.php");
            exit();
        }
    }
}


// Mengambil data mobil berdasarkan nopol
if (isset($_GET['id'])) {
    $nopol = $_GET['id'];
    $query = "SELECT * FROM mobil WHERE nopol=?";
    $stmt = mysqli_stmt_init($koneksi);
    if (!mysqli_stmt_prepare($stmt, $query)) {
        echo "Gagal mengambil data: " . mysqli_error($koneksi);
    } else {
        mysqli_stmt_bind_param($stmt, 's', $nopol);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mobil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body>
    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-bold text-center mb-12">Edit Mobil</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="flex flex-col space-y-4">
            <label for="nopol">Nopol</label>
            <input type="text" name="nopol" id="nopol" value="<?php echo $row['nopol']; ?>" class="w-full p-3 border border-gray-300 rounded-md" readonly>

            <label for="brand">Brand</label>
            <input type="text" name="brand" id="brand" value="<?php echo $row['brand']; ?>" class="w-full p-3 border border-gray-300 rounded-md" required>

            <label for="type">Type</label>
            <input type="text" name="type" id="type" value="<?php echo $row['type']; ?>" class="w-full p-3 border border-gray-300 rounded-md" required>

            <label for="tahun">Tahun</label>
            <input type="date" name="tahun" id="tahun" value="<?php echo $row['tahun']; ?>" class="w-full p-3 border border-gray-300 rounded-md" required>

            <label for="harga">Harga</label>
            <input type="number" name="harga" id="harga" value="<?php echo $row['harga']; ?>" step="0.01" class="w-full p-3 border border-gray-300 rounded-md" required>

            <label for="foto">Foto (optional)</label>
            <input type="file" name="foto" id="foto" accept=".png,.jpg,.jpeg" class="w-full p-3 border border-gray-300 rounded-md">

            <label for="status">Status</label>
            <select name="status" id="status" class="w-full p-3 border border-gray-300 rounded-md" required>
                <option value="tersedia" <?php if ($row['status'] == 'tersedia') echo 'selected'; ?>>Tersedia</option>
                <option value="tidak" <?php if ($row['status'] == 'tidak') echo 'selected'; ?>>Tidak Tersedia</option>
            </select>

            </div>
            <div class="flex space-x-2">
                <button type="submit" name="edit" class="w-1/2 p-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</button>
                <a href="kelolamobil.php" class="w-1/2 p-3 bg-gray-500 hover:bg-gray-600 text-white rounded-md text-center">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>

