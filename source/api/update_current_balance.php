<?php
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require '../controllers/connection.php';

$data = json_decode(file_get_contents("php://input"), true);
$pocket = $data['pocket'] ?? null;
$balance = $data['balance'] ?? null;
$user_id = $_SESSION['user_id'];

if (!$pocket || $balance === null) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
    exit;
}

// Ambil saldo lama
$stmt = $conn->prepare("SELECT current_amount FROM pockets WHERE pocket_name = ? AND user_id = ?");
$stmt->execute([$pocket, $user_id]);
$oldData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$oldData) {
    echo json_encode(['success' => false, 'message' => 'Kantong tidak ditemukan.']);
    exit;
}

$oldBalance = (int) $oldData['current_amount'];
$balance = (int) $balance;

// Hitung selisih
$incoming = $balance > $oldBalance ? $balance - $oldBalance : 0;
$outgoing = $balance < $oldBalance ? $oldBalance - $balance : 0;

// Update saldo di kantong
$stmt = $conn->prepare("UPDATE pockets SET current_amount = ? WHERE pocket_name = ? AND user_id = ?");
$stmt->execute([$balance, $pocket, $user_id]);

// Update ringkasan
$stmt = $conn->prepare("SELECT * FROM pocket_summary WHERE user_id = ?");
$stmt->execute([$user_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $newIncoming = $row['incoming_balance'] + $incoming;
    $newOutgoing = $row['outgoing_balance'] + $outgoing;
    $newTotal = $newIncoming - $newOutgoing;

    $stmt = $conn->prepare("UPDATE pocket_summary SET incoming_balance = ?, outgoing_balance = ?, total_balance = ? WHERE user_id = ?");
    $stmt->execute([$newIncoming, $newOutgoing, $newTotal, $user_id]);
} else {
    $stmt = $conn->prepare("INSERT INTO pocket_summary(user_id, incoming_balance, outgoing_balance, total_balance) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $incoming, $outgoing, $incoming - $outgoing]);
}

// Respon sukses ke frontend
echo json_encode([
    'success' => true,
    'message' => 'Saldo berhasil diperbarui.',
    'data' => [
        'incoming' => $incoming,
        'outgoing' => $outgoing,
        'balance' => $balance
    ]
]);
