<?php
include("koneksi.php");

session_start();

if (isset($_SESSION['userId']))     
{
    header("location:adminpetugas/index.php");
    exit();
}
else if (isset($_SESSION['nik'])) {
    header("location:member/index.php");
    exit();
}



// Mengambil data mobil dari database
$query = "SELECT * FROM mobil"; // Query untuk mengambil semua data dari tabel mobil
$result = mysqli_query($koneksi, $query); // Menjalankan query

if (!$result) {
    die("Query Error: " . mysqli_error($koneksi)); // Menangani error jika query gagal
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-50">
    <!-- Navbar with glass effect -->
    <nav class="fixed w-full z-50 backdrop-blur-md bg-white/80 border-b border-gray-200">
        <div class="max-w-screen-xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <a href="#" class="flex items-center space-x-3">
                    <span class="text-2xl font-bold bg-gradient-to-r from-yellow-500 to-yellow-600 bg-clip-text text-transparent">RentACar</span>
                </a>
                <div class="hidden md:flex space-x-8">
                    <a href="#cars" class="text-gray-700 hover:text-yellow-500 transition-colors font-medium">Cars</a>
                    <a href="#about" class="text-gray-700 hover:text-yellow-500 transition-colors font-medium">About</a>
                    <a href="#contact" class="text-gray-700 hover:text-yellow-500 transition-colors font-medium">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="login.php" class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-full transition-all duration-300 font-medium">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with parallax effect -->
    <section class="relative min-h-screen flex items-center justify-center bg-fixed bg-cover bg-center" style="background-image: url('https://media.giphy.com/media/JGVWcMe3Klfb9IBxjw/giphy.gif');">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-6">Drive Your Dreams</h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-8">Premium Cars • Best Prices • 24/7 Support</p>
            <a href="#cars" class="inline-block px-8 py-4 bg-yellow-500 hover:bg-yellow-600 text-white rounded-full transition-all duration-300 transform hover:scale-105 font-medium text-lg">
                Explore Our Fleet
            </a>
        </div>
    </section>

    <!-- Search Section with floating card effect -->
    <section class="relative -mt-20 px-4 mb-24">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl p-8 transform hover:shadow-2xl transition-all duration-300">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Find Your Perfect Car</h2>
            <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Pick-up Date</label>
                    <input type="date" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Drop-off Date</label>
                    <input type="date" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
                </div>
                <button class="md:col-span-2 bg-yellow-500 hover:bg-yellow-600 text-white py-4 rounded-lg transition-all duration-300 transform hover:scale-105 font-medium">
                    Search Available Cars
                </button>
            </form>
        </div>
    </section>

    <!-- Cars Section with card hover effects -->
    <section id="cars" class="py-20 bg-gray-50 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Featured Vehicles</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300">
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="foto/<?php echo $row['foto']; ?>" alt="<?php echo $row['brand']; ?>" class="w-full h-48 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo $row['brand']; ?> <?php echo $row['type']; ?></h3>
                        <div class="flex items-center space-x-2 text-gray-600 mb-4">
                            <span class="text-sm"><?php echo $row['tahun']; ?></span>
                            <span>•</span>
                            <span class="text-sm"><?php echo $row['status']; ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-yellow-500">Rp <?php echo $row['harga']; ?></span>
                            <button class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-all duration-300">
                                Rent Now
                            </button>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- About Section with modern layout -->
    <section id="about" class="py-20 bg-white px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">About RentACar</h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        RentACar adalah layanan premium penyewaan mobil yang mengutamakan kenyamanan dan kepuasan pelanggan. Kami menyediakan berbagai pilihan kendaraan berkualitas dengan kondisi prima dan terawat.
                    </p>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Dengan pengalaman bertahun-tahun dalam industri, kami memahami kebutuhan pelanggan dan berkomitmen memberikan pelayanan terbaik dengan harga yang kompetitif.
                    </p>
                    <div class="flex space-x-4">
                        <span class="px-4 py-2 bg-gray-100 rounded-full text-gray-700">24/7 Support</span>
                        <span class="px-4 py-2 bg-gray-100 rounded-full text-gray-700">GPS Included</span>
                        <span class="px-4 py-2 bg-gray-100 rounded-full text-gray-700">Insurance</span>
                    </div>
                </div>
                <div class="relative">
                    <img src="https://media.giphy.com/media/l2JhJnsRNp9RdF0dO/giphy.gif" alt="About RentACar" class="rounded-2xl shadow-xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section with modern social icons -->
    <section id="contact" class="py-20 bg-gray-50 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-12">Connect With Us</h2>
            <div class="flex justify-center space-x-6">
                <a href="https://www.instagram.com/splize.zone/" target="_blank" rel="noopener noreferrer" class="transform hover:scale-110 transition-all duration-300">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e7/Instagram_logo_2016.svg/1200px-Instagram_logo_2016.svg.png" alt="Instagram" class="w-12 h-12">
                </a>
                <a href="https://www.tiktok.com/@spearlize" target="_blank" rel="noopener noreferrer" class="transform hover:scale-110 transition-all duration-300">
                    <img src="https://tse1.mm.bing.net/th?id=OIP.bOuv9CXDZsXaZUv7r8QRXQHaHa&pid=Api&P=0&h=220" alt="TikTok" class="w-12 h-12">
                </a>
            </div>
        </div>
    </section>
</body>
</html>

<?php mysqli_close($koneksi); // Menutup koneksi database ?>

