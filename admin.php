<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Jika pengguna sudah login, konten halaman admin ditampilkan di bawah ini
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<aside class="flex flex-col w-64 h-screen px-4 py-8 bg-white border-r rtl:border-r-0 rtl:border-l dark:bg-gray-900 dark:border-gray-700">
    <a href="index.php">
        <img class="w-auto h-6 sm:h-7" src="https://merakiui.com/images/logo.svg" alt="">
    </a>

    <div class="flex flex-col justify-between flex-1 mt-6">
        <nav>
        <a class="flex items-center px-4 py-2 mb-2 text-gray-700 bg-gray-100 rounded-md dark:bg-gray-800 dark:text-gray-200" href="admin.php">

        <span class="mx-4 font-medium">Dashboard</span>
        </a>
        <a class="flex items-center px-4 py-2 text-gray-600 transition-colors duration-300 transform rounded-md dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200 hover:text-gray-700" href="artikel-admin.php">
                <span class="mx-4 font-medium">Artikel</span>
            </a>

            <hr class="my-6 border-gray-200 dark:border-gray-600" />

            <a class="flex items-center px-4 py-2 mt-5 text-gray-600 transition-colors duration-300 transform rounded-md dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200 hover:text-gray-700" href="logout.php">
                <span class="mx-4 font-medium">Logout</span>
            </a>
        </nav>

        <a href="#" class="flex items-center px-4 -mx-2">
            <span class="mx-2 font-medium text-gray-800 dark:text-gray-200">@<?=$_SESSION['username']?></span>
        </a>
    </div>
</aside>
</body>
</html>
