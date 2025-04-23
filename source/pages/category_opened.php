<?php
session_start();
include('../controllers/connection.php');

if (!isset($_GET['category'])) {
    header("Location: Beranda.php");
    exit;
}

$category = $_GET['category'];
$user_id = $_SESSION['user_id']; // pastikan session user aktif

$query = "SELECT * FROM pockets WHERE category_name = :category AND user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->execute(['category' => $category, 'user_id' => $user_id]);
$pockets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pocket - <?php echo htmlspecialchars($category); ?></title>
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
            <img src="../../assets/images/dashboard-icon.png" id="img-sidenav-content">
            <h3>Beranda</h3>
        </button>
        <button class="sidenav-content" onclick="location.href='category.php'">
            <img src="../../assets/images/category-icon.png" id="img-sidenav-content">
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
                <h1>Kategori: <?php echo htmlspecialchars($category); ?></h1>
                <div class="topnav-content" id="topnav-content">
                    <button class="new-pocket-btn" onclick="open_pocket_modal()">+ Kantong Baru</button>
                </div>
            </div>
        </div>

        <div class="category-main">
            <div class="pocket-list">
                <?php if (count($pockets) > 0): ?>
                    <?php foreach ($pockets as $pocket): ?>
                        <div class="category-filtered-pocket-card">
                            <h3><?php echo htmlspecialchars($pocket['pocket_name']); ?></h3>
                            <p>Target: Rp<?php echo number_format($pocket['target_amount'], 0, ',', '.'); ?></p>
                            <p>Terkumpul: Rp<?php echo number_format($pocket['current_amount'], 0, ',', '.'); ?></p>
                            <p>Deadline: <?php echo htmlspecialchars($pocket['target_date']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="margin-top: 20px;">Tidak ada kantong untuk kategori ini.</p>
                <?php endif; ?>
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
