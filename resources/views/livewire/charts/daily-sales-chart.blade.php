<div>
    <input type="date" wire:model.live="day" />

    <p class="text-6xl font-extrabold">{{ $totalAmount }}</p>
    <p class="text-6xl font-extrabold">{{ $transactionCount }}</p>
    <div wire:ignore>
        <canvas width="400" height="100" id="dailyChart"></canvas>
    </div>
</div>
@assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets
@script
    <script>
        const perDay = document.getElementById('dailyChart');

        Livewire.on('DailyTotalUpdated', (dailyTotal) => {

            dates = [];
            datas = [];
            if (Chart.getChart("dailyChart")) {
                Chart.getChart("dailyChart")?.destroy();
            }

            daily = $wire.dailyTotal;
            console.log('daily Total:', dailyTotal);



            dates[0] = daily[0].date;
            datas[0] = daily[0].totalAmount;


            console.log(dates[0], datas[0]);

            // console.log(dates, datas);
            new Chart(perDay, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                        label: '# of Sales',
                        data: datas,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });


        });
    </script>
@endscript
