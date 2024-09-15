<div class="grid grid-cols-9 col-span-2 gap-5 py-4 mb-5 justify-evenly">
    <div class="content-start col-span-3 px-8 py-5 text-left duration-1000 ease-in-out border rounded-md shadow-md border-lime-900 shadow-lime-900 "
        style="background-image: linear-gradient(115deg, #dcfdd6, #81ff7f)">
        <div class="grid grid-cols-3">
            <div class="col-span-2">
<<<<<<< Updated upstream
                <p class="pb-3 text-lg font-extrabold text-lime-800">Overall Sales</p>
                <p class="text-3xl font-black text-lime-900">P{{ number_format($overallSales, 2) }}</p>
=======
                <p class="pb-3 text-lg font-extrabold text-lime-800">Current Sales</p>
                <p class="text-3xl font-black text-lime-900">P{{ $currentSales }}</p>
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
                <p class="text-3xl font-black text-yellow-900">P{{ $overallStocks }}</p>
            </div>
            <div class="col-span-1 m-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="text-lime-900 size-16">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
=======
                <p class="text-3xl font-black text-yellow-900">P{{ $currentSales }}</p>
            </div>
            <div class="col-span-1 m-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                    stroke="currentColor" class="text-yellow-900 size-16">
                    <path strokeLinecap="round" strokeLinejoin="round"
                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
>>>>>>> Stashed changes
                </svg>
            </div>
        </div>
    </div>
    <div class="content-start col-span-3 px-8 py-5 text-left duration-1000 ease-in-out border border-teal-900 rounded-md shadow-md shadow-teal-900 "
        style="background-image: linear-gradient(115deg, #d6fafd, #7fffff)">
        <div class="grid grid-cols-3">
            <div class="col-span-2">
<<<<<<< Updated upstream
                <p class="pb-3 text-lg font-extrabold text-teal-800">Returns</p>
                <p class="text-3xl font-black text-teal-900">P{{ $overallReturn }}</p>
            </div>
            <div class="col-span-1 m-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="text-lime-900 size-16">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
=======
                <p class="pb-3 text-lg font-extrabold text-teal-800">Users</p>
                <p class="text-3xl font-black text-teal-900">P{{ $currentSales }}</p>
            </div>
            <div class="col-span-1 m-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                    stroke="currentColor" class="text-teal-900 size-16">
                    <path strokeLinecap="round" strokeLinejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>

>>>>>>> Stashed changes
            </div>
        </div>
    </div>
</div>
