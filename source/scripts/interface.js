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

function open_confirm_logout_modal() {
    document.getElementById('confirmModal').style.display = 'flex';
}

function close_confirm_logout_modal() {
    document.getElementById('confirmModal').style.display = 'none';
}

function confirm_logout() {
    close_confirm_logout_modal();
    logout();
}
