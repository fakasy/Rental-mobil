<?php
include "../koneksi.php";

session_start();

if (!isset($_SESSION['nik'])) {
    header("location:../login.php");
}
$query = "SELECT nopol, brand, type, tahun, harga, foto, status FROM mobil WHERE status='tersedia'";
$result = mysqli_query($koneksi, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentACar - Member</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine.js"></script>
    <style>
        .car-card {
            transition: all 0.3s ease;
        }
        .car-card:hover {
            transform: translateY(-5px);
        }
        .car-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: all 0.3s ease;
        }
        .car-image:hover {
            opacity: 0.9;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .price-tag {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <?php include "../navbar.php"; ?>

    <!-- Hero Section -->
    <div class="gradient-bg py-16 text-white">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-center mb-4">Find Your Perfect Ride</h1>
            <p class="text-xl text-center text-gray-200">Choose from our premium selection of vehicles</p>
        </div>
    </div>

    <!-- Cars Grid Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="car-card bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="relative">
                        <img 
                            src="../foto/<?php echo $row['foto']; ?>" 
                            alt="<?php echo $row['brand']; ?>" 
                            class="car-image"
                        >
                        <div class="price-tag absolute top-4 right-4 text-white px-4 py-2 rounded-full">
                            <span class="font-bold"><?php echo $row['harga']; ?></span>/day
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">
                                    <?php echo $row['brand']; ?> <?php echo $row['type']; ?>
                                </h3>
                                <p class="text-gray-600">Year: <?php echo $row['tahun']; ?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center space-x-2">
                                <span class="inline-block px-2 py-1 text-sm bg-green-100 text-green-800 rounded-full">Available</span>
                            </div>
                            <a 
                                href="rent.php?id=<?php echo $row['nopol']; ?>" 
                                class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200"
                            >
                                Rent Now
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
</body>
</html>
