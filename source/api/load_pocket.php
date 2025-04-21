<?php
    include "../controllers/connection.php";

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401); // Unauthorized
        echo json_encode(["error" => "Unauthorized"]);
        exit;
    }

    $query = "SELECT * FROM pockets";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    $pockets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debug: Cek apakah $pockets berisi data
?>
