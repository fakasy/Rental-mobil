<?php 
    include "../koneksi.php";

    if (isset($_GET['transaksiId'])) {
        $id = $_GET['transaksiId'];

        // Update status transaksi menjadi 'approved'
        mysqli_query($koneksi, "UPDATE transaksi SET status='ambil' WHERE transaksiId='$id'");


        header("Location: kelolatransaksi.php");
    }