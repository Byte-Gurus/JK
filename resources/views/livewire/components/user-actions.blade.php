<div class=" ml-[250px] py-8 mr-8">
    <div class="flex flex-col justify-between">
        <div class="flex flex-row items-center justify-between">
            <div>
                <h1 class="text-[2em] font-bold pointer-events-none">Manage User</h1>
            </div>
            <div>
                <a href="#" type="button" data-modal-target="createUserModal" data-modal-show="createUserModal"
                    class=" px-4 py-2 text-sm font-bold bg-orange-200 border border-black rounded-md hover:bg-orange-300 hover:text-[rgb(53,53,53)]">Add
                    New User</a></button>
            </div>
        </div>
        <div class="flex flex-row items-center justify-between mt-4">
            <div class="bg-white  dark:bg-gray-900">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="table-search"
                        class="block pt-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search by Name or Username">
                </div>
            </div>
            <div class="flex flex-row gap-2 border border-black">
                <button class="px-4 py-2 bg-red-100 ">filter1</button>
                <button class="px-4 py-2 bg-blue-100 ">filter2</button>
                <button class="px-4 py-2 bg-green-100 ">filter3</button>
            </div>
        </div>
    </div>

    @livewire('components.user-create')

</div>
