<div x-cloak>
    <div>
        <div class="grid grid-flow-col grid-cols-2 gap-4">
            <div class="col-span-2">
                <div class="grid grid-flow-col grid-cols-2 gap-4 mb-4">
                    <div class="col-span-1 px-8 py-5 border border-red-900 rounded-md shadow-md shadow-red-900 "
                        style="background-image: linear-gradient(115deg, #ffcccc, #feaeae)">
                        <p class="pb-3 text-lg font-extrabold text-red-800">Total Amount (₱)</p>
                        <p class="text-3xl font-black text-red-900">{{ number_format($totalAmount, 2) }}</p>
                    </div>
                    <div class="col-span-1 px-8 py-5 border border-purple-900 rounded-md shadow-md shadow-purple-900 "
                        style="background-image: linear-gradient(115deg, #ecc7fd, #c08df9)">
                        <p class="pb-3 text-lg font-extrabold text-purple-800">Transaction Count</p>
                        <p class="text-3xl font-black text-purple-900">{{ $transactionCount }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-4 bg-white border shadow-2xl border-[rgb(143,143,143)] rounded-lg">
            <div class="flex flex-row justify-between ">
                <div>
                    <p class="text-2xl text-[rgb(72,72,72)] italic font-black">Sales Performance - Daily</p>
                </div>

                <div class="col-span-1 ">
                    <input type="date" wire:model.live="day"
                        class="p-2 text-orange-900 transition-all duration-100 ease-in-out bg-orange-200 border border-orange-900 rounded-lg hover:font-bold hover:bg-orange-400 " />
                </div>
            </div>
            <canvas wire:ignore width="300" height="100" id="dailyChart"></canvas>
        </div>
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
