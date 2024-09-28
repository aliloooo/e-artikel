<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Hubungkan ke database
require('koneksi.php');

// Ambil ID artikel dari URL
if (isset($_GET['id'])) {
    $id_artikel = $_GET['id'];

    // Query untuk mengambil data artikel
    $sql = "SELECT * FROM artikel WHERE id_artikel = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_artikel);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $artikel = $result->fetch_assoc();
    } else {
        echo "Artikel tidak ditemukan.";
        exit();
    }

    // Jika formulir disubmit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $judul = $_POST['judul'];
        $author = $_POST['author'];
        $deskripsi = $_POST['deskripsi'];
        $image = $_FILES['image']['name'];

        // Update artikel di database
        if (!empty($image)) {
            // Jika gambar baru diupload, proses upload dan update
            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
            $sql = "UPDATE artikel SET judul = ?, author = ?, deskripsi = ?, image = ? WHERE id_artikel = ?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("ssssi", $judul, $author, $deskripsi, $image, $id_artikel);
        } else {
            // Jika tidak ada gambar baru, tetap gunakan gambar yang ada
            $sql = "UPDATE artikel SET judul = ?, author = ?, deskripsi = ? WHERE id_artikel = ?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("sssi", $judul, $author, $deskripsi, $id_artikel);
        }

        if ($stmt->execute()) {
            header("Location: artikel-admin.php?msg=Artikel berhasil diperbarui");
        } else {
            echo "Error updating record: " . $koneksi->error;
        }

        // Tutup statement
        $stmt->close();
    }
} else {
    echo "ID artikel tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artikel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center h-screen bg-gray-100">
<div class="w-full max-w-2xl bg-white p-6 rounded-lg shadow-md">
    <h2 class="mb-4 text-lg font-bold">Edit Artikel</h2>
    <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="sr-only" for="judul">Judul</label>
            <input
                class="w-full rounded-lg border-gray-200 p-3 text-sm"
                placeholder="Masukan Judul"
                type="text"
                id="judul"
                name="judul"
                value="<?= htmlspecialchars($artikel['judul']) ?>"
                required
            />
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label class="sr-only" for="author">Author</label>
                <input
                    class="w-full rounded-lg border-gray-200 p-3 text-sm"
                    placeholder="Masukan nama author"
                    type="text"
                    id="author"
                    name="author"
                    value="<?= htmlspecialchars($artikel['author']) ?>"
                    required
                />
            </div>

            <div>
                <label class="sr-only" for="image">Image</label>
                <input
                    class="w-full rounded-lg border-gray-200 p-3 text-sm"
                    placeholder="Masukan Gambar (Kosongkan jika tidak diubah)"
                    type="file"
                    id="image"
                    name="image"
                />
            </div>
        </div>

        <div>
            <label class="sr-only" for="deskripsi">Deskripsi</label>
            <textarea
                class="w-full rounded-lg border-gray-200 p-3 text-sm"
                placeholder="Masukan deskripsi"
                rows="8"
                id="deskripsi"
                name="deskripsi"
                required
            ><?= htmlspecialchars($artikel['deskripsi']) ?></textarea>
        </div>

        <div class="mt-4">
            <button
                type="submit"
                class="inline-block w-full rounded-lg bg-black px-5 py-3 font-medium text-white sm:w-auto"
            >
                Save
            </button>
            <a
                href="artikel-admin.php"
                class="inline-block w-full rounded-lg bg-light px-5 py-3 font-medium text-dark sm:w-auto"
            >
                Kembali
            </a>
        </div>
    </form>
</div>
</body>
</html>

<?php
// Tutup koneksi database
$koneksi->close();
?>
