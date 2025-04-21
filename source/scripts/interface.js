function toggle_side_nav(){
    const sidenav = document.getElementById('side-nav');
    const content = document.getElementById('wrapper-content');
    const topnav_content = document.getElementById('topnav-content');
    const adds = document.getElementById('adds-wrapper');
    const prim = document.getElementById('primary-content');
    const cpyrg = document.getElementById('copyright');

    const currentWidth = getComputedStyle(sidenav).width;
    const isClosed = currentWidth === "0px";

    sidenav.style.width = isClosed ? "fit-content" : "0";
    content.style.marginLeft = isClosed ? "38vh" : "0";
    prim.style.paddingLeft = isClosed ? "0" : "30vh";
    topnav_content.style.marginLeft = isClosed ? "90vh" : "128vh";
    adds.style.display = isClosed ? "none" : "flex";
    prim.style.marginRight = isClosed ? "55vh" : "0";
    cpyrg.style.marginLeft = isClosed ? "60vh" : "80vh";
}

function filterInput(input){
    input.value = input.value.replace(/[^0-9.-]/g, '');
}

function check_pocket_modal() {
    const overlay = document.getElementById('gradient-overlay');
    const category = document.getElementById('category-modal');
    const pocket = document.getElementById('pocket-modal');

    const isHidden = overlay.style.display === "none" || overlay.style.display === "";

    overlay.style.display = isHidden ? "flex" : "none";
    category.style.display = isHidden ? "block" : "none";
    pocket.style.display = isHidden ? "flex" : "none";
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
    document.getElementById('pocket-name').value = "";
    document.getElementById('target-nominal').value = "";
    document.getElementById('target-date').value = "";
    document.getElementById('selected-category').value = "";
    check_pocket_modal();
}

function open_modal_confirm_logout() {
    document.getElementById('modal-confirm-logout').style.display = 'flex';
}
function close_modal_confirm_logout() {
    document.getElementById('modal-confirm-logout').style.display = 'none';
}

function confirm_logout() {
    close_confirm_logout_modal();
    logout();
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