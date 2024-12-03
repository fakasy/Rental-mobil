<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("location:../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <?php include("../navbar.php"); ?>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Laporan Transaksi</h1>
            <p class="mt-2 text-sm text-gray-600">Overview transaksi rental mobil</p>
        </div>

        <!-- Export Form -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Export Data</h2>
            <form method="GET" action="export.php" onsubmit="return validateDate()" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div>
                    <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export Excel
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nopol</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Booking</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Ambil</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Bayar</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        $query = "SELECT t.transaksiId, t.nopol, t.tgl_booking, t.tgl_ambil, t.tgl_kembali, 
                                        COALESCE(b.total_bayar, 0) as total_bayar,
                                        t.status 
                                FROM transaksi t 
                                LEFT JOIN bayar b ON t.transaksiId = t.transaksiId";
                        $result = mysqli_query($koneksi, $query);
                        
                        if (!$result) {
                            echo '<tr><td colspan="7" class="px-6 py-4 text-center text-sm text-red-500">Error: ' . mysqli_error($koneksi) . '</td></tr>';
                        }
                        
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr class='hover:bg-gray-50'>";
                            echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . $no++ . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'>" . $row['nopol'] . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . date('d/m/Y', strtotime($row['tgl_booking'])) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . date('d/m/Y', strtotime($row['tgl_ambil'])) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . date('d/m/Y', strtotime($row['tgl_kembali'])) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>Rp " . number_format($row['total_bayar'], 0, ',', '.') . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>
                                    <span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full " . 
                                    ($row['status'] == 'Selesai' ? 'bg-green-100 text-green-800' : 
                                    ($row['status'] == 'Proses' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) . "'>
                                        " . $row['status'] . "
                                    </span>
                                </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function validateDate() {
            var startDate = document.getElementById("start_date").value;
            var endDate = document.getElementById("end_date").value;
            
            if (startDate == "" || endDate == "") {
                alert("Silakan pilih tanggal awal dan akhir");
                return false;
            }
            
            if (new Date(startDate) > new Date(endDate)) {
                alert("Tanggal awal tidak boleh lebih besar dari tanggal akhir");
                return false;
            }
            
            return true;
        }
    </script>
</body>
</html>
