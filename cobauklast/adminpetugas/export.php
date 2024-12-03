<?php
// export.php
include "../koneksi.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("location:../login.php");
    exit();
}

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Transaksi_" . date('Y-m-d') . ".xls");

// Query untuk mengambil data transaksi dan pembayaran
$query = "SELECT t.transaksiId, t.nopol, t.tgl_booking, t.tgl_ambil, t.tgl_kembali, 
                    COALESCE(b.total_bayar, 0) as total_bayar,
                    t.status 
            FROM transaksi t 
            LEFT JOIN bayar b ON t.transaksiId = t.transaksiId";

// Tambahkan filter tanggal jika ada
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $query .= " WHERE t.tgl_booking BETWEEN '$start_date' AND '$end_date'";
}

$result = mysqli_query($koneksi, $query);

// CSS untuk styling Excel
echo '<style>
    .header { font-weight: bold; background-color: #f0f0f0; }
    .total { font-weight: bold; background-color: #e0e0e0; }
    td, th { padding: 5px; }
</style>';
?>

<table border="1">
    <tr class="header">
        <th colspan="7" style="text-align: center; font-size: 16pt; height: 30px;">
            LAPORAN TRANSAKSI RENTAL MOBIL
        </th>
    </tr>
    <tr>
        <th colspan="7" style="text-align: center; font-size: 11pt;">
            Tanggal: <?php echo date('d-m-Y'); ?>
        </th>
    </tr>
    <tr></tr> 
    <tr class="header">
        <th>No</th>
        <th>Nopol</th>
        <th>Tanggal Booking</th>
        <th>Tanggal Ambil</th>
        <th>Tanggal Kembali</th>
        <th>Total Bayar</th>
        <th>Status</th>
    </tr>

    <?php
    $no = 1;
    $total_keseluruhan = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $total_keseluruhan += $row['total_bayar'];
    ?>
        <tr>
            <td style="text-align: center;"><?php echo $no++; ?></td>
            <td><?php echo $row['nopol']; ?></td>
            <td style="text-align: center;"><?php echo date('d/m/Y', strtotime($row['tgl_booking'])); ?></td>
            <td style="text-align: center;"><?php echo date('d/m/Y', strtotime($row['tgl_ambil'])); ?></td>
            <td style="text-align: center;"><?php echo date('d/m/Y', strtotime($row['tgl_kembali'])); ?></td>
            <td style="text-align: right;">Rp. <?php echo number_format($row['total_bayar'], 0, ',', '.'); ?></td>
            <td style="text-align: center;"><?php echo $row['status']; ?></td>
        </tr>
    <?php
    }
    ?>

    <tr class="total">
        <td colspan="5" style="text-align: right;">Total Keseluruhan:</td>
        <td style="text-align: right;">Rp. <?php echo number_format($total_keseluruhan, 0, ',', '.'); ?></td>
        <td></td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="7" style="text-align: left; font-size: 11pt;">
            Dicetak pada: <?php echo date('d/m/Y H:i:s'); ?>
        </td>
    </tr>
</table>