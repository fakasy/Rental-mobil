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
    <title>RentACar - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 text-gray-900 min-h-screen">
    <?php include "../navbar.php"; ?>
    
    <section class="py-20 px-4">
        <div class="container mx-auto max-w-6xl">
            <!-- Header Section -->
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Panel Admin</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Selamat datang di panel administrasi. Kelola semua aspek sistem dari satu tempat.</p>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Kelola Mobil Card -->
                <a href="kelolamobil.php" class="group">
                    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                        <div class="mb-6 text-blue-500 bg-blue-50 w-14 h-14 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-car text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Kelola Mobil</h3>
                        <p class="text-gray-600">Tambah, edit, dan kelola inventaris mobil yang tersedia untuk disewa.</p>
                        <div class="mt-4 flex items-center text-blue-500 font-medium">
                            <span>Kelola sekarang</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform duration-300"></i>
                        </div>
                    </div>
                </a>

                <!-- Kelola User Card -->
                <a href="kelolauser.php" class="group">
                    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                        <div class="mb-6 text-green-500 bg-green-50 w-14 h-14 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Kelola User</h3>
                        <p class="text-gray-600">Atur dan kelola akun pengguna, hak akses, dan informasi pelanggan.</p>
                        <div class="mt-4 flex items-center text-green-500 font-medium">
                            <span>Kelola sekarang</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform duration-300"></i>
                        </div>
                    </div>
                </a>

                <!-- Kelola Transaksi Card -->
                <a href="kelolatransaksi.php" class="group">
                    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                        <div class="mb-6 text-purple-500 bg-purple-50 w-14 h-14 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-receipt text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Kelola Transaksi</h3>
                        <p class="text-gray-600">Pantau dan kelola semua transaksi penyewaan mobil yang berlangsung.</p>
                        <div class="mt-4 flex items-center text-purple-500 font-medium">
                            <span>Kelola sekarang</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform duration-300"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
</body>
</html>
</html>
