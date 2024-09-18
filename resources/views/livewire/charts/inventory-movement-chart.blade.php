<div class="p-4 bg-white border h-full border-[rgb(143,143,143)] shadow-2xl rounded-lg">
    <div class="mb-4 text-left ">
        <p class=" text-2xl text-[rgb(72,72,72)] italic font-black">Inventory Movement</p>
    </div>
    <div wire:ignore class="flex justify-center ">
        <canvas class="w-full h-full"" id="operationChart"></canvas>
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
