const input_new_pocket_modal = document.getElementById('target-nominal');

input_new_pocket_modal.addEventListener('input', function(e) {
  let value = e.target.value;

  // Hilangkan karakter selain angka
  value = value.replace(/[^0-9]/g, '');

  // Format dengan titik setiap 3 digit dari belakang
  let formatted = '';
  let reverse = value.split('').reverse().join('');
  for (let i = 0; i < reverse.length; i++) {
    if (i % 3 === 0 && i !== 0) {
      formatted += '.';
    }
    formatted += reverse[i];
  }
  formatted = formatted.split('').reverse().join('');

  // Tambahkan "Rp. " di depan
  if (formatted.length > 0) {
    formatted = 'Rp. ' + formatted;
  }

  // Update nilai input
  e.target.value = formatted;
});


const input_current_modal = document.getElementById('saldoInput');

input_current_modal.addEventListener('input', function(e) {
  let value = e.target.value;

  // Hilangkan karakter selain angka
  value = value.replace(/[^0-9]/g, '');

  // Format dengan titik setiap 3 digit dari belakang
  let formatted = '';
  let reverse = value.split('').reverse().join('');
  for (let i = 0; i < reverse.length; i++) {
    if (i % 3 === 0 && i !== 0) {
      formatted += '.';
    }
    formatted += reverse[i];
  }
  formatted = formatted.split('').reverse().join('');

  // Tambahkan "Rp. " di depan
  if (formatted.length > 0) {
    formatted = 'Rp. ' + formatted;
  }

  // Update nilai input
  e.target.value = formatted;
});

function formatRupiah(num) {
  num = num.toString().replace(/[^0-9]/g, '');
  let formatted = '';
  let reverse = num.split('').reverse().join('');
  for (let i = 0; i < reverse.length; i++) {
    if (i % 3 === 0 && i !== 0) {
      formatted += '.';
    }
    formatted += reverse[i];
  }
  return 'Rp. ' + formatted.split('').reverse().join('');
}

let total_balance = document.querySelectorAll('.summary-curency');
total_balance.forEach(el => {
  let num = el.innerText;
  el.innerText = formatRupiah(num);
});

let currentBalance = document.querySelectorAll('.current-balance');
currentBalance.forEach(el => {
  let num = el.innerText;
  el.innerText = formatRupiah(num);
});
