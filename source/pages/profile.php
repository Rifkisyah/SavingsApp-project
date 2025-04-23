<?php
    session_start();

    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");

    include('../controllers/session_time.php');
    include('../api/get_user_profile.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SavingsApp - Profil</title>
    <link rel="icon" href="../../assets/images/mini-icon-dummy.png">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="side-nav" id="side-nav">
        <div class="logo">
            <img src="../../assets/images/mini-icon-dummy.png" id="img-logo"><p>avingsApp</p>
        </div>
        <button class="profile-section" onclick="location.href='profile.php'">
            <img src="../../assets/images/default-photo-profile.png" id="img-profile">
            <h2>Cek Profil</h2>
        </button>
        <button class="sidenav-content" onclick="location.href='Beranda.php'">
            <img src="../../assets/images/category-icon.png" id="img-sidenav-content">
            <h3>Beranda</h3>
        </button>
        <button class="sidenav-content" onclick="location.href='category.php'">
            <img src="../../assets/images/dashboard-icon.png" id="img-sidenav-content">
            <h3>Kategori</h3>
        </button>
        <button class="sidenav-content" id="logout-btn" onclick="open_modal_confirm_logout()">
            <img src="../../assets/images/logout-icon.png" id="img-sidenav-content">
            <h3>Keluar</h3>
        </button>
    </div>
    <div class="wrapper-content" id="wrapper-content">
        <div class="header">
            <div class="top-nav">
                <span onclick="toggle_side_nav()">☰</span>
                <h1>Profil</h1>
            </div>
        </div>
        <div class="main">
            <div class="content">
                <div class="profile-content" id="profile-content">
                <?php if ($user): ?>
                    <div class="field"><strong>UID&emsp; &emsp; &emsp; &ensp;:</strong> <?= htmlspecialchars($user['uid']) ?></div>
                    <div class="field"><strong>Email&emsp; &emsp; &emsp;:</strong> <?= htmlspecialchars($user['email']) ?></div>
                    <div class="field"><strong>Username &emsp;:</strong> <?= htmlspecialchars($user['username']) ?></div>
                <?php else: ?>
                    <p>Data pengguna tidak ditemukan.</p>
                <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="footer-content">
                <p id="copyright">&copy; <?php echo date("Y");?> SavingsApp, Semua Hak Dilindungi</p>
            </div>
        </div>
    </div>
    <div id="modal-confirm-logout" class="modal-overlay">
        <div class="modal-box">
            <h2 class="modal-title">Konfirmasi</h2>
            <p class="modal-message">Apakah kamu yakin ingin Keluar?</p>
            <div class="modal-buttons">
                <button class="btn-cancel" onclick="close_modal_confirm_logout()">Batal</button>
                <button class="btn-confirm" onclick="confirm_logout()">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>
    <script src="../scripts/interface.js" defer></script>
</body>
</html>
