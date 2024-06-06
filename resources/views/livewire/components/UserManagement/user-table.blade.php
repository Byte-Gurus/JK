<div
    class="relative overflow-x-auto overflow-y-auto shadow-md ml-[242px] mr-[22px] mb-[22px] sm:rounded-lg border border-black rounded-md">
    <div class="">
        <!-- Start coding here -->
        <div class="relative overflow-hidden bg-white shadow-md sm:rounded-lg">
            <div class="flex items-center justify-between p-4 d">
                <div class="flex w-full">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 " fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" wire:model.live.debounce.300ms = "search"
                            class="w-1/3 p-2 pl-10 text-gray-900 border border-gray-300 rounded-lg text-s bg-gray-50 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Search by Name or Username" required=""/>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <div class="flex items-center space-x-3">
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
            <div class="overflow-x-auto overflow-y-scroll h-[500px]">
                <table class="w-full h-10 text-sm text-left text-gray-500">
                    <thead class="text-xs text-white uppercase pointer-events-none bg-[rgb(53,53,53)]">
                        <tr>
                            <th scope="col" class="px-4 py-3">Name</th>
                            <th scope="col" class="px-4 py-3">Contact No</th>
                            <th scope="col" class="px-4 py-3">Role</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                            <th scope="col" class="px-4 py-3">Username</th>
                            <th scope="col" class="px-4 py-3">Passwords</th>
                            <th scope="col" class="px-4 py-3">Created at</th>
                            <th scope="col" class="px-4 py-3">Updated at</th>
                            <th scope="col" class="px-4 py-3">Actions</th>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b border-[rgb(53,53,53)]">
                                <th scope="row" class="px-4 py-6 font-medium text-gray-900 whitespace-nowrap ">
                                    {{ $user->firstname . ' ' . $user->middlename . ' ' . $user->lastname }}
                                <th scope="row" class="px-4 py-6 font-medium text-gray-900 whitespace-nowrap ">
                                    {{ $user->contact_number }}</th>
                                <th scope="row" class="px-4 py-6 font-medium text-gray-900 whitespace-nowrap ">
                                    {{ $user->roleMethod->role }}</th>
                                <th scope="row" class="px-4 py-6 font-medium text-gray-900 whitespace-nowrap ">
                                    {{ $user->status }}</th>
                                <th scope="row" class="px-4 py-6 font-medium text-gray-900 whitespace-nowrap ">
                                    {{ $user->username }}</th>
                                <th scope="row" class="px-4 py-6 font-medium text-gray-900 whitespace-nowrap ">
                                    {{ $user->password }}</th>
                                <th scope="row" class="px-4 py-6 font-medium text-gray-900 whitespace-nowrap ">
                                    {{ $user->created_at }}</th>
                                <th scope="row" class="px-4 py-6 font-medium text-gray-900 whitespace-nowrap ">
                                    {{ $user->updated_at }}</th>
                                <th class="w-full px-4 py-6 text-nowrap">
                                    <a href="#" type="button" data-modal-target="UserModal"
                                        data-modal-show="UserModal"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit
                                        user</a>
                                </th>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="m-3 text-nowrap">
                {{ $users->links() }}
            </div>
            <div class="px-4 py-2">
                <div class="flex ">
                    <div class="flex items-center mb-3 space-x-4">
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
</div>

</div>
