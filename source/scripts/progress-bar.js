let mode = 'add';
let balance = 0;
let pocket_name = document.getElementById('pocket-name-value').innerText.trim();

const currentPocket = pocketData.find(p => p.name === pocket_name);
const target = currentPocket ? parseInt(currentPocket.target) : 0;

function openModal(type) {
  mode = type;
  document.getElementById('saldoModal').style.display = 'flex';
  document.getElementById('modalTitle').innerText = (type === 'add') ? 'Tambahkan uang' : 'Kurangi Uang';
  document.getElementById('saldoInput').value = '';
}

function closeModal() {
  document.getElementById('saldoModal').style.display = 'none';
}

function cleanRupiah(input) {
    return input.replace(/[^0-9]/g, '');
}

function submitSaldo() {
    let current_balance = document.getElementById('current-balance');
    const rawValue = document.getElementById('saldoInput').value;
    const cleanValue = cleanRupiah(rawValue);
    const value = parseInt(cleanValue);

    if (isNaN(value) || value <= 0) {
        alert('Masukkan nominal yang valid!');
        return;
    }
    if (mode === 'add') {
        balance += value;
        if (balance > target) balance = target;
        // current_balance.innerText = formatRupiah(balance);
        postToDatabase(pocket_name, current_balance);
    } else {
        balance -= value;
        if (balance < 0) balance = 0;
        // current_balance.innerText = formatRupiah(balance);
        postToDatabase(pocket_name, current_balance);
    } 

    updateProgress();
    closeModal();
}

function updateProgress() {
  const percent = (balance / target) * 100;
  document.getElementById('progressBar').style.width = percent + '%';
  document.getElementById('current-balance').textContent = balance;
}

function postToDatabase(pocket_name, balance) {
    fetch('../api/update-current-balance.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' // Kirim dalam format JSON
        },
        body: JSON.stringify({
            pocket: pocket_name,
            balance: balance
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Saldo berhasil disimpan!');
        } else {
            alert('Gagal menyimpan saldo: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
