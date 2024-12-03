<?php
include "../koneksi.php";
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['nik'])) {
    echo "<script>alert('Anda belum login. Silakan login terlebih dahulu.'); window.location.href='login.php';</script>";
    exit();
}

// Ambil harga mobil berdasarkan nopol
$harga_awal = 0;
if (isset($_GET['id'])) {
    $nopol = $_GET['id'];
    $mobilQuery = "SELECT harga FROM mobil WHERE nopol='$nopol'";
    $mobilResult = mysqli_query($koneksi, $mobilQuery);
    $mobilData = mysqli_fetch_assoc($mobilResult);
    $harga_awal = $mobilData['harga'];
}

// Memproses data form saat tombol rent ditekan
if (isset($_POST['rent'])) {
    $transaksiId = ['transaksiId'];
    $nik = $_SESSION['nik'];
    $tgl_booking = date('Y-m-d');  // Tanggal booking otomatis hari ini
    $tgl_ambil = $_POST['tgl_ambil'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $supir = $_POST['supir'];
    $downpayment = $_POST['downpayment'];

    // Hitung selisih hari dan harga total
    $date1 = new DateTime($tgl_ambil);
    $date2 = new DateTime($tgl_kembali);
    $selisih_hari = $date2->diff($date1)->days;
    $harga_total = $harga_awal * pow(2, $selisih_hari); // Harga total berkali lipat setiap hari

    // Hitung kekurangan
    $kekurangan = $harga_total - $downpayment;

    // Check if NIK exists in database
    $checkQuery = "SELECT * FROM member WHERE nik='$nik'";
    $checkResult = mysqli_query($koneksi, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Insert transaksi
        $query = "INSERT INTO transaksi (transaksiId, nik, nopol, tgl_booking, tgl_ambil, tgl_kembali, supir, total, downpayment, kekurangan) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, 'ssssssssss', $transaksiId, $nik, $nopol, $tgl_booking, $tgl_ambil, $tgl_kembali, $supir, $harga_total, $downpayment, $kekurangan);
        mysqli_stmt_execute($stmt);

        // Update status mobil menjadi 'tidak'
        $updateMobilQuery = "UPDATE mobil SET status='tidak' WHERE nopol='$nopol'";
        mysqli_query($koneksi, $updateMobilQuery);

        header("Location: booked.php");
    } else {
        echo "<script>alert('NIK tidak ditemukan di database! Silakan periksa data atau hubungi admin.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentACar</title>
    <script>
        // Function to update total and kekurangan in real time
        function updateTotalAndKekurangan() {
            const hargaAwal = parseFloat(document.getElementById('harga_awal').value);
            const tglAmbil = new Date(document.getElementById('tgl_ambil').value);
            const tglKembali = new Date(document.getElementById('tgl_kembali').value);
            const downpayment = parseFloat(document.getElementById('downpayment').value) || 0;
            const selisihHari = Math.floor((tglKembali - tglAmbil) / (1000 * 60 * 60 * 24));

            if (selisihHari >= 0) {
                const hargaTotal = hargaAwal * Math.pow(2, selisihHari);
                document.getElementById('total').value = hargaTotal.toFixed(2);
                const kekurangan = hargaTotal - downpayment;
                document.getElementById('kekurangan').value = kekurangan.toFixed(2);

                // Validasi input downpayment tidak lebih dari kekurangan
                if (downpayment > kekurangan) {
                    alert('Downpayment tidak boleh lebih besar dari kekurangan.');
                    document.getElementById('downpayment').value = kekurangan.toFixed(2);
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <?php include "../navbar.php"; ?>
    
    <div class="min-h-screen py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Rental Mobil</h2>
                <p class="text-gray-600 mt-2">Silakan isi form pemesanan di bawah ini</p>
            </div>

            <form action="" method="post" class="space-y-6">
                <input type="hidden" name="transaksiId">
                <input type="hidden" name="nopol" value="<?php echo $_GET['id']; ?>">
                <input type="hidden" id="harga_awal" value="<?php echo $harga_awal; ?>">

                <!-- Form Grid Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tanggal Booking -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label for="tgl_booking" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Booking
                        </label>
                        <input type="date" 
                               name="tgl_booking" 
                               id="tgl_booking" 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" 
                               value="<?php echo date('Y-m-d'); ?>" 
                               readonly>
                    </div>

                    <!-- Tanggal Ambil -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label for="tgl_ambil" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Ambil
                        </label>
                        <input type="date" 
                               name="tgl_ambil" 
                               id="tgl_ambil" 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" 
                               onchange="updateTotalAndKekurangan()" 
                               required>
                    </div>

                    <!-- Tanggal Kembali -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label for="tgl_kembali" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Kembali
                        </label>
                        <input type="date" 
                               name="tgl_kembali" 
                               id="tgl_kembali" 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" 
                               onchange="updateTotalAndKekurangan()" 
                               required>
                    </div>

                    <!-- Supir -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label for="supir" class="block text-sm font-medium text-gray-700 mb-2">
                            Supir
                        </label>
                        <select name="supir" 
                                id="supir" 
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                </div>

                <!-- Payment Section -->
                <div class="mt-8 bg-gray-50 p-6 rounded-lg space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Pembayaran</h3>
                    
                    <!-- Total -->
                    <div>
                        <label for="total" class="block text-sm font-medium text-gray-700 mb-2">
                            Total Biaya
                        </label>
                        <input type="number" 
                               name="total" 
                               id="total" 
                               class="w-full p-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" 
                               readonly>
                    </div>

                    <!-- Downpayment -->
                    <div>
                        <label for="downpayment" class="block text-sm font-medium text-gray-700 mb-2">
                            Uang Muka (DP)
                        </label>
                        <input type="number" 
                               name="downpayment" 
                               id="downpayment" 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" 
                               oninput="updateTotalAndKekurangan()" 
                               required>
                    </div>

                    <!-- Kekurangan -->
                    <div>
                        <label for="kekurangan" class="block text-sm font-medium text-gray-700 mb-2">
                            Sisa Pembayaran
                        </label>
                        <input type="number" 
                               name="kekurangan" 
                               id="kekurangan" 
                               class="w-full p-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" 
                               readonly>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center mt-8">
                    <button type="submit" 
                            name="rent" 
                            class="px-8 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all transform hover:scale-105">
                        Sewa Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
</html>

