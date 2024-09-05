<div>
    <div wire:ignore>


        <canvas width="400" height="100" id="saleChart"></canvas>
    </div>

    @assets
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endassets

    @script
        <script>
            const ctx = document.getElementById('saleChart');


            const data = {
                labels: ['Daily Sales'],
                datasets: [{
                    data: [{{ $dailyTotal }}],
                    backgroundColor: [
                        'rgba(255, 99, 132)',

                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',

                    ],
                    borderWidth: 1
                }]
            };

            new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Daily Sales'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        xAxes: [{
                            gridLines: {
                                display: false
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display: false
                            }
                        }]
                    }
                }
            });
        </script>
    @endscript
</div>

