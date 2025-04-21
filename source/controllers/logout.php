<?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        session_start();
        session_unset();
        session_destroy();
        session_regenerate_id(true);
        
        // Cek apakah sesi dihancurkan dengan benar
        if (session_status() == PHP_SESSION_NONE) {
            echo json_encode(['status' => 'success', 'message' => 'Logout berhasil']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Logout gagal']);
        }
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    }
?>