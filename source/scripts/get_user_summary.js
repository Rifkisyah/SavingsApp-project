document.addEventListener('DOMContentLoaded', function() {
  fetch('../api/get_user_summary.php')
    .then(response => response.json())
    .then(result => {
      if (result.success) {
        document.getElementById('total-summary').textContent = formatRupiah(result.summary.total_balance);
        document.getElementById('incoming-summary').textContent = formatRupiah(result.summary.incoming_balance);
        document.getElementById('outgoing-summary').textContent = formatRupiah(result.summary.outgoing_balance);
      } else {
        alert('Gagal ambil data: ' + result.message);
      }
    })
    .catch(error => {
      console.error('AJAX Error:', error);
    });
});
