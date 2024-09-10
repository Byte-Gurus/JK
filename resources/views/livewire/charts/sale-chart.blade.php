<div>

    <div class="flex flex-row gap-2">
        <div class="flex flex-row items-center gap-2">
            <div>
                Date
            </div>
            <div class="rounded-md">
                @if ($selectPicker == 1)
                    <input type="date" wire:model.live="day" />
                @elseif ($selectPicker == 2)
                    <input type="week" wire:model.live="week" />
                @elseif ($selectPicker == 3)
                    <input type="month" wire:model.live="month" />
                @elseif ($selectPicker == 4)
                    <select id="year" wire:model.live="year"
                        class="bg-[rgb(255,206,121)] p-3 border border-[rgb(143,143,143)] text-gray-900 text-md font-black rounded-sm block w-full">
                        <option value="2024" selected>2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                        <option value="2020">2020</option>
                    </select>
                @endif
            </div>

        </div>
        <div>
            <select id="selectPicker" wire:model.live="selectPicker"
                class="bg-[rgb(255,206,121)] p-3 border border-[rgb(143,143,143)] text-gray-900 text-md font-black rounded-sm block w-full">
                <option value="0" selected>Overall Sales</option>
                <option value="1">Daily Sales</option>
                <option value="2">Weekly Sales</option>
                <option value="3">Monthly Sales</option>
                <option value="4">Yearly Sales</option>
            </select>
        </div>
    </div>

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
