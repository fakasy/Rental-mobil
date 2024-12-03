<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("location:../login.php");
    exit();
}

// Mengambil data transaksi untuk masing-masing status
    $queryPending = "SELECT t.transaksiId, t.nopol, t.tgl_booking, t.tgl_ambil, t.tgl_kembali, t.status, m.nama 
                    FROM transaksi t 
                    JOIN member m ON t.nik = m.nik
                    WHERE t.status = 'booking'";
    $resultPending = mysqli_query($koneksi, $queryPending);

    $queryAmbil = "SELECT t.transaksiId, t.nopol, t.tgl_booking, t.tgl_ambil, t.tgl_kembali, t.status, m.nama 
                FROM transaksi t 
                JOIN member m ON t.nik = m.nik
                WHERE t.status = 'approve'";
    $resultAmbil = mysqli_query($koneksi, $queryAmbil);

    $queryKembali = "SELECT t.transaksiId, t.nopol, t.tgl_booking, t.tgl_ambil, t.tgl_kembali, t.status, m.nama 
                    FROM transaksi t 
                    JOIN member m ON t.nik = m.nik
                    WHERE t.status = 'ambil'";
    $resultKembali = mysqli_query($koneksi, $queryKembali);

// Menangani error jika query gagal
if (!$resultPending || !$resultAmbil || !$resultKembali) {
    echo "Gagal mengambil data: " . mysqli_error($koneksi);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Transaksi Rental</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/datepicker.min.js"></script>
</head>
<body class="bg-gray-50">
    <?php include "../navbar.php"; ?>
    
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Manajemen Transaksi</h1>
            <p class="text-gray-600">Kelola semua transaksi rental kendaraan</p>
        </div>

        <!-- Filter Buttons -->
        <div class="flex flex-wrap gap-4 mb-8">
            <button onclick="showPending()" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Pending
            </button>
            
            <button onclick="showAmbil()" class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Ambil
            </button>
            
            <button onclick="showKembali()" class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3"></path>
                </svg>
                Kembali
            </button>
        </div>

        <!-- Tables Container with Shadow and Rounded Corners -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Table Pending -->
            <div id="tablePending" class="hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="hidden">ID Transaksi</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nopol</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Booking</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Ambil</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Kembali</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $i = 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($resultPending)) : ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $i; ?></td>
                                <td class="hidden"><?= $row["transaksiId"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $row["nopol"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $row["nama"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $row["tgl_booking"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $row["tgl_ambil"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $row["tgl_kembali"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <?= $row["status"]; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="approve.php?transaksiId=<?= $row["transaksiId"] ?>" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            Approve
                                        </a>
                                        <a href="reject.php?transaksiId=<?= $row["transaksiId"] ?>" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Reject
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php $i++; ?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Table Ambil -->
            <div id="tableAmbil" class="hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="hidden">ID Transaksi</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nopol</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Booking</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Ambil</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Kembali</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $i = 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($resultAmbil)) : ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $i; ?></td>
                                <td class="hidden"><?= $row["transaksiId"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $row["nopol"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $row["nama"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $row["tgl_booking"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $row["tgl_ambil"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $row["tgl_kembali"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <?= $row["status"]; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="ambil.php?transaksiId=<?= $row["transaksiId"] ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Ambil
                                    </a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Table Kembali -->
            <div id="tableKembali" class="hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="hidden">ID Transaksi</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nopol</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Booking</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Ambil</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Kembali</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $i = 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($resultKembali)) : ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $i; ?></td>
                                <td class="hidden"><?= $row["transaksiId"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $row["nopol"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $row["nama"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $row["tgl_booking"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $row["tgl_ambil"]; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $row["tgl_kembali"]; ?></td>
       <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <?= $row["status"]; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="kembali.php?transaksiId=<?= $row["transaksiId"] ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Kembali
                                    </a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for toggling table visibility -->
    <script>
        function showPending() {
            document.getElementById('tablePending').classList.remove('hidden');
            document.getElementById('tableAmbil').classList.add('hidden');
            document.getElementById('tableKembali').classList.add('hidden');
        }

        function showAmbil() {
            document.getElementById('tablePending').classList.add('hidden');
            document.getElementById('tableAmbil').classList.remove('hidden');
            document.getElementById('tableKembali').classList.add('hidden');
        }

        function showKembali() {
            document.getElementById('tablePending').classList.add('hidden');
            document.getElementById('tableAmbil').classList.add('hidden');
            document.getElementById('tableKembali').classList.remove('hidden');
        }
    </script>
</body>
</html>
