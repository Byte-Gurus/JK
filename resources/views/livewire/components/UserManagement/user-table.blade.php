<<<<<<< Updated upstream
{{-- <div
    class="relative overflow-x-auto overflow-y-auto shadow-md ml-[242px] mr-[22px] sm:rounded-lg border border-black rounded-md">
    <div class="flex flex-row items-center justify-between bg-white dark:bg-gray-900 mx-[12px] my-2">
        <div class="fixed top-[200px]">
            <div class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
=======
<div class="relative overflow-x-auto overflow-y-auto shadow-md ml-[242px] mr-[22px] sm:rounded-lg border border-black rounded-md">
    <div class="flex flex-row items-center justify-between bg-white dark:bg-gray-900] mx-[12px] my-2">
        <div class="absolute fixed top-[20px]">
            <div
                class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
>>>>>>> Stashed changes
                </svg>
            </div>
            <input type="text" id="table-search" wire:model.live.debounce.300ms = "search"
                class="block pt-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search by Name or Username">
        </div>

<<<<<<< Updated upstream
        <div class="fixed top-[200px] right-[32px]">
=======
        <div class="absolute top-[200px] right-[32px]">


>>>>>>> Stashed changes
            <div class="flex flex-row gap-2 border border-black">
                <button class="px-4 py-2 bg-red-100">filter1</button>
                <button class="px-4 py-2 bg-blue-100">filter2</button>
                <button class="px-4 py-2 bg-green-100">filter3</button>
            </div>
        </div>
    </div>

    <table class="w-full mt-16 text-sm text-left text-gray-500 rtl:text-right">
        <thead class="text-xs text-white uppercase bg-[rgb(53,53,53)] dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Name</th>
                <th scope="col" class="px-6 py-3">Contact Number</th>
                <th scope="col" class="px-6 py-3">Role</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Username</th>
                <th scope="col" class="px-6 py-3">Password</th>
                <th scope="col" class="px-6 py-3">Created at</th>
                <th scope="col" class="px-6 py-3">Updated at</th>
                <th scope="col" class="px-6 py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr
                    class="items-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="flex items-center text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $user->firstname . ' ' . $user->middlename . ' ' . $user->lastname }}
                    </th>
                    <th class="px-6 py-4 text-nowrap">{{ $user->contact_number }}
                    </th>
                    <th class="px-6 py-4 text-nowrap">
                        <div class="flex items-center">{{ $user->roleMethod->role }}</div>
                    </th>
                    <th class="px-6 py-4 text-nowrap">
                        <div class="flex items-center">{{ $user->status }}</div>
                    </th>
                    <th class="px-6 py-4 text-nowrap">
                        <div class="flex items-center">{{ $user->username }}</div>
                    </th>
                    <th class="px-6 py-4 overflow-hidden text-nowrap">
                        <div class="flex items-center text-2xs">{{ Str::limit($user->password, 10, '...') }}</div>
                    </th>
                    <th class="px-6 py-4 text-nowrap">
                        <div class="flex items-center">{{ $user->created_at }}</div>
                    </th>
                    <th class="px-6 py-4 text-nowrap">
                        <div class="flex items-center">{{ $user->updated_at }}</div>
                    </th>
                    <th class="w-full px-6 py-4 text-nowrap">
                        <a href="#" type="button" data-modal-target="UserModal" data-modal-show="UserModal"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit user</a>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="fixed justify-end py-4">{{ $users->links() }}</div>

    @livewire('components.UserManagement.user-form')
</div> --}}

<section class="mt-10">
    <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
        <!-- Start coding here -->
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <div class="flex items-center justify-between d p-4">
                <div class="flex">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" wire:model.live.debounce.300ms = "search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 "
                            placeholder="Search" required="">
                    </div>
                </div>
                <div class="flex space-x-3">
                    <div class="flex space-x-3 items-center">
                        <label class="w-40 text-sm font-medium text-gray-900">User Type :</label>
                        <select
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option value="">All</option>
                            <option value="0">User</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3">usernmae</th>

                            <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $user->username }}</th>

                            </tr>
                        @endforeach
                       
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>

            <div class="py-4 px-3">
                <div class="flex ">
                    <div class="flex space-x-4 items-center mb-3">
                        <label class="w-32 text-sm font-medium text-gray-900">Per Page</label>
                        <select
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
            </div>
                
        </div>
    </div>
</section>

</div>
