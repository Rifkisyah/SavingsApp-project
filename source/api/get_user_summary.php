<?php
session_start();
require '../controllers/connection.php'; // koneksi PDO

if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

// Query data dari database
$stmt = $conn->prepare("SELECT total_balance, incoming_balance, outgoing_balance FROM pocket_summary WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);

if($stmt->rowCount() == 0){
    $ins = $conn->prepare("INSERT INTO pocket_summary(user_id, total_balance, incoming_balance, outgoing_balance) values(?,?,?,?)");
    $ins->execute([$_SESSION['user_id'], 0, 0, 0]);

    $stmt = $conn->prepare("SELECT total_balance, incoming_balance, outgoing_balance FROM pocket_summary WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
}  

$summary_data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($summary_data) {
    echo json_encode([
        'success' => true,
        'summary' => $summary_data
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Data tidak ditemukan'
    ]);
}
?>
