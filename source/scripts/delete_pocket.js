const blank = document.getElementById('blank-label');

document.querySelectorAll('.delete-pocket').forEach(button => {
  button.addEventListener('click', function () {
      try {
          currentCard = this.closest('.pocket-card');
          if (!currentCard) throw new Error("Elemen pocket-card tidak ditemukan.");

          const pocketNameEl = currentCard.querySelector('.pocket-name-value');
          if (!pocketNameEl) throw new Error("Elemen pocket-name-value tidak ditemukan.");

          selectedPocketName = pocketNameEl.innerText.trim(); // simpan global
          console.log("selectedPocketName:", selectedPocketName);

          // Tampilkan modal
          document.getElementById("modal-confirm-delete-pocket").style.display = "flex";
      } catch (error) {
          console.error("Terjadi kesalahan:", error);
          alert(error.message);
      }
  });
});


function confirm_delete_pocket() {
  if (!selectedPocketName) {
    alert("Tidak ada kantong yang dipilih untuk dihapus.");
    return;
  }

  fetch(`../api/get_avaible_pocket.php?pocket_name=${encodeURIComponent(selectedPocketName)}`)
    .then(response => {
      if (!response.ok) throw new Error("Gagal menghubungi server.");
      return response.json();
    })
    .then(data => {
      if (!data || !data.target_amount) {
        throw new Error("Data target tidak valid atau kosong.");
      }
      ToDatabase(selectedPocketName);
      close_modal_confirm_delete_pocket();
    })
    .catch(error => {
      console.error("Gagal ambil data target_amount:", error);
      alert("Gagal mengambil data kantong. Coba lagi nanti.");
    });
}


function ToDatabase(pocket_name) {
  fetch('../api/delete_pocket.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      pocket: pocket_name
    })
  })
  .then(response => {
    if (!response.ok) throw new Error("Gagal menghubungi server saat update saldo.");
    return response.json();
  })
  .then(data => {
    if (data.success) {
      console.log('Saldo berhasil disimpan');

    // Hapus elemen dari tampilan
    if (currentCard) {
      currentCard.remove();
      loadEmptylabel();
    } 

    // Tutup modal
    close_modal_confirm_delete_pocket();
    } else {
      alert('Gagal menyimpan saldo: ' + (data.message || 'Unknown error'));
    }
  })
  .catch(error => {
    console.error('Error saat post saldo:', error);
    alert("Terjadi kesalahan saat menyimpan saldo.");
  });
}