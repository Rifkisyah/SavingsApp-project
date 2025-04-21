<?php
    $host = "localhost";
    $db = "saving_app_db";
    $username = "root";
    $password = "root";

    try {
        $conn = new PDO("mysql:host=$host; dbname=$db;", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Koneksi berhasil!";
    } catch (PDOException $e) {
        // echo "Koneksi gagal: " . $e->getMessage();
    }
?>