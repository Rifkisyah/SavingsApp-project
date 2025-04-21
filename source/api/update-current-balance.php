<?php
include "../controllers/connection.php";
header('Content-Type: application/json');

if (ob_get_length()) ob_clean();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents("php://input"), true);

$pocket = $data['pocket'] ?? '';
$saldo  = $data['saldo'] ?? 0;

if ($pocket === '' || !is_numeric($saldo)) {
    echo json_encode(['success' => false, 'message' => 'Data tidak valid']);
    exit;
}

try {
    $stmt = $conn->prepare("UPDATE pockets SET current_amount = ? WHERE LOWER(pocket_name) = LOWER(?)");
    $stmt->execute([$saldo, $pocket]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Pocket tidak ditemukan atau nilai saldo tidak berubah.'
        ]);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'DB Error: ' . $e->getMessage()]);
}
?>
