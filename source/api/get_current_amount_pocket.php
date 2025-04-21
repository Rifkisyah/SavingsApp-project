<?php
include '../controllers/connection.php';

session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Ambil parameter pocket_name
$pocket_name = $_GET['pocket_name'] ?? null;

if (!$pocket_name) {
    echo json_encode(['success' => false, 'message' => 'Pocket name tidak diberikan']);
    exit;
}

// Ambil data kantong berdasarkan pocket_name
$query = "SELECT target_amount FROM pockets WHERE pocket_name = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$pocket_name]);
$pocket = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pocket) {
    echo json_encode(['success' => false, 'message' => 'Pocket tidak ditemukan']);
    exit;
}

// Pastikan target_amount ada dan valid
if (!isset($pocket['target_amount']) || !is_numeric($pocket['target_amount'])) {
    echo json_encode(['success' => false, 'message' => 'Data target tidak valid atau kosong.']);
    exit;
}

// Kirim data target_amount ke frontend
echo json_encode(['success' => true, 'target_amount' => $pocket['target_amount']]);
?>

