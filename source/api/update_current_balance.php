<?php
session_start();
error_log("SESSION ID: " . session_id());
error_log("SESSION DATA: " . print_r($_SESSION, true));
require '../controllers/connection.php'; // koneksi ke DB (PDO)

$data = json_decode(file_get_contents("php://input"), true);
$pocket = $data['pocket'] ?? null;
$balance = $data['balance'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;

if (!$pocket || $balance === null || !$user_id) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
    exit;
}

// Ambil saldo lama dari pocket berdasarkan nama dan user_id
$stmt = $conn->prepare("SELECT current_amount FROM pockets WHERE pocket_name = ? AND user_id = ?");
$stmt->execute([$pocket, $user_id]);
$oldData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$oldData) {
    // Pocket tidak ditemukan atau bukan milik user ini —> Hapus session ringkasan
    $_SESSION['incoming'] = 0;
    $_SESSION['outgoing'] = 0;
    $_SESSION['total'] = 0;
    echo json_encode([
        'success' => false,
        'message' => 'Kantong tidak ditemukan. Session telah dibersihkan.',
        'incoming' => 0,
        'outgoing' => 0,
        'total' => 0
    ]);
    exit;
}

$oldBalance = $oldData['current_amount'] ?? 0;

// Hitung selisih
$incoming = $outgoing = 0;
if ($balance > $oldBalance) {
    $incoming = $balance - $oldBalance;
} elseif ($balance < $oldBalance) {
    $outgoing = $oldBalance - $balance;
}
$total = $incoming - $outgoing;

// Update saldo di pockets
$stmt = $conn->prepare("UPDATE pockets SET current_amount = ? WHERE pocket_name = ? AND user_id = ?");
$stmt->execute([$balance, $pocket, $user_id]);

// Cek apakah user_id sudah ada di pocket_summary
$stmt = $conn->prepare("SELECT * FROM pocket_summary WHERE user_id = ?");
$stmt->execute([$user_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    if ($incoming > 0 || $outgoing > 0) {
        $newIncoming = $row['incoming_balance'] + $incoming;
        $newOutgoing = $row['outgoing_balance'] + $outgoing;
        $newTotal = $newIncoming - $newOutgoing;

        $stmt = $conn->prepare("UPDATE pocket_summary SET incoming_balance = ?, outgoing_balance = ?, total_balance = ? WHERE user_id = ?");
        $stmt->execute([$newIncoming, $newOutgoing, $newTotal, $user_id]);

        $_SESSION['incoming'] = $newIncoming;
        $_SESSION['outgoing'] = $newOutgoing;
        $_SESSION['total'] = $newTotal;
    } else {
        $_SESSION['incoming'] = $row['incoming_balance'];
        $_SESSION['outgoing'] = $row['outgoing_balance'];
        $_SESSION['total'] = $row['total_balance'];
    }
} else {
    if ($incoming > 0 || $outgoing > 0) {
        $stmt = $conn->prepare("INSERT INTO pocket_summary (user_id, total_balance, incoming_balance, outgoing_balance) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $total, $incoming, $outgoing]);

        $_SESSION['incoming'] = $incoming;
        $_SESSION['outgoing'] = $outgoing;
        $_SESSION['total'] = $total;
    } else {
        $_SESSION['incoming'] = 0;
        $_SESSION['outgoing'] = 0;
        $_SESSION['total'] = 0;
    }
}

// Kirim respons ke frontend termasuk session yang baru
echo json_encode([
    'success' => true,
    'incoming' => $_SESSION['incoming'],
    'outgoing' => $_SESSION['outgoing'],
    'total' => $_SESSION['total']
]);
?>
