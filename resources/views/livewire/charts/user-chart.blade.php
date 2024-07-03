    <div>
        <div wire:ignore>
            <canvas width="400" height="100" id="myChart"></canvas>
        </div>

        @assets
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @endassets

        @script
            <script>
                const ctx = document.getElementById('myChart');


                const data = {
                    labels: ['Active', 'Inactive'],
                    datasets: [{
                        data: [{{ $activeUsersCount }}, {{ $inactiveUsersCount }}],
                        backgroundColor: [
                            'rgba(255, 99, 132)',
                            'rgba(255, 159, 64`)',
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
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
                                text: 'Users'
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
