let mode = 'add';
let balance = 0;
let target = 0;
let pocket_name = '';
let currentCard = null;

document.querySelectorAll('.add-balance, .withdraw-balance').forEach(button => {
  button.addEventListener('click', function () {
    try {
      mode = this.classList.contains('add-balance') ? 'add' : 'minus';
      currentCard = this.closest('.pocket-card');
      if (!currentCard) throw new Error("Elemen pocket-card tidak ditemukan.");

      const pocketNameEl = currentCard.querySelector('.pocket-name-value');
      if (!pocketNameEl) throw new Error("Elemen pocket-name-value tidak ditemukan.");

      pocket_name = pocketNameEl.innerText.trim();
      console.log("pocket_name:", pocket_name);

      const current_balance_el = currentCard.querySelector('.current-balance');
      if (!current_balance_el) throw new Error("Elemen current-balance tidak ditemukan.");

      balance = parseInt(current_balance_el.innerText.replace(/[^0-9]/g, '')) || 0;

      console.log("Minta data ke:", `../api/get_current_amount_pocket.php?pocket_name=${encodeURIComponent(pocket_name)}`);

      // Ambil data target dari server
      fetch(`../api/get_current_amount_pocket.php?pocket_name=${encodeURIComponent(pocket_name)}`)
        .then(response => {
          if (!response.ok) throw new Error("Gagal menghubungi server.");
          return response.json();
        })
        .then(data => {
          if (!data || !data.target_amount) {
            throw new Error("Data target tidak valid atau kosong.");
          }
          target = parseInt(data.target_amount);
          openModal(mode);
        })
        .catch(error => {
          console.error("Gagal ambil data target_amount:", error);
          alert("Gagal mengambil data kantong. Coba lagi nanti.");
        });

    } catch (error) {
      console.error("Terjadi kesalahan:", error);
      alert(error.message);
    }
  });
});

function openModal(type) {
  const modal = document.getElementById('saldoModal');
  const title = document.getElementById('modalTitle');
  const input = document.getElementById('saldoInput');

  if (!modal || !title || !input) {
    console.error("Modal atau elemen di dalamnya tidak ditemukan.");
    return;
  }

  modal.style.display = 'flex';
  title.innerText = (type === 'add') ? 'Tambahkan uang' : 'Kurangi Uang';
  input.value = '';
}

function closeModal() {
  const modal = document.getElementById('saldoModal');
  if (modal) modal.style.display = 'none';
}

function cleanRupiah(input) {
  return input.replace(/[^0-9]/g, '');
}

function submitSaldo() {
    const input = document.getElementById('saldoInput');
    if (!input) return alert("Input saldo tidak ditemukan.");
  
    const rawValue = input.value;
    const cleanValue = cleanRupiah(rawValue);
    const value = parseInt(cleanValue);
  
    if (isNaN(value) || value <= 0) {
      alert('Masukkan nominal yang valid!');
      return;
    }
  
    if (mode === 'add') {
      // Tambah saldo
      balance += value;
      if (balance > target) balance = target; // Cegah saldo lebih dari target
    } else if (mode === 'minus') {
      // Kurangi saldo
      balance -= value;
      if (balance < 0) balance = 0; // Cegah saldo menjadi negatif
    }
  
    // Update tampilan saldo
    const balanceEl = currentCard?.querySelector('.current-balance');
    if (balanceEl) {
      balanceEl.textContent = 'Rp ' + balance.toLocaleString(); // Format saldo dengan mata uang
    } else {
      console.warn("Elemen current-balance tidak ditemukan saat submit.");
    }
  
    // Update progress bar
    updateProgress();
    
    // Kirim data ke server
    postToDatabase(pocket_name, balance);
    
    // Tutup modal
    closeModal();
  }
  

function updateProgress() {
  try {
    const progressEl = currentCard?.querySelector('.progress-bar');
    if (!progressEl) throw new Error("Elemen progress-bar tidak ditemukan.");

      const percent = (balance / target) * 100;
      progressEl.style.width = percent + '%';

      // Reset warna dulu
      progressEl.classList.remove('bg-danger', 'bg-warning', 'bg-success');

      // Tambahkan warna sesuai nilai persen
      if (percent < 30) {
        progressEl.classList.add('bg-danger'); // Merah
      } else if (percent < 70) {
        progressEl.classList.add('bg-warning'); // Kuning
      } else {
        progressEl.classList.add('bg-success'); // Hijau
      }
    } catch (error) {
      console.error("Gagal update progress:", error.message);
    }
}

function postToDatabase(pocket_name, balance) {
  fetch('../api/update_current_balance.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      pocket: pocket_name,
      balance: balance
    })
  })
  .then(response => {
    if (!response.ok) throw new Error("Gagal menghubungi server saat update saldo.");
    return response.json();
  })
  .then(data => {
    if (data.success) {
      console.log('Saldo berhasil disimpan');
    } else {
      alert('Gagal menyimpan saldo: ' + (data.message || 'Unknown error'));
    }
  })
  .catch(error => {
    console.error('Error saat post saldo:', error);
    alert("Terjadi kesalahan saat menyimpan saldo.");
  });
}
