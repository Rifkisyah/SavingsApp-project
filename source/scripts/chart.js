window.addEventListener('DOMContentLoaded', function () {
    const monthLabels = ["Jan", "Feb", "Mar", "Apr", "Mei", "Juni", "Juli", "Agu", "Sep", "Okt", "Nov", "Des"];
    
    const minBalance = 0;
    let maxBalance = 10000000;
    
    const incomingBalance = [1000000, 2000000, 3000000, 2500000, 2700000, 2800000, 2600000, 2400000, 2300000, 2200000, 2100000, 2000000];
    const outgoingBalance = [800000, 1000000, 1200000, 900000, 950000, 1100000, 1000000, 980000, 920000, 940000, 960000, 970000];

    let selectedClass = '8_digits'; // default
    let chart; // deklarasi global supaya bisa dipanggil di changeDigit()

    const canvas = document.getElementById('chart-canvas');
    chart = new Chart(canvas, {
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

    // Ambil tombol filter digit
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            selectedClass = [...btn.classList].find(cls => cls.endsWith('_digits'));
        });
    });

    // Tombol apply filter
    document.getElementById('apply-filter-btn').addEventListener('click', () => {
        changeDigit();
    });

    function changeDigit() {
        switch (selectedClass) {
            case '6_digits':
                maxBalance = 100000;
                break;
            case '7_digits':
                maxBalance = 1000000;
                break;
            case '8_digits':
                maxBalance = 10000000;
                break;
            case '9_digits':
                maxBalance = 100000000;
                break;
            default:
                maxBalance = 10000000;
        }

        chart.options.scales.y.max = maxBalance;
        chart.update();
    }
});
