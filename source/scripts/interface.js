function toggle_side_nav(){
    const sidenav = document.getElementById('side-nav');
    const content = document.getElementById('wrapper-content');
    const content_dashboard_footer = document.getElementById('dashboard-footer-content');
    const content_category = document.getElementById('pocket-page-category-container');
    const topnav_content = document.getElementById('topnav-content');
    const prim = document.getElementById('primary-content');
    const topnav_category = document.getElementById('category-topnav-content');
    // const cpyrg = document.getElementById('copyright');

    const currentWidth = getComputedStyle(sidenav).width;
    const isClosed = currentWidth === "0px";

    sidenav.style.width = isClosed ? "fit-content" : "0";

    content.style.marginLeft = isClosed ? "19.5%" : "0"; 
    content.style.marginRight = isClosed ? "0" : "0";
    prim.style.paddingLeft = isClosed ? "0" : "15%";
    // prim.style.marginRight = isClosed ? "11%" : "5%";
    topnav_content.style.marginLeft = isClosed ? "52%" : "70%";
    content_dashboard_footer.style.paddingLeft = isClosed ? "50%" : "40%";
    content_category.style.marginLeft = isClosed ? "0" : "0";
    topnav_category.style.marginLeft = isClosed ? "40%" : "50%";
}


function filterInput(input){
    input.value = input.value.replace(/[^0-9.-]/g, '');
}

function open_pocket_modal() {
    document.getElementById('gradient-overlay').style.display = "flex";
    document.getElementById('category-modal').style.display = "block";
    document.getElementById('pocket-modal').style.display = "flex";
}

function show_password(){
    let password = document.getElementById('password-field');
    if(password.type === 'password'){
        password.type = 'text';
    }else {
        password.type = 'password';
    }
}

function close_pocket_modal(){
    document.getElementById('gradient-overlay').style.display = "none";
    document.getElementById('category-modal').style.display = "none";
    document.getElementById('pocket-modal').style.display = "none";

    document.getElementById('pocket-name').value = "";
    document.getElementById('target-nominal').value = "";
    document.getElementById('target-date').value = "";
    document.getElementById('selected-category').value = "";
    document.getElementById('error-message').style.display = "none";
}

function open_modal_confirm_logout() {
    document.getElementById('modal-confirm-logout').style.display = 'flex';
}
function close_modal_confirm_logout() {
    document.getElementById('modal-confirm-logout').style.display = 'none';
}

function confirm_logout() {
    close_modal_confirm_logout();
    logout();
}

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

function open_modal_confirm_delete_pocket(){
    document.getElementById('modal-confirm-delete-pocket').style.display = 'flex';
}
function close_modal_confirm_delete_pocket(){
    document.getElementById('modal-confirm-delete-pocket').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.pocket-card').forEach(card => {
      const balanceEl = card.querySelector('.current-balance');
      const targetEl = card.querySelector('.target-item');
      const progressEl = card.querySelector('.progress-bar');
  
      if (!balanceEl || !targetEl || !progressEl) return;
  
      const balance = parseInt(balanceEl.innerText.replace(/[^0-9]/g, '')) || 0;
      const target = parseInt(targetEl.innerText.replace(/[^0-9]/g, '')) || 1; // jangan 0 biar nggak divide by zero
  
      const percent = (balance / target) * 100;
      progressEl.style.width = percent + '%';
  
      // Reset & atur warna
      progressEl.classList.remove('bg-danger', 'bg-warning', 'bg-success');
      if (percent < 30) {
        progressEl.classList.add('bg-danger');
      } else if (percent < 70) {
        progressEl.classList.add('bg-warning');
      } else {
        progressEl.classList.add('bg-success');
      }
    });
});

function loadEmptylabel() {
    const pocketContainer = document.getElementById('pocket-container');
    const blank = document.getElementById('blank-label');
    if (!blank || !pocketContainer) {
      console.warn("Elemen 'blank-label' atau 'pocket-container' tidak ditemukan.");
      return;
    }
  
    const pockets = pocketContainer.querySelectorAll('.pocket-card');
    blank.style.display = pockets.length === 0 ? 'grid' : 'none';
}
  

document.addEventListener('DOMContentLoaded', loadEmptylabel);


function goToCategory(category) {
    const encoded = encodeURIComponent(category);
    window.location.href = `../pages/category_opened.php?category=${encoded}`;
}