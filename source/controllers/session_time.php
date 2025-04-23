<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

$session_timeout = 100000; // dalam detik

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $session_timeout) {
    // Sesi kadaluwarsa
    session_unset();
    session_destroy();
    session_regenerate_id(true);
    header("Location: ../pages/Masuk.php");
    exit;
}

// Perbarui waktu aktivitas terakhir
$_SESSION['LAST_ACTIVITY'] = time();

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/Masuk.php?error=" . urlencode("Anda belum login."));
    exit;
}
?>
