<?php
    include "../controllers/connection.php";
    // session_start();

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401); // Unauthorized
        echo json_encode(["error" => "Unauthorized"]);
        exit;
    }

    $query = "SELECT * FROM pockets WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$_SESSION['user_id']]);
    
    $pockets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // load
    
?>
