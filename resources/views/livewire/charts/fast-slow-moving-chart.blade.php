<div class="p-4 border h-full border-[rgb(143,143,143)] shadow-2xl bg-white rounded-lg ">
    <div class="flex flex-row items-center justify-between mb-3 ">
        <div>
            <p class="text-2xl text-[rgb(72,72,72)] italic font-black">Fast & Slow Moving Items</p>
        </div>
        <div>
            <input type="month" wire:model.live="month"
                class="p-2 text-orange-900 transition-all duration-100 ease-in-out bg-orange-200 border border-orange-900 rounded-lg hover:font-bold hover:bg-orange-400 " />
        </div>
    </div>

    <div class="flex content-end justify-end">
        <select id="selectTypeOfMovingItems" wire:model.live="selectTypeOfMovingItems"
            class="bg-gray-200 py-2 text-center w-full border border-[rgb(143,143,143)] text-gray-900 hover:bg-gray-300 active:bg-gray-500 duration-100 ease-in-out transition-all text-md font-black rounded-md block">
            <option value="0">Fast Moving Items</option>
            <option value="1">Slow Moving Items</option>
        </select>
    </div>

    <div wire:ignore class="w-full h-full">
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
            fast_slow = [];
            if (Chart.getChart("fastslowChart")) {
                Chart.getChart("fastslowChart")?.destroy();
            }

            fastmoving_info = $wire.fastmoving_info;
            console.log('item movement:', fastmoving_info);


            for (let index = 0; index < fastmoving_info.length; index++) {

                items[index] = fastmoving_info[index].item_name + ' ' + fastmoving_info[index].item_description;

                datas[index] = fastmoving_info[index].totalStockInQuantity;
                fast_slow[index] = fastmoving_info[index].fast_slow;
            }
            console.log('item movement:', items);

            // console.log(dates, datas);
            new Chart(perMonth, {
                type: 'bar',
                data: {
                    labels: items.map(name => {
                        let maxLength = 12;
                        if (name.length > maxLength) {
                            return name.substring(0, maxLength) + '...';
                        } else {
                            return name;
                        }
                    }),
                    datasets: [{
                        label: 'Item',
                        data: fast_slow,
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
                    plugins: {
                        tooltip: {
                            callbacks: {
                                title: function(tooltipItems) {
                                    let index = tooltipItems[0]
                                        .dataIndex; // Get the index of the item being hovered
                                    return items[index]; // Show the full item name in the tooltip title
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endscript
