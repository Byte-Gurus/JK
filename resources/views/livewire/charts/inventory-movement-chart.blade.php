<div>
    <div wire:ignore>
        <canvas width="400" height="100" id="operationChart"></canvas>
    </div>
</div>

@assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets

@script
    <script>
        const perOperation = document.getElementById('operationChart').getContext('2d');


        new Chart(perOperation, {
            type: 'doughnut',
            data: { // Use colon here
                labels: [
                    'Stock In',
                    'Stock Out',
                    'Add',
                    'Deduct'
                ],
                datasets: [{
                    label: 'Inventory Movement',
                    data: [
                        @json($Stock_In),
                        @json($Stock_Out),
                        @json($Add),
                        @json($Deduct)
                    ],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                // Remove scales as they are not needed for pie charts
            }
        });
    </script>
@endscript