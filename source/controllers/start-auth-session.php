<?php
include "connection.php";
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $action = $_POST['proses'];

    $uid;
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if($action == "daftar"){
        do {
            $uid = bin2hex(random_bytes(4));
        } while (check_avaible_uid($uid));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email tidak valid";
            header("Location: ../pages/Masuk.php");
            exit;
        } else if (strpos($email, '@') < 3) {
            $_SESSION['error'] = "Email Terlalu Pendek";
            header("Location: ../pages/Masuk.php");
            exit;
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

            header("Location: ../pages/Beranda.php");
            exit;
        }
    }

    if($action == "masuk"){
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
