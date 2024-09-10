<div>

    <select name="year" id="year" wire:model.live="year">
        <option value="">Select a year</option>
        @for ($year = 2000; $year <= 2050; $year++)
            <option value="{{ $year }}">{{ $year }}</option>
        @endfor
    </select>

    <div wire:ignore>
        <canvas width="400" height="100" id="yearChart"></canvas>
    </div>
</div>
@assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets
@script
    <script>
        const perYear = document.getElementById('yearChart');

        Livewire.on('yearlyTotalUpdated', (yearlyTotal) => {

            dates = [];
            datas = [];
            if (Chart.getChart("yearChart")) {
                Chart.getChart("yearChart")?.destroy();
            }

            yearly = $wire.yearlyTotal;
            console.log('Weekly Total:', yearly);


            for (let index = 0; index < yearly.length; index++) {

                dates[index] = yearly[index].date;
                datas[index] = yearly[index].totalAmount;

            }


            // console.log(dates, datas);
            new Chart(perYear, {
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
