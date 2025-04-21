<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SavingsApp - Daftar</title>
    <link rel="icon" href="../../assets/images/Mini-icon-dummy.png">
    <link rel="stylesheet" href="../styles.css">
</head>
<body class="authentication-page">
    <div class="card-item">
        <form method="post" action="../controllers/start_auth_session.php" class="authentication-form">
            <h1>Selamat Datang Di SavingsApp</h1>
            <hr>
            <p>Silahkan isi form dibawah untuk Mendaftar</p>
            <input type="hidden" name="proses" value="daftar">
            <input type="text" name="email" placeholder="Alamat Email..." autocomplete="off" required>
            <input type="password" name="password" placeholder="Password..." id="password-field" autocomplete="off" required>
            <div class="toggle-password">
                <input type="checkbox" id="toggle-password" onclick="show_password()"><span>klik untuk melihat sandi</span>
            </div>
            <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo '<p id="error-message">' . htmlspecialchars($_SESSION['error']) . '</p>';
                unset($_SESSION['error']);
            }
            ?>
            <button type="submit">Daftar</button>
            <hr>
            <div class="suggest">
                <p>Sudah Punya Akun?</p><a href="Masuk.php">Masuk Disini</a>
            </div>
        </form>
    </div>
    <script src="../scripts/interface.js"></script>
</body>
</html>