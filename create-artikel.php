<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $koneksi->real_escape_string($_POST['judul']);
    $author = $koneksi->real_escape_string($_POST['author']);
    $deskripsi = $koneksi->real_escape_string($_POST['deskripsi']);
    
    // Upload gambar
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Insert data ke dalam database
        $sql = "INSERT INTO artikel (judul, author, image, deskripsi) VALUES ('$judul', '$author', '$image', '$deskripsi')";

        if ($koneksi->query($sql) === TRUE) {
            // Tampilkan alert berhasil menggunakan JavaScript
            echo "<script>
                    alert('Data berhasil disimpan!');
                  </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    } else {
        echo "Maaf, terjadi kesalahan saat mengupload gambar.";
    }
}

$koneksi->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex">
<section class="flex-grow bg-gray-100 p-8">
  <div class="mx-auto max-w-screen-xl">
    <div class="rounded-lg bg-dark p-8 shadow-lg lg:p-12">
        <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
          <div>
            <label class="sr-only" for="judul">Judul</label>
            <input
              class="w-full rounded-lg border-gray-200 p-3 text-sm"
              placeholder="Masukan Judul"
              type="text"
              id="judul"
              name="judul"
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
                required
              />
            </div>

            <div>
              <label class="sr-only" for="image">Image</label>
              <input
                class="w-full rounded-lg border-gray-200 p-3 text-sm"
                placeholder="Masukan Gambar"
                type="file"
                id="image"
                name="image"
                required
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
            ></textarea>
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
    </div>
  </div>
</section>
</body>
</html>
