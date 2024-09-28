<?php
session_start();

require('koneksi.php');

if (!isset($_GET['id'])) {
    header("Location: artikel-admin.php");
    exit();
}

$id_artikel = intval($_GET['id']);

$sql = "SELECT * FROM artikel WHERE id_artikel = $id_artikel";
$result = $koneksi->query($sql);

if ($result->num_rows == 0) {
    echo "<p class='text-center text-gray-700'>Article not found or not published.</p>";
    exit();
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($row['judul']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-4">
    <div class="mt-8">
        <h1 class="text-3xl font-bold text-dark"><?= htmlspecialchars($row['judul']); ?></h1>
        <p class="text-sm text-gray-500">By <?= htmlspecialchars($row['author']); ?></p>
        <img class="object-cover w-full h-72 rounded-xl mt-4" src="uploads/<?= htmlspecialchars($row['image']); ?>" alt="Article Image">
        <p class="mt-6 text-sm text-gray-700"><?= nl2br(htmlspecialchars($row['deskripsi'])); ?></p>
    </div>

    <div class="mt-8">
        <a href="artikel.php" class="inline-block rounded bg-blue-600 px-4 py-2 text-xs font-medium text-white hover:bg-blue-700">Back to Articles</a>
    </div>
</div>

</body>
</html>

<?php
// Close the database connection
$koneksi->close();
?>
