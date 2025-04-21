<!-- <?php
include "connection.php";

// Pastikan user sudah login
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$sql = "SELECT pocket_id, current_amount FROM pockets";
$result = $conn->prepare($sql);

$data = [];

while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {
    $data[] = [
        "pocket_id" => $row['pocket_id'],
        "current_amount" => $row['current_amount']
    ];
}

$json = json_encode($data, JSON_PRETTY_PRINT);
echo $json;
?> -->