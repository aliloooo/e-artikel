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

    // Query untuk menghapus artikel
    $sql = "DELETE FROM artikel WHERE id_artikel = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_artikel);

    if ($stmt->execute()) {
        // Redirect ke halaman artikel-admin.php setelah berhasil dihapus
        header("Location: artikel-admin.php?msg=Artikel berhasil dihapus");
    } else {
        echo "Error deleting record: " . $koneksi->error;
    }

    // Tutup statement
    $stmt->close();
}

// Tutup koneksi database
$koneksi->close();
?>
