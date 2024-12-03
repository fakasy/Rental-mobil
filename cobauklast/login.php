<?php
session_start();

include "koneksi.php"; // Database connection

if (isset($_SESSION['userId'])) {
    header("location:index.php"); // Redirect if already logged in
    exit();
}

if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($koneksi, $_POST['user']);
    $password = $_POST['password'];

    // Check if the user is in the admin table
    $queryAdmin = "SELECT * FROM user WHERE user='$user'";
    $resultAdmin = mysqli_query($koneksi, $queryAdmin);
    $rowsAdmin = mysqli_num_rows($resultAdmin);

    if ($rowsAdmin > 0) {
        $dataAdmin = mysqli_fetch_assoc($resultAdmin);

        // Verify admin password
        if (password_verify($password, $dataAdmin['password'])) {
            $_SESSION['userId'] = $dataAdmin['userId'];
            $_SESSION['user'] = $dataAdmin['user'];
            $_SESSION['lvl'] = $dataAdmin['lvl'];

            // Redirect based on admin level
            if ($dataAdmin['lvl'] === 'admin') {
                header("location:adminpetugas/index.php");
            } else if ($dataAdmin['lvl'] === 'petugas') {
                header("location:adminpetugas/index.php");
            }
        } else {
            echo "<script>alert('Incorrect username or password!');</script>";
        }
    } else {
        // If not found in admin, check in the member table
        $queryMember = "SELECT * FROM member WHERE user='$user'";
        $resultMember = mysqli_query($koneksi, $queryMember);
        $rowsMember = mysqli_num_rows($resultMember);

        if ($rowsMember > 0) {
            $dataMember = mysqli_fetch_assoc($resultMember);

            // Verify member password
            if (password_verify($password, $dataMember['password'])) {
                $_SESSION['nik'] = $dataMember['nik']; // Store NIK for member
                $_SESSION['nama'] = $dataMember['nama'];
                $_SESSION['user'] = $dataMember['user'];

                // Redirect to the member page
                header("location:member/index.php");
            } else {
                echo "<script>alert('Incorrect username or password!');</script>";
            }
        } else {
            echo "<script>alert('Incorrect username or password!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-bold text-center mb-12">Login</h2>
        <form action="" method="post">
            <div class="flex flex-col space-y-4">
                <label for="user">Username</label>
                <input type="text" name="user" id="user" class="w-full p-3 border border-gray-300 rounded-md" required>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="w-full p-3 border border-gray-300 rounded-md" required>
                <button type="submit" name="login" class="w-full p-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Login</button>
            </div>
            <p class="text-center mt-4">
                Belum punya akun? <a href="register.php" class="text-blue-500 hover:text-blue-700">Daftar disini</a>
            </p>
        </form>
    </div>
</body>

</html>
