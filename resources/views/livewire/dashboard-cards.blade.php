<div class="grid grid-cols-12 col-span-2 gap-5 py-4 mb-5 justify-evenly">
    <div class="content-start col-span-3 px-8 py-5 text-left duration-1000 ease-in-out border rounded-md shadow-md border-lime-900 shadow-lime-900 "
        style="background-image: linear-gradient(115deg, #dcfdd6, #b9ffb8)">
        <div class="grid grid-cols-3">
            <div class="col-span-2">
                <p class="pb-3 text-lg font-extrabold text-lime-800">Overall Sales (₱)</p>
                <p class="text-2xl font-black text-lime-900">{{ number_format($overallSales, 2) }}</p>
            </div>
            <div class="col-span-1 m-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="text-lime-900 size-20 opacity-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
            </div>
        </div>
    </div>
    <div class="content-start col-span-3 px-8 py-5 text-left duration-1000 ease-in-out border border-yellow-900 rounded-md shadow-md shadow-yellow-900 "
        style="background-image: linear-gradient(115deg, #f5fdd6, #fef8b6)">
        <div class="grid grid-cols-3">
            <div class="col-span-2">
                <p class="pb-3 text-lg font-extrabold text-yellow-800">Stocks-on-hand</p>
                <p class="text-2xl font-black text-yellow-900">{{ $overallStocks }}</p>
            </div>
            <div class="col-span-1 m-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="text-yellow-900 size-20 opacity-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                </svg>
            </div>
        </div>
    </div>
    <div class="content-start col-span-3 px-8 py-5 text-left duration-1000 ease-in-out border border-teal-900 rounded-md shadow-md shadow-teal-900 "
        style="background-image: linear-gradient(115deg, #d6fafd, #bafefe)">
        <div class="grid grid-cols-3">
            <div class="col-span-2">
                <p class="pb-3 text-lg font-extrabold text-teal-800">Returns</p>
                <p class="text-2xl font-black text-teal-900">{{ $overallReturn }}</p>
            </div>
            <div class="col-span-1 m-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="text-teal-900 size-20 opacity-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
            </div>
        </div>
    </div>
    <div class="content-start col-span-3 px-8 py-5 text-left duration-1000 ease-in-out border border-pink-900 rounded-md shadow-md shadow-pink-900 "
        style="background-image: linear-gradient(115deg, #fcd6fd, #febdfe)">
        <div class="grid grid-cols-3">
            <div class="col-span-2">
                <p class="pb-3 text-lg font-extrabold text-pink-800">Delivery</p>
                <p class="text-2xl font-black text-pink-900">{{ $deliveryInProgress }}</p>
            </div>
            <div class="col-span-1 m-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="text-pink-900 size-20 opacity-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                </svg>
            </div>
        </div>
    </div>
</div>
