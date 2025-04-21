function setCategory(category) {
    document.getElementById('selected-category').value = category;

    // Sembunyikan pesan error kalau user udah pilih kategori
    const error = document.getElementById('error-message');
    if (error) error.style.display = 'none';
}

function validateCategorySelection() {
    const selectedCategory = document.getElementById('selected-category').value.trim();

    if (!selectedCategory) {
        let error = document.getElementById('error-message');

        // Kalau belum ada elemen error-message, buat manual
        if (!error) {
            error = document.createElement('p');
            error.id = 'error-message';
            error.innerText = 'Terjadi Masalah, Kategori Belum Dipilih!';
            const form = document.querySelector('.modal-content');
            form.appendChild(error);
        } else {
            error.style.display = 'block';
            error.innerText = 'Terjadi Masalah, Kategori Belum Dipilih!';
        }

        return false; // Cegah submit
    }

    return true; // Lanjutkan submit
}

