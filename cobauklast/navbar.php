
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<?php 
include "../koneksi.php";
if (isset($_SESSION['userId'])) {
?>
    <header class="fixed w-full bg-gradient-to-r from-gray-900 to-black shadow-lg z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="index.php" class="flex items-center space-x-2">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-2xl font-bold text-white">RentACar</span>
                </a>

                <!-- Navigation -->
                <nav class="hidden md:flex space-x-1">
                    <a href="index.php" class="px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-lg transition duration-150 ease-in-out">
                        Panel
                    </a>
                    <a href="laporan.php" class="px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-lg transition duration-150 ease-in-out">
                        Laporan
                    </a>
                    <a href="listbayar.php" class="px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-lg transition duration-150 ease-in-out">
                        Pembayaran
                    </a>
                    <a href="#" class="px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-lg transition duration-150 ease-in-out">
                        Kontak
                    </a>
                </nav>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <a href="../logout.php" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </header>
<?php
} else {
?>
    <header class="fixed w-full bg-gradient-to-r from-gray-900 to-black shadow-lg z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="index.php" class="flex items-center space-x-2">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-2xl font-bold text-white">RentACar</span>
                </a>

                <!-- Navigation -->
                <nav class="hidden md:flex space-x-1">
                    <a href="index.php" class="px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-lg transition duration-150 ease-in-out">
                        Beranda
                    </a>
                    <a href="booked.php" class="px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-lg transition duration-150 ease-in-out">
                        Pemesanan
                    </a>
                    <a href="#" class="px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-lg transition duration-150 ease-in-out">
                        Tentang Kami
                    </a>
                    <a href="#" class="px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-lg transition duration-150 ease-in-out">
                        Kontak
                    </a>
                </nav>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <a href="../logout.php" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </header>
<?php
}
?>

<!-- Spacer untuk fixed header -->
<div class="h-16"></div>