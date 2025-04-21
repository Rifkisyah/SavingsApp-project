<?php
include '../controllers/connection.php';
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Ambil data JSON yang dikirimkan dari frontend
$data = json_decode(file_get_contents('php://input'), true);

// Cek apakah data pocket ada
$pocket = $data['pocket'] ?? null;

if (!$pocket === null) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}

// Cek apakah koneksi database berhasil
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Cek apakah kantong dengan pocket_name ada di database
$query = "SELECT * FROM pockets WHERE pocket_name = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$pocket]);
$pocketExists = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pocketExists) {
    echo json_encode(['success' => false, 'message' => 'Pocket tidak ditemukan']);
    exit;
}

// Misalnya kamu punya kolom `current_balance` di tabel `pockets`
$stmt = $conn->prepare("DELETE FROM pockets WHERE pocket_name = ?");
$stmt->execute([$pocket]);

// Cek apakah ada baris yang terpengaruh
if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true, 'message' => 'Saldo berhasil diperbarui']);
} else {
    echo json_encode(['success' => false, 'message' => 'Nilai saldo tidak berubah atau ada kesalahan']);
}
?>