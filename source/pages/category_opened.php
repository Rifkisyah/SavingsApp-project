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
                <div id="category-topnav-content">
                    <button class="new-pocket-btn" onclick="open_pocket_modal()">+ Kantong Baru</button>
                </div>
            </div>
        </div>
        <div class="category-main">
            <div class="pocket-list">
                <?php if (count($pockets) > 0): ?>
                    <?php foreach ($pockets as $pocket): ?>
                        <div class="pocket-card">
                                    <div class="pocket-header">
                                        <h3 name="pocket_name" class="pocket-name-value"><?= htmlspecialchars($pocket['pocket_name']) ?></h3>
                                        <button type="button" class="delete-pocket" onclick="open_modal_confirm_delete_pocket()"><img src="../../assets/images/trashbin-icon.png" id="trashbin-icon"></button>
                                    </div>
                                    <div class="progress-wrapper">
                                        <h3 class="current-balance" id="current-balance"><?= number_format($pocket['current_amount'] ?? 0, 0, ',', '.') ?></h3>
                                        <div class="progress-container">
                                            <div class="progress-bar" id="progressBar"></div>
                                        </div>
                                    </div>
                                    <div class="target-container">
                                        <div class="target-item">
                                            <img src="../../assets/images/coin-outline-icon.png" class="pocket-icon">
                                            <span>Rp <?= number_format($pocket['target_amount'], 0, ',', '.') ?></span>
                                        </div>
                                        <div class="target-item">
                                            <img src="../../assets/images/calender-outline-icon.png" class="pocket-icon">
                                            <span><?= htmlspecialchars($pocket['target_date']) ?></span>
                                        </div>
                                        <div class="target-item">
                                            <img src="../../assets/images/category-outline-icon.png" class="pocket-icon">
                                            <span><?= htmlspecialchars($pocket['category_name']) ?></span>
                                        </div>
                                    </div>
                                    <div class="pocket-action-btn">
                                        <button type="button" class="add-balance" value="add" onclick="openModal(this.value)">Tambah Uang</button>
                                        <button type="button" class="withdraw-balance" value="remove" onclick="openModal(this.value)">Kurang Uang</button>

                                        <div id="saldoModal" class="modal-overlay" style="display: none;">
                                            <div class="modal-content">
                                                <h2 id="modalTitle">Masukan Saldo</h2>
                                                <input type="text" id="saldoInput" placeholder="Masukkan nominal" inputmode="numeric" pattern="Rp\. (\d{1,3})(\.\d{3})*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                                <div class="modal-actions">
                                                    <button type="button" id="confirm-btn" onclick="submitSaldo()">Simpan</button>
                                                    <button type="button" id="cancel-btn" onclick="closeModal()">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="margin-top: 20px; grid-column: span 3; margin-left: 20vh; margin-top: 20vh; font-weight: bold; font-size: 40px; color: #224A33;">Tidak ada kantong untuk kategori ini.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div id="dashboard-footer">
        <div id="dashboard-footer-content">
            <p id="copyright">&copy; <?php echo date("Y");?> SavingsApp, Semua Hak Dilindungi</p>
        </div>
    </div>
    <div class="gradient-overlay" id="gradient-overlay">
        <div class="pocket-modal-container">
            <div class="modal-header">
                <h2>Tambah Kantong Baru</h2>
                <button id="close-btn" onclick="close_pocket_modal()">X</button>
            </div>
            <span id="pocket-name-error"></span>
                <?php if(isset($_SESSION['pocket_name_error']) && $_SESSION['pocket_name_error']): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        open_pocket_modal(); // panggil JS untuk buka modal
                        document.getElementById('pocket-name-error').innerText = "Nama kantong sudah digunakan!";
                        document.getElementById('pocket-name-error').style.display = "flex";
                    });
                </script>
                <?php unset($_SESSION['pocket_name_error']); ?>
            <?php endif; ?>
            <form class="modal-content" action="../api/add_pockets.php" method="post" onsubmit="return validateCategorySelection();">
                <div class="pocket-name-container">
                    <h3>Nama Kantong:</h3>
                    <input type="text" id="pocket-name" name="pocket-name" placeholder="Masukan Nama Kantong..." inputmode="text" pattern="^[a-zA-Z0-9 ]+$" oninput="this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '')"  required>
                </div>
                <div class="target-nominal-container">
                    <h3>Target Nominal: (input harus berupa angka)</h3>
                    <input type="text" id="target-nominal" name="target-nominal" placeholder="Masukan Target Nominal..." inputmode="numeric" pattern="Rp\. (\d{1,3})(\.\d{3})*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                </div>
                <div class="target-date-container">
                    <h3>Target Tanggal:</h3>
                    <input type="date" id="target-date" name="target-date" required>
                </div>

                <div class="pocket-category-container">
                    <h3>Kategori Kantong:</h3>
                    <input type="hidden" name="selected-category" id="selected-category" required>

                    <div class="category-grid">
                        <button type="button" class="category-btn" id="category-btn" value="Kantong Umum" onclick="setCategory(this.value)">
                            <img src="../../assets/images/general-category-icon.png" class="category-img">
                            <h4>Kantong umum</h4>
                            <p>kantong untuk apapun</p>
                        </button>
                        <button type="button" class="category-btn" id="category-btn" value="Kantong Bisnis" onclick="setCategory(this.value)">
                            <img src="../../assets/images/bussines-category-icon.png" class="category-img">
                            <h4>Kantong bisnis</h4>
                            <p>kantong untuk Pelaku Bisnis</p>
                        </button>
                        <button type="button" class="category-btn" id="category-btn" value="Kantong Tabungan" onclick="setCategory(this.value)">
                            <img src="../../assets/images/save-money-category-icon.png" class="category-img">
                            <h4>Kantong Tabungan</h4>
                            <p>kantong untuk Menyimpan Uang</p>
                        </button>
                        <button type="button" class="category-btn" id="category-btn" value="kantong Darurat" onclick="setCategory(this.value)">
                            <img src="../../assets/images/emergency-category-icon.png" class="category-img">
                            <h4>Kantong Darurat</h4>
                            <p>kantong untuk menyimpan uang darurat</p>
                        </button>
                        <button type="button" class="category-btn" id="category-btn" value="kantong Qurban" onclick="setCategory(this.value)">
                            <img src="../../assets/images/qurban-category-icon.png" class="category-img">
                            <h4>Kantong qurban</h4>
                            <p>kantong untuk Tabungan Qurban</p>
                        </button>
                        <button type="button" class="category-btn" id="category-btn" value="Kantong Jalan-Jalan" onclick="setCategory(this.value)">
                            <img src="../../assets/images/traveling-category-icon.png" class="category-img">
                            <h4>Kantong Traveling</h4>
                            <p>kantong untuk Menyimpan uang Traveling</p>
                        </button>
                    </div>
                </div>
                <?php if (isset($_SESSION['error'])): ?>
                    <p id="error-message"><?= htmlspecialchars($_SESSION['error']); ?></p>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                <button type="submit" id="submit-btn">Selesai</button>
            </form>
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
    <div id="modal-confirm-delete-pocket" class="modal-overlay">
        <div class="modal-box">
            <h2 class="modal-title">Konfirmasi</h2>
            <p class="modal-message">Apakah kamu yakin ingin Menghapus Kantong ini?</p>
            <div class="modal-buttons">
                <button class="btn-cancel" onclick="close_modal_confirm_delete_pocket()">Batal</button>
                <button class="btn-confirm" onclick="confirm_delete_pocket()">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>
    <!-- <script src="../scripts/chart.js"></script> -->
    <script src="../scripts/get_user_summary.js"></script>
    <script src="../scripts/delete_pocket.js"></script>
    <script src="../scripts/nominal_format.js"></script>
    <!-- <script src="../scripts/carousel.js"></script> -->
    <script src="../scripts/progress_bar.js"></script>
    <script src="../scripts/pockets_category_listener.js"></script>
    <script src="../scripts/interface.js" defer></script>
</body>
</html>
