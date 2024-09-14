<div>

    <div class="flex flex-row items-center justify-between gap-4">
        <div class="flex flex-row gap-2 my-2">
            <div class="p-2 bg-red-100 border border-black">
                <div>
                    <p class="font-thin">Total Amount</p>
                </div>
                <div class="">
                    <p class="text-4xl font-extrabold text-center">{{ $totalAmount }}</p>
                </div>
            </div>
            <div class="p-2 bg-purple-100 border border-black ">
                <div>
                    <p class="font-thin">Transaction Count</p>
                </div>
                <div>
                    <p class="text-4xl font-extrabold text-center">{{ $transactionCount }}</p>
                </div>
            </div>
        </div>
        <div>
            <div>
                <input type="week" wire:model.live="week" class="border border-black " />
            </div>
        </div>
    </div>

    <div wire:ignore class="border border-black">
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
