<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("location:../login.php");
    exit();
}

// Cek apakah transaksiId tersedia
if (isset($_GET['transaksiId'])) {
    $transaksiId = $_GET['transaksiId'];
} else {
    die("Transaksi ID tidak ditemukan!");
}

// Ambil data dari tabel transaksi
$query = "SELECT * FROM transaksi WHERE transaksiId='$transaksiId'";
$result = mysqli_query($koneksi, $query);
if (!$result) {
    die("Error executing query: " . mysqli_error($koneksi));
}
$dataTransaksi = mysqli_fetch_assoc($result);

// Ambil data mobil terkait berdasarkan nopol dari transaksi
$nopol = $dataTransaksi['nopol'];
$query = "SELECT * FROM mobil WHERE nopol='$nopol'";
$result = mysqli_query($koneksi, $query);
$dataMobil = mysqli_fetch_assoc($result);
$hargaMobil = $dataMobil['harga'];

// Proses pengembalian (form submit)
if (isset($_POST['kembali'])) {
    $kondisiMobil = $_POST['kondisi_mobil'];
    $biayaTambahan = $_POST['biaya_tambahan'];
    $tglKembali = $_POST['tgl_kembali'];
    $tglKembaliAwal = $dataTransaksi['tgl_kembali'];
    
    $denda = 0;
    if (new DateTime($tglKembali) > new DateTime($tglKembaliAwal)) {
        $diff = (new DateTime($tglKembali))->diff(new DateTime($tglKembaliAwal))->days;
        $denda = $hargaMobil * $diff;
    }
    $denda += $biayaTambahan;

    // Masukkan data ke tabel kembali
    $query = "INSERT INTO kembali (transaksiId, tgl_kembali, kondisimobil, denda) VALUES ('$transaksiId', '$tglKembali', '$kondisiMobil', '$denda')";
    mysqli_query($koneksi, $query);
    
    // Update status transaksi jadi 'kembali'
    mysqli_query($koneksi, "UPDATE transaksi SET status='kembali' WHERE transaksiId='$transaksiId'");

    // Terakhir, update status mobil jadi 'tersedia'
    $updateMobilQuery = "UPDATE mobil SET status='tersedia' WHERE nopol='$nopol'";
    mysqli_query($koneksi, $updateMobilQuery);

    header("Location: kelolatransaksi.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Mobil</title>

</head>
<body>
    
    <?php include "../navbar.php"; ?>
    <div class="min-h-screen w-1/2 mx-auto bg-white-100 flex items-center justify-center">
    <form action="" method="post" class="bg-white w-full shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <input type="hidden" name="transaksiId" value="<?php echo $transaksiId; ?> ?>">
        <div class="mb-4">
            <label for="tgl_kembali" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kembali</label>
            <input type="date" name="tgl_kembali" id="tgl_kembali" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" value="<?php echo date('Y-m-d'); ?>" required onchange="updateDenda()">
        </div>

        <div class="mb-4">
            <label for="kondisi_mobil" class="block text-gray-700 text-sm font-bold mb-2">Kondisi Mobil</label>
            <input type="text" name="kondisi_mobil" id="kondisi_mobil" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
        </div>

        <div class="mb-4">
            <label for="biaya_tambahan" class="block text-gray-700 text-sm font-bold mb-2">Biaya Tambahan</label>
            <input type="number" name="biaya_tambahan" id="biaya_tambahan" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
        </div>

        <div class="mb-4">
            <label for="denda" class="block text-gray-700 text-sm font-bold mb-2">Denda</label>
            <input type="number" name="denda" id="denda" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" value="0" readonly>
        </div>

        <button type="submit" name="kembali" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline">
            Kembalikan
        </button>
    </form>

    <script>
        function updateDenda() {
            const tglKembali = document.getElementById('tgl_kembali').value;
            const tglKembaliAwal = new Date('<?php echo $dataTransaksi['tgl_kembali']; ?>');
            const denda = document.getElementById('denda');
            const hargaMobil = <?php echo $dataMobil['harga']; ?>;

            if (new Date(tglKembali) > tglKembaliAwal) {
                const diff = (new Date(tglKembali)).getTime() - tglKembaliAwal.getTime();
                const days = Math.ceil(diff / (1000 * 60 * 60 * 24));
                denda.value = hargaMobil * days;
            } else {
                denda.value = 0;
            }
        }
    </script>
</div>
</body>

</html>
