function logout(){
    fetch("../controllers/logout.php", {
        method: "POST"
    })
    .then(response => {
        if (response.ok) {
            window.location.href = "../../public/index.php";
        } else {
            console.error("Logout gagal");
        }
    })
    .catch(error => {
        console.error("Terjadi kesalahan:", error);
    });
}