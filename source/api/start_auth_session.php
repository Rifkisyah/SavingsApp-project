<?php
include "../controllers/connection.php";
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $action = $_POST['proses'];

    if($action == "daftar"){
        $uid;
        $email = $_POST['email'];
        $raw_password = $_POST['password'];

        do {
            $uid = bin2hex(random_bytes(4));
        } while (check_avaible_uid($uid));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email tidak valid";
            header("Location: ../pages/Daftar.php");
            exit;
        } else if (strpos($email, '@') < 3) {
            $_SESSION['error'] = "Email Terlalu Pendek";
            header("Location: ../pages/Daftar.php");
            exit;
        }
        else if (!preg_match('/^[a-zA-Z0-9._]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,}$/', $email)) {
            $_SESSION['error'] = "Email hanya boleh mengandung huruf, angka, titik (.), underscore (_) dan satu @";
            header("Location: ../pages/Daftar.php");
            exit;
        }

        if(strlen($raw_password) < 5 ){
            $_SESSION['error'] = "Password Terlalu Pendek";
            header("Location: ../pages/Daftar.php");
            exit;
        } else {
            $password = password_hash($raw_password, PASSWORD_DEFAULT);
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);

        if($stmt->rowCount() > 0){
            $_SESSION['error'] = "Daftar Gagal!, email Sudah Tersedia";
            header("Location: ../pages/Daftar.php");
            exit;
        } else {
            $stmt = $conn->prepare("INSERT INTO users(uid, email, password) VALUES(?, ?, ?)");
            $stmt->execute([$uid, $email, $password]);

            $_SESSION['user_id'] = $uid;

            header("Location: ../pages/create_username.php");
            exit;
        }
    }

    if($action == "masuk"){
        $uid;
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $username;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email tidak valid";
            header("Location: ../pages/Masuk.php");
            exit;
        } else if (strpos($email, '@') < 3) {
            $_SESSION['error'] = "Email Terlalu Pendek";
            header("Location: ../pages/Masuk.php");
            exit;
        }
        if(!check_avaible_email($email)){
            $_SESSION['error'] = "Akun Tidak Ditemukan";
            header("Location: ../pages/Masuk.php");
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        $_SESSION['username'] = $user['username'];
        
        if ($user && password_verify($_POST["password"], $user["password"])) {
            $_SESSION['user_id'] = $user['uid'];
            
            header("Location: ../Pages/Beranda.php");
            exit;
        } else {
            $_SESSION['error'] = "Email atau kata sandi salah!";
            header("Location: ../pages/Masuk.php");
            exit;
        }
    }

    if($action == "add-username"){
        $username = $_POST['username'];

        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE uid = ?");
        $stmt->execute([$username, $_SESSION['user_id']]);
        
        $_SESSION['username'] = $username;

        header("Location: ../Pages/Beranda.php");
        exit;
    }
}

function check_avaible_uid($uid){
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE uid=?");
    $stmt->execute([$uid]);

    return $stmt->fetchColumn() > 0;
}

function check_avaible_email($email){
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email=?");
    $stmt->execute([$email]);

    return $stmt->fetchColumn() > 0;
}
?>
