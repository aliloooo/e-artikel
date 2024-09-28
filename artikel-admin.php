<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Hubungkan ke database
require('koneksi.php');

// Query untuk mengambil data dari tabel artikel
$sql = "SELECT * FROM artikel";
$result = $koneksi->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex bg-gray-100">
<aside class="flex flex-col w-64 h-screen px-4 py-8 bg-white border-r rtl:border-r-0 rtl:border-l dark:bg-gray-900 dark:border-gray-700">
    <a href="index.php">
        <img class="w-auto h-6 sm:h-7" src="https://merakiui.com/images/logo.svg" alt="">
    </a>

    <div class="flex flex-col justify-between flex-1 mt-6">
        <nav>
        <a class="flex items-center px-4 py-2 mb-2 text-gray-600 transition-colors duration-300 transform rounded-md dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200 hover:text-gray-700" href="admin.php">

        <span class="mx-4 font-medium">Dashboard</span>
        </a>
        <a class="flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-md dark:bg-gray-800 dark:text-gray-200" href="artikel-admin.php">
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


<div class="flex-grow p-6">
    <a
        href="create-artikel.php"
        class="inline-block rounded bg-blue-600 px-4 py-2 mb-4 text-xs font-medium text-white hover:bg-blue-700"
    >
        Create
    </a>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-6 py-3 font-medium text-gray-900">Judul</th>
                    <th class="px-6 py-3 font-medium text-gray-900">Author</th>
                    <th class="px-6 py-3 font-medium text-gray-900">Image</th>
                    <th class="px-6 py-3 font-medium text-gray-900">Deskripsi</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900"><?= $row['judul']; ?></td>
                            <td class="px-6 py-4 text-gray-700"><?= $row['author']; ?></td>
                            <td class="px-6 py-4">
                                <img src="uploads/<?= $row['image']; ?>" alt="Image" class="h-12 w-12 object-cover rounded">
                            </td>
                            <td class="px-6 py-4 text-gray-700"><?= $row['deskripsi']; ?></td>
                            <td class="px-6 py-4 flex space-x-2">
                                <a
                                    href="edit-artikel.php?id=<?= $row['id_artikel']; ?>"
                                    class="inline-block rounded bg-yellow-600 px-4 py-2 text-xs font-medium text-white hover:bg-yellow-700"
                                >
                                    Edit
                                </a>
                                <a
                                    href="delete-artikel.php?id=<?= $row['id_artikel']; ?>"
                                    class="inline-block rounded bg-red-600 px-4 py-2 text-xs font-medium text-white hover:bg-red-700"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');"
                                >
                                    Delete
                                </a>
                            </td>
                            <td>
    <form action="update-status.php" method="POST" class="inline-block">
        <input type="hidden" name="id_artikel" value="<?= $row['id_artikel']; ?>">
        <label class="inline-flex items-center mr-2">
            <input type="radio" name="status" value="published" <?= $row['status'] == 'published' ? 'checked' : ''; ?>>
            <span class="ml-1">Publish</span>
        </label>
        <label class="inline-flex items-center mr-2">
            <input type="radio" name="status" value="draft" <?= $row['status'] == 'draft' ? 'checked' : ''; ?>>
            <span class="ml-1">Draft</span>
        </label>
        <button type="submit" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600 transition-transform transform hover:scale-105">Simpan</button>
    </form>
</td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-700">Tidak ada artikel yang ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

<?php
// Tutup koneksi database
$koneksi->close();
?>
