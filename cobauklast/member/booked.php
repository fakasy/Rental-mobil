<?php
    session_start();
    if (!isset($_SESSION['nik'])) {
        header("location:../login.php");
        exit();
    }
    include "../koneksi.php";

    // Fetch relevant transaction data for the logged-in user
    $query = "SELECT t.transaksiId, t.nopol, t.tgl_booking, t.tgl_ambil, t.tgl_kembali, t.status, m.brand, m.type, m.foto
                FROM transaksi t
                JOIN mobil m ON t.nopol = m.nopol
                WHERE t.nik = '{$_SESSION['nik']}'";
    $result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Saya</title>
    <head>
    
    </head>
    <body>
        <?php include "../navbar.php"; ?>
        <div class="container mx-auto p-4">
            <h2 class="text-3xl font-bold text-center my-4">Transaksi Saya</h2>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="flex items-center bg-white rounded-lg shadow-md p-4 mb-4">
                    <img src="../foto/<?php echo $row['foto']; ?>" alt="<?php echo $row['brand']; ?>" class="w-24 h-24 rounded-full mr-4">
                    <div class="flex-grow">
                        <h4 class="font-bold"><?php echo $row['brand'] . " " . $row['type']; ?></h4>
                        <p class="text-gray-600">Transaksi ID: <?php echo $row['transaksiId']; ?></p>
                        <p class="text-gray-600">Tanggal Ambil: <?php echo $row['tgl_ambil']; ?></p>
                        <p class="text-gray-600">Tanggal Kembali: <?php echo $row['tgl_kembali']; ?></p>
                    </div>
                    <div class="bg-<?php echo $row['status'] === 'success' ? 'green' : 'red'; ?>-500 text-white px-4 py-2 rounded-full">
                        <?php echo ucfirst($row['status']); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </body>
</html>

