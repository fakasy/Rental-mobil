<?php include "../koneksi.php";

if (isset($_GET['transaksiId'])) {
    $id = $_GET['transaksiId'];

    // Update status mobil terlebih dahulu
    mysqli_query($koneksi, "UPDATE mobil SET status='tersedia' WHERE nopol IN (SELECT nopol FROM transaksi WHERE transaksiId='$id')");

    // Hapus transaksi
    mysqli_query($koneksi, "DELETE FROM transaksi WHERE transaksiId='$id'");

    header("Location: kelolatransaksi.php");
    exit();
}
