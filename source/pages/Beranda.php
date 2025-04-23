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
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/chart.umd.min.js"></script> -->
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
        <!-- <button class="sidenav-content">
            <img src="../../assets/images/setting-icon.png" id="img-sidenav-content">
            <h3>Pengaturan</h3>
        </button> -->
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
                    <!-- <button class="notif-btn"><img src="../../assets/images/notification-icon.png" class="notification-icons"></img></button> -->
                </div>
            </div>
        </div>
        <div class="main">
            <div class="content">
                <div class="primary-content" id="primary-content">
                    <div class="summary" id="summary-container">
                        <h2>selamat datang <?php echo $_SESSION['username'] ?>, Ini Ringkasan Keuanganmu</h2>
                        <div class="flex-balance">
                            <div class="total-balance">
                                <h3>Total Uang</h3><hr>
                                <?php ?>
                                    <p id="total-summary" class="summary-curency"></p>
                                <!-- <div class="transaction">
                                    <button class="history-transaction-btn">Lihat Riwayat Transaksi Bulan ini</button>
                                </div> -->
                            </div>
                            <div class="incoming-balance">
                                <h3>Saldo Masuk</h3><hr>
                                <?php ?>
                                    <p id="incoming-summary" class="summary-curency"></p>
                                <?php ?>
                            </div>
                            <div class="outgoing-balance">
                                <h3>Saldo Keluar</h3><hr>
                                <?php ?>
                                    <p id="outgoing-summary" class="summary-curency"></p>
                                <?php ?>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="chart-section">
                        <div class="chart">
                            <h2>Grafik Keuangan</h2>
                            <div class="flex-chart">
                                <canvas id="chart-canvas"></canvas>
                                <script src="../scripts/chart.js"></script>
                            </div>
                        </div>
                        <div class="filter-chart">
                            <fieldset>
                                <legend>Filter Grafik</legend>
    
                                <h4>Tipe Tanggal :</h4>
                                <div class="filter-chart-date">
                                    <button class="filter-btn">Hari</button>
                                    <button class="filter-btn">Bulan</button>
                                    <button class="filter-btn">Tahun</button>
                                </div>
    
                                <h4>Jumlah Digit :</h4>
                                <div class="filter-number-of-digits-chart">
                                <button class="filter-btn 6_digits" id="filter-btn">Ratus Ribuan</button>
                                <button class="filter-btn 7_digits" id="filter-btn">Jutaan</button>
                                <button class="filter-btn 8_digits" id="filter-btn">Puluhan Juta</button>
                                <button class="filter-btn 9_digits" id="filter-btn">Ratus Jutaan</button>
                                </div>
    
                                <h4>Kantong Uang :</h4>
                                <div class="filter-savings-pockets">
                                    <button id="prev-button">←</button>
                                    <div class="carousel-wrapper">
                                        <div class="slide-container">
                                            <?php foreach ($pockets as $pocket): ?>
                                            <div class="slide">
                                                <h3 name="pocket_name" class="pocket-name-value"><?= htmlspecialchars($pocket['pocket_name']) ?></h3>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <button id="next-button">→</button>
                                </div>
    
                                <div class="flex-filter-button">
                                    <button id="apply-filter-btn" onclick="changeDigit()">Simpan Filter</button>
                                </div>
                            </fieldset>
                        </div>
                    </div> -->
                    <hr class="section-divider">
                    <div class="pocket-search-section">
                        <!-- <button id="search-filter">
                            <img src="../../assets/images/filter-icon.png" id="img-filter">
                        </button> -->
                        <input type="text" placeholder="Cari Kantong Uang..." id="search-bar">
                        <button id="search-button">
                            <img src="../../assets/images/search-icon.png" id="img-search">
                        </button>
                    </div>
                    <div class="savings-pocket-section">
                        <h2>Kantong Uang</h2>
                        <div class="pocket-container" id="pocket-container">
                        <?php if (count($pockets) === 0): ?>
                            <h1 id="blank-label">Kantong Uangmu Kosong</h1>
                        <?php else: ?>
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
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- <div class="adds-wrapper" id="adds-wrapper">
                    <div class="adds-container">
                        <p>pasang iklan disini</p>
                    </div>
                    <div class="adds-container">
                        <p>pasang iklan disini</p>
                    </div>
                    <div class="adds-container">
                        <p>pasang iklan disini</p>
                    </div>
                    <div class="adds-container">
                        <p>pasang iklan disini</p>
                    </div>
                </div> -->
            </div>
        </div>
        <div class="footer">
            <div class="footer-content">
                <p id="copyright">&copy; <?php echo date("Y");?> SavingsApp, Semua Hak Dilindungi</p>
            </div>
        </div>
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
