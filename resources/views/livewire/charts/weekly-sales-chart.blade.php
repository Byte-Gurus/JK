<div>

    <input type="week" wire:model.live="week" />
    <div wire:ignore>
        <canvas width="400" height="100" id="weekChart"></canvas>
    </div>
</div>
@assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets
@script
    <script>
        const perWeek = document.getElementById('weekChart');

        Livewire.on('weeklyTotalUpdated', (weeklyTotal) => {

            dates = [];
            datas = [];
            if (Chart.getChart("weekChart")) {
                Chart.getChart("weekChart")?.destroy();
            }

            weekly = $wire.weeklyTotal;
            console.log('Weekly Total:', weekly);


            for (let index = 0; index < weekly.length; index++) {

                dates[index] = weekly[index].date;
                datas[index] = weekly[index].totalAmount;

            }


            // console.log(dates, datas);
            new Chart(perWeek, {
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
