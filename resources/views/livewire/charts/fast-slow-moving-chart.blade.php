<div class="p-4 border border-[rgb(143,143,143)] shadow-2xl bg-white rounded-lg ">
    <div class="flex flex-row items-center justify-between ">
        <div>
            <p class="text-2xl text-[rgb(72,72,72)] italic font-black">Fast & Slow Moving Items</p>
        </div>
        <div>
            <input type="month" wire:model.live="month" class="p-2 text-orange-900 transition-all duration-100 ease-in-out bg-orange-200 border border-orange-900 rounded-lg hover:font-bold hover:bg-orange-400 " />
        </div>
    </div>

    <div wire:ignore class="">
        <div>
            <canvas class="w-full h-full" id="fastslowChart"></canvas>
        </div>
    </div>
</div>

@assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
@endassets
@script
    <script>
        const perMonth = document.getElementById('fastslowChart');


        Livewire.on('fastSlowUpdated', (fastmoving_info) => {

            items = [];
            datas = [];
            tsi = [];
            if (Chart.getChart("fastslowChart")) {
                Chart.getChart("fastslowChart")?.destroy();
            }

            fastSlow = $wire.fastmoving_info;
            console.log('item movement:', fastSlow);


            for (let index = 0; index < fastSlow.length; index++) {

                items[index] = fastSlow[index].item_name;
                datas[index] = fastSlow[index].totalStockInQuantity;
                tsi[index] = fastSlow[index].tsi;
            }
            console.log('item movement:', items);

            // console.log(dates, datas);
            new Chart(perMonth, {
                type: 'bar',
                data: {
                    labels: items,
                    datasets: [{
                        label: 'Item',
                        data: datas,
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },

                }
            });
        });
    </script>
@endscript
