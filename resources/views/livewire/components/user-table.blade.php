<div class="relative overflow-x-auto overflow-y-auto shadow-md ml-[250px] sm:rounded-lg border border-black rounded-md">
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
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
                            {{ $user->password }}
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
                        <a href="#" type="button" data-modal-target="editUserModal"
                            data-modal-show="editUserModal"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit user</a>
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
    <div class="fixed justify-end py-4">
        {{ $users->links() }}
    </div>

    @livewire('components.user-form')

</div>
