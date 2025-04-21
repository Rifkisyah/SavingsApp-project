const monthLabels = ["Jan", "Feb", "Mar", "Apr", "Mei", "Juni", "Juli", "Agu", "Sep", "Okt", "Nov", "Des"];
const minBalance = 0;
const maxBalance = 10000000;
const incomingBalance = [500000, 1000000, 800000];
const outgoingBalance = [300000, 400000, 200000];

const canvas = document.getElementById('chart-canvas');
const chart = new Chart(canvas, {
    type: "line",
    data: {
        labels: monthLabels,
        datasets: [
            {
                label: "Pemasukan",
                data: incomingBalance,
                borderColor: "green",
                tension: 0.3
            },
            {
                label: "Pengeluaran",
                data: outgoingBalance,
                borderColor: "red",
                tension: 0.3
            }
        ]
    },
    options: {
        plugins: {
            legend: {
                display: true
            }
        },
        scales: {
            y: {
                min: minBalance,
                max: maxBalance,
                ticks: {
                    stepSize: 1000000,
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            },
            x: {
                ticks: {
                    autoSkip: false,
                    maxRotation: 0,
                    minRotation: 0
                }
            }
        }
    }
});
