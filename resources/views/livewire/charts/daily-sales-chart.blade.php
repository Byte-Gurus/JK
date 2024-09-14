<div x-cloak class="p-4 bg-white border border-black rounded-lg">
    <div wire:ignore >
        <div class="grid grid-flow-col grid-cols-4">
            <div class="flex flex-row items-center justify-between col-span-3 gap-4">
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
            </div>
            <div class="col-span-1 ">
                <input type="date" wire:model.live="day" class="border border-black " />
            </div>
        </div>
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
