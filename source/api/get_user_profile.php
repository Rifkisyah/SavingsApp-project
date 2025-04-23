<?php
require_once '../controllers/connection.php'; // sesuaikan path-nya

// Cek session
if (!isset($_SESSION['user_id'])) {
    echo "User belum login.";
    exit;
}

$userId = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("SELECT uid, email, username, password FROM users WHERE uid = :uid");
    $stmt->bindParam(':uid', $userId);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Terjadi kesalahan: " . $e->getMessage());
}
?>