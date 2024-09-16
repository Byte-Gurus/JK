<div class="grid grid-cols-9 col-span-2 gap-5 py-4 mb-5 justify-evenly">
    <div class="content-start col-span-3 px-8 py-5 text-left duration-1000 ease-in-out border rounded-md shadow-md border-lime-900 shadow-lime-900 "
        style="background-image: linear-gradient(115deg, #dcfdd6, #81ff7f)">
        <div class="grid grid-cols-3">
            <div class="col-span-2">
                <p class="pb-3 text-lg font-extrabold text-lime-800">Overall Sales</p>
                <p class="text-3xl font-black text-lime-900">P{{ number_format($overallSales, 2) }}</p>
            </div>
            <div class="col-span-1 m-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="text-lime-900 size-16">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
            </div>
        </div>
    </div>
    <div class="content-start col-span-3 px-8 py-5 text-left duration-1000 ease-in-out border border-yellow-900 rounded-md shadow-md shadow-yellow-900 "
        style="background-image: linear-gradient(115deg, #f5fdd6, #fff47f)">
        <div class="grid grid-cols-3">
            <div class="col-span-2">
                <p class="pb-3 text-lg font-extrabold text-yellow-800">Stocks-on-hand</p>
                <p class="text-3xl font-black text-yellow-900">P{{ $overallStocks }}</p>
            </div>
            <div class="col-span-1 m-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="text-lime-900 size-16">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
            </div>
        </div>
    </div>
    <div class="content-start col-span-3 px-8 py-5 text-left duration-1000 ease-in-out border border-teal-900 rounded-md shadow-md shadow-teal-900 "
        style="background-image: linear-gradient(115deg, #d6fafd, #7fffff)">
        <div class="grid grid-cols-3">
            <div class="col-span-2">
                <p class="pb-3 text-lg font-extrabold text-teal-800">Returns</p>
                <p class="text-3xl font-black text-teal-900">P{{ $overallReturn }}</p>
            </div>
            <div class="col-span-1 m-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="text-lime-900 size-16">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
            </div>
        </div>
    </div>
</div>
