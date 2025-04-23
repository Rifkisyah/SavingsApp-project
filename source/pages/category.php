<?php
    session_start();

    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");

    include('../controllers/session_time.php');
    include('../api/load_pocket.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SavingsApp - Beranda</title>
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
                <h1>Beranda</h1>
                <div class="topnav-content" id="topnav-content">
                    <button class="new-pocket-btn" onclick="open_pocket_modal()">+ Kantong Baru</button>
                </div>
            </div>
        </div>
        <div class="main">
            <div class="content">
                <div class="primary-category-content" id="primary-content">
                    <div class="pocket-page-category-container">
                        <h3>Kategori Kantong:</h3>
                        <div class="category-grid-page">
                            <button type="button" class="page-category-btn" value="Kantong Umum" onclick="goToCategory(this.value)">
                                <img src="../../assets/images/general-category-icon.png" class="page-category-img">
                                <h4>Kantong Umum</h4>
                                <p>Kantong untuk apapun</p>
                            </button>
                            <button type="button" class="page-category-btn" value="Kantong Bisnis" onclick="goToCategory(this.value)">
                                <img src="../../assets/images/bussines-category-icon.png" class="page-category-img">
                                <h4>Kantong Bisnis</h4>
                                <p>Kantong untuk Pelaku Bisnis</p>
                            </button>
                            <button type="button" class="page-category-btn" value="Kantong Tabungan" onclick="goToCategory(this.value)">
                                <img src="../../assets/images/save-money-category-icon.png" class="page-category-img">
                                <h4>Kantong Tabungan</h4>
                                <p>Kantong untuk Menyimpan Uang</p>
                            </button>
                            <button type="button" class="page-category-btn" value="Kantong Darurat" onclick="goToCategory(this.value)">
                                <img src="../../assets/images/emergency-category-icon.png" class="page-category-img">
                                <h4>Kantong Darurat</h4>
                                <p>Kantong untuk kebutuhan darurat</p>
                            </button>
                            <button type="button" class="page-category-btn" value="Kantong Qurban" onclick="goToCategory(this.value)">
                                <img src="../../assets/images/qurban-category-icon.png" class="page-category-img">
                                <h4>Kantong Qurban</h4>
                                <p>Kantong untuk tabungan Qurban</p>
                            </button>
                            <button type="button" class="page-category-btn" value="Kantong Jalan-Jalan" onclick="goToCategory(this.value)">
                                <img src="../../assets/images/traveling-category-icon.png" class="page-category-img">
                                <h4>Kantong Traveling</h4>
                                <p>Kantong untuk liburan</p>
                            </button>
                        </div>
                    </div>
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
