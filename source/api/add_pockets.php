<?php
    include "../controllers/connection.php";
    session_start();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_SESSION['open-pocket-modal'] = true;

        do {
            $pocket_id = bin2hex(random_bytes(4));
        } while (check_avaible_pocketId($pocket_id));

        $pocket_name = $_POST['pocket-name'];

        $target_nominal = preg_replace('/[^0-9]/', '', $_POST['target-nominal']);

        $date = $_POST['target-date'];
        if($date){
            $target_date = date('Y-m-d', strtotime($date));
        } else {
            $_SESSION['error'] = "Tanggal Invalid";
            // echo $_SESSION['error'];
            header("Location: ../pages/Beranda.php");
            exit;
        }

        if(isset($_POST['selected-category'])){
            if (empty($_POST['selected-category'])){
                $_SESSION['error'] = "Kategori Belum Dipilh";
                // echo $_SESSION['error'];
                header("Location: ../pages/Beranda.php");
                exit;
            } else {
                $category = $_POST['selected-category'];
            }
        } 

        $current_balance = 0;

        if(check_avaible_pocket($pocket_name)) {
            $_SESSION['error'] = "kantong Sudah Ada";
            // echo $_SESSION['error'];
            header("Location: ../pages/Beranda.php");
            exit;
        } else {
            try {
                $stmt = $conn->prepare("INSERT INTO pockets(pocket_id, pocket_name, target_amount, target_date, category_name, current_amount, user_id) VALUES(?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$pocket_id, $pocket_name, $target_nominal, $target_date, $category, $current_balance, $_SESSION['user_id']]);
                
                header("Location: ../pages/Beranda.php"); 
                exit();
            } catch (PDOException $e) {
                echo "Gagal menyimpan data: " . $e->getMessage();
            }
        }

    }
    function check_avaible_pocketId($pocket_id){
        global $conn;
        $stmt = $conn->prepare("SELECT COUNT(*) FROM pockets WHERE pocket_id=?");
        $stmt->execute([$pocket_id]);
    
        return $stmt->fetchColumn() > 0;
    }
    function check_avaible_pocket($pocket_name){
        global $conn;
        $stmt = $conn->prepare("SELECT COUNT(*) FROM pockets WHERE pocket_name=?");
        $stmt->execute([$pocket_name]);
    
        return $stmt->fetchColumn() > 0;
    }
?>