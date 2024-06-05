<div class="relative overflow-x-auto overflow-y-auto shadow-md ml-[242px] mr-[22px] sm:rounded-lg border border-black rounded-md">
    <div class="flex flex-row items-center justify-between bg-white dark:bg-gray-900] mx-[12px] my-2">
        <div class="fixed top-[200px]">
            <div
                class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="text" id="table-search"
                class="block pt-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search by Name or Username">
        </div>

        <div class="fixed top-[200px] right-[32px]">


            <div class="flex flex-row gap-2 border border-black">
                <button class="px-4 py-2 bg-red-100 ">filter1</button>
                <button class="px-4 py-2 bg-blue-100 ">filter2</button>
                <button class="px-4 py-2 bg-green-100 ">filter3</button>
            </div>
        </div>
    </div>

    <table class="w-full mt-16 text-sm text-left text-gray-500 rtl:text-right ">
        <thead class="text-xs text-white uppercase text-nowrap bg-[rgb(53,53,53)] dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Contact Number
                </th>
                <th scope="col" class="px-6 py-3">
                    Role
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Username
                </th>
                <th scope="col" class="px-6 py-3">
                    Password
                </th>
                <th scope="col" class="px-6 py-3">
                    Created at
                </th>
                <th scope="col" class="px-6 py-3">
                    Updated at
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach ($users as $user)
                <tr
                    class="items-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="flex items-center text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="px-6 pt-4">
                            <div class="flex items-center font-semibold">
                                {{ $user->firstname . ' ' . $user->middlename . ' ' . $user->lastname }}</div>
                        </div>
                    </th>
                    <td class="px-6 py-4 text-nowrap">
                        {{ $user->contact_number }}
                    </td>
                    <td class="px-6 py-4 text-nowrap">
                        <div class="flex items-center">
                            {{ $user->roleMethod->role }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-nowrap">
                        <div class="flex items-center">
                            {{ $user->status }}
                        </div>
                    </td>

                    <td class="px-6 py-4 text-nowrap">
                        <div class="flex items-center">
                            {{ $user->username }}
                        </div>
                    </td>

                    <td class="px-6 py-4 overflow-hidden text-nowrap">
                        <div class="flex items-center text-2xs">
                            {{ Str::limit($user->password, 10, '...') }}
                        </div>
                    </td>

                    <td class="px-6 py-4 text-nowrap">
                        <div class="flex items-center">
                            {{ $user->created_at }}
                        </div>
                    </td>

                    <td class="px-6 py-4 text-nowrap">
                        <div class="flex items-center">
                            {{ $user->updated_at }}
                        </div>
                    </td>


                    <td class="w-full px-6 py-4 text-nowrap">
                        <!-- Modal toggle -->
                        <a href="#" type="button" data-modal-target="UserModal"
                            data-modal-show="UserModal"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit user</a>
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
    <div class="fixed justify-end py-4">
        {{ $users->links() }}
    </div>

    @livewire('components.UserManagement.user-form')

</div>
