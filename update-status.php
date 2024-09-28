<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Hubungkan ke database
require('koneksi.php');

// Pastikan ID artikel dan status dikirim melalui POST
if (isset($_POST['id_artikel']) && isset($_POST['status'])) {
    $id_artikel = intval($_POST['id_artikel']);
    $status = $_POST['status'];

    // Validasi status (hanya "published" atau "draft")
    if ($status == 'published' || $status == 'draft') {
        // Update status artikel
        $sql = "UPDATE artikel SET status = ? WHERE id_artikel = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("si", $status, $id_artikel);
        $stmt->execute();

        // Redirect kembali ke artikel-admin.php setelah update
        header("Location: artikel-admin.php");
        exit();
    } else {
        echo "Status tidak valid.";
    }
} else {
    echo "Data tidak lengkap.";
}

// Tutup koneksi database
$koneksi->close();
?>
