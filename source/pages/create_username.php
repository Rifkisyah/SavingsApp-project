<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=<div, initial-scale=1.0">
    <title>SavingsApp - Create username</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="icon" href="../../assets/images/Mini-icon-dummy.png">
</head>
<body class="new-username">
    <div class="new-username-container">
        <form method="post" action="../api/start_auth_session.php">
            <input type="hidden" name="proses" value="add-username">
            <h1>Buat Namamu Terlebih Dahulu :</h1>
            <input type="text" id="username" name="username" autocomplete="off" placeholder="Masukan Disini..." inputmode="text" pattern="^[a-zA-Z0-9 ]+$" oninput="this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '')"  required>
            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>