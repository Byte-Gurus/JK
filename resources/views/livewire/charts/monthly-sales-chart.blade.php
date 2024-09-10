<div>

    <input type="month" wire:model.live="month" />
    <div wire:ignore>
        <canvas width="400" height="100" id="monthChart"></canvas>
    </div>
</div>
@assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets
@script
    <script>
        const perMonth = document.getElementById('monthChart');

        Livewire.on('monthlyTotalUpdated', (monthlyTotal) => {

            dates = [];
            datas = [];
            if (Chart.getChart("monthChart")) {
                Chart.getChart("monthChart")?.destroy();
            }

            monthly = $wire.monthlyTotal;
            console.log('Weekly Total:', monthly);


            for (let index = 0; index < monthly.length; index++) {

                dates[index] = monthly[index].date;
                datas[index] = monthly[index].totalAmount;

            }


            // console.log(dates, datas);
            new Chart(perMonth, {
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
