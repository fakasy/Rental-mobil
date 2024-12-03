<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("location:../login.php");
    exit();
}

$kembaliId = $_GET['kembaliId'] ?? ''; // Fetch kembaliId from GET or set as empty
$query = "SELECT * FROM kembali WHERE kembaliId = '$kembaliId'";
$result = mysqli_query($koneksi, $query);
$dataKembali = mysqli_fetch_assoc($result);

if (!$dataKembali) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='some_redirect_page.php';</script>";
    exit();
}

$transaksiId = $_GET['transaksiId'] ?? ''; // Fetch transaksiId from GET request

if (isset($_POST['bayar'])) {
    $bayarId = $_POST['bayarId'] ?? ''; // Add null coalescing operator as a fallback
    $tgl_bayar = $_POST['tgl_bayar'] ?? '';
    $total_bayar = $_POST['total_bayar'] ?? 0;
    $status = $_POST['status'] ?? 'Belum Lunas';

    if (!empty($kembaliId) && !empty($total_bayar)) {
        $query = "INSERT INTO bayar (kembaliId, tgl_bayar, total_bayar, status) VALUES ('$kembaliId', '$tgl_bayar', '$total_bayar', '$status')";
        if (mysqli_query($koneksi, $query)) {
            if ($status == 'Lunas') {
                // Update 'kekurangan' in 'transaksi' to 0
                $queryUpdate = "UPDATE transaksi SET kekurangan = 0 WHERE transaksiId = '$transaksiId'";
                mysqli_query($koneksi, $queryUpdate);
                
                // No longer delete from 'kembali' table
                echo "<script>alert('Pembayaran berhasil dan transaksi selesai!'); window.location.href='listbayar.php';</script>";
            } else {
                echo "<script>alert('Pembayaran belum lunas!');</script>";
            }
        } else {
            echo "<script>alert('Data pembayaran tidak lengkap!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                <h1 class="text-2xl font-bold text-white">Detail Transaksi</h1>
            </div>

            <!-- Content -->
            <div class="p-6">
                <?php
                    $query = "SELECT t.transaksiId, t.nopol, t.tgl_booking, t.tgl_ambil, t.tgl_kembali, t.status, m.nama, m.nik, m.telp, m.alamat, mo.harga, k.denda, t.kekurangan, t.downpayment, t.total
                    FROM transaksi t
                    JOIN member m ON t.nik = m.nik
                    JOIN mobil mo ON t.nopol = mo.nopol
                    JOIN kembali k ON t.transaksiId = k.transaksiId
                    WHERE k.kembaliId = '$kembaliId'";

                $result = mysqli_query($koneksi, $query);
                if (mysqli_num_rows($result) > 0) {
                    $dataTransaksi = mysqli_fetch_assoc($result);
                ?>
                    <!-- Info Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Customer Details -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Pelanggan</h2>
                            <div class="space-y-2">
                                <div class="flex">
                                    <span class="text-gray-600 w-32">Nama</span>
                                    <span class="text-gray-900 font-medium"><?= $dataTransaksi['nama']; ?></span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-600 w-32">NIK</span>
                                    <span class="text-gray-900 font-medium"><?= $dataTransaksi['nik']; ?></span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-600 w-32">Telepon</span>
                                    <span class="text-gray-900 font-medium"><?= $dataTransaksi['telp']; ?></span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-600 w-32">Alamat</span>
                                    <span class="text-gray-900 font-medium"><?= $dataTransaksi['alamat']; ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Transaction Details -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Detail Sewa</h2>
                            <div class="space-y-2">
                                <div class="flex">
                                    <span class="text-gray-600 w-32">No. Polisi</span>
                                    <span class="text-gray-900 font-medium"><?= $dataTransaksi['nopol']; ?></span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-600 w-32">Harga</span>
                                    <span class="text-gray-900 font-medium">Rp <?= number_format($dataTransaksi['harga'], 2, ',', '.'); ?></span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-600 w-32">Status</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        <?= $dataTransaksi['status'] === 'Lunas' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                        <?= $dataTransaksi['status']; ?>
                                    </span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-600 w-32">Denda</span>
                                    <span class="text-gray-900 font-medium">Rp <?= number_format($dataTransaksi['denda'], 2, ',', '.'); ?></span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-600 w-32">Downpayment</span>
                                    <span class="text-gray-900 font-medium">Rp <?= number_format($dataTransaksi['downpayment'], 2, ',', '.'); ?></span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-600 w-32">Kekurangan</span>
                                    <span class="text-gray-900 font-medium">Rp <?= number_format($dataTransaksi['kekurangan'], 2, ',', '.'); ?></span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-600 w-32">Total</span>
                                    <span class="text-gray-900 font-medium">Rp <?= number_format($dataTransaksi['total'], 2, ',', '.'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dates Section -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-8">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Tanggal</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="p-4 bg-white rounded-lg shadow-sm">
                                <div class="text-sm text-gray-600">Tanggal Booking</div>
                                <div class="text-lg font-medium text-gray-900"><?= date('d-m-Y', strtotime($dataTransaksi['tgl_booking'])); ?></div>
                            </div>
                            <div class="p-4 bg-white rounded-lg shadow-sm">
                                <div class="text-sm text-gray-600">Tanggal Ambil</div>
                                <div class="text-lg font-medium text-gray-900"><?= date('d-m-Y', strtotime($dataTransaksi['tgl_ambil'])); ?></div>
                            </div>
                            <div class="p-4 bg-white rounded-lg shadow-sm">
                                <div class="text-sm text-gray-600">Tanggal Kembali</div>
                                <div class="text-lg font-medium text-gray-900"><?= date('d-m-Y', strtotime($dataTransaksi['tgl_kembali'])); ?></div>
                            </div>
                        </div>
                    </div>

                <?php
                } else {
                    echo "<div class='text-center py-8'><p class='text-red-600'>Data tidak ditemukan!</p></div>";
                }
                ?>

                <!-- Payment Form -->
                <form action="" method="post" class="space-y-6">
                    <input type="hidden" name="kembaliId" value="<?= $kembaliId; ?>">
                    <div>
                        <label for="tgl_bayar" class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
                        <input type="date" name="tgl_bayar" id="tgl_bayar" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="total_bayar" class="block text-sm font-medium text-gray-700">Total Pembayaran</label>
                        <input type="number" name="total_bayar" id="total_bayar" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                        <select name="status" id="status" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="Belum Lunas">Belum Lunas</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                    </div>
                    <button type="submit" name="bayar"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Proses
                        Pembayaran</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
