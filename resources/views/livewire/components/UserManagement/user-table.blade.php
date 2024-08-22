{{-- // --}}
<div class="relative bg-black rounded-lg" wire:poll.visible="1000ms">


    <div class="relative overflow-hidden bg-white border border-[rgb(143,143,143)] sm:rounded-lg">

        {{-- //* filters --}}
        <div class="flex flex-row items-center justify-between px-2 py-4 ">

            {{-- //* search filter --}}
            <div class="relative w-full">

                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black " fill="none" viewBox="0 0 24 24"
                        strokeWidth={1.5} stroke="currentColor" className="size-6">
                        <path strokeLinecap="round" strokeLinejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>

                <input type="text" wire:model.live.debounce.100ms = "search"
                    class="w-1/3 p-2 pl-10 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-black text-[rgb(53,53,53)] rounded-md cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Search by Name or Username" required="" />


            </div>


            <div class="flex flex-row items-center justify-center gap-4">

                {{-- //*user type filter --}}
                <div class="flex flex-row items-center gap-2">

                    <label class="text-sm font-medium text-gray-900 text-nowrap">User Type :</label>

                    <select wire:model.live="roleFilter"
                        class="bg-gray-50 border hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out border-[rgb(53,53,53)] text-[rgb(53,53,53)] text-sm rounded-lg block p-2.5 ">
                        <option value="0">All</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role }}</option>
                        @endforeach
                    </select>

                </div>


                <div class="flex flex-row items-center">

                    <div class="flex flex-row items-center gap-2">

                        <label class="text-sm font-medium text-gray-900 text-nowrap">Status :</label>

                        <select wire:model.live="statusFilter"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-lg  block p-2.5 ">
                            <option value="0">All</option>
                            <option value="1">Active</option>
                            <option value="2">Inactive</option>

                        </select>

                    </div>
                </div>
            </div>
        </div>


        {{-- //* tablea area --}}
        <div class="overflow-x-auto overflow-y-scroll scroll no-scrollbar h-[500px] ">

            <table class="w-full h-10 text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                    <tr class=" text-nowrap">

                        {{-- //* user image --}}
                        {{-- <th scope="col" class="px-4 py-3"></th> --}}

                        {{-- //* name --}}
                        <th wire:click="sortByColumn('firstname')" scope="col"
                            class="flex flex-row items-center justify-between gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                            <div class="flex items-center">
                                <p>Name</p>

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </span>

                            </div>

                        </th>

                        {{-- //* contact number --}}
                        <th scope="col" class="px-4 py-3">Contact No</th>

                        {{-- //* role --}}
                        <th scope="col" class="px-4 py-3">Role</th>

                        {{-- //* status --}}
                        <th scope="col" class="px-4 py-3 text-center">Status</th>

                        {{-- //* username --}}
                        <th scope="col" class="px-4 py-3">Username</th>

                        {{-- //* created at --} --}}
                        <th wire:click="sortByColumn('created_at')" scope="col"
                            class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                            <div class="flex items-center">

                                <p>Created at</p>

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </span>

                            </div>
                        </th>

                        {{-- //* updated at --}}
                        <th wire:click="sortByColumn('updated_at')" scope="col"
                            class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                            <div class="flex items-center">

                                <p>Updated at at</p>

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </span>

                            </div>
                        </th>

                        {{-- //* action --}}
                        <th scope="col" class="px-4 py-3 text-center text-nowrap">Actions</th>
                        </th>

                    </tr>
                </thead>

                {{-- //* table body --}}
                <tbody>

                    @foreach ($users as $user)
                        <tr
                            class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">

                            {{-- user image --}}
                            {{-- <th scope="row"
                                class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                @if ($user->user_image)
                                    <img class="w-16 h-16 rounded-full" src="{{ $user->user_image }}">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="0.8"
                                        stroke="currentColor" class="w-16 h-16 border border-black rounded-full">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"
                                            fill="white" />
                                    </svg>
                                @endif
                            </th> --}}


                            {{-- //* name --}}
                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $user->firstname . ' ' . $user->middlename . ' ' . $user->lastname }}
                            </th>

                            {{-- //* contact number --}}
                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $user->contact_number }}
                            </th>

                            {{-- //* role --}}
                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $user->roleJoin->role }}
                            </th>

                            {{-- //* status --}}
                            <th scope="row"
                                class="px-4 py-6 font-medium text-center pointer-events-none text-md whitespace-nowrap">

                                {{-- //* active green, if inactive red --}}
                                <p
                                    @if ($user->statusJoin->status_type == 'Active') class=" text-black  bg-green-400 border border-green-900   text-xs text-center font-medium px-2 py-0.5 rounded"

                                        @elseif ($user->statusJoin->status_type == 'Inactive')

                                        class=" text-black bg-rose-400 border border-red-900 text-xs font-medium px-2 py-0.5 rounded " @endif>

                                    {{ $user->statusJoin->status_type }}
                                </p>

                            </th>

                            {{-- //* username --}}
                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $user->username }}
                            </th>

                            {{-- //* created at --}}
                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $user->created_at->format('d-m-y h:i A') }}
                            </th>

                            {{-- //* updated at --}}
                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $user->updated_at->format('d-m-y h:i A') }}
                            </th>

                            {{-- //* edit button --}}
                            <th class="px-4 py-6 text-center text-md text-nowrap">
                                <div
                                    class="flex items-center justify-center px-1 py-1 font-medium text-blue-600 rounded-md hover:bg-blue-100 ">

                                    <button x-on:click="showModal=true;$wire.getUserID({{ $user->id }})">

                                        <div class="flex items-center">

                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </span>

                                            <div>
                                                <p>Edit</p>
                                            </div>

                                        </div>
                                    </button>
                                </div>
                            </th>
                        </tr>
                    @endforeach


                </tbody>

            </table>

        </div>

        {{-- //* table footer --}}
        <div class="border-t border-black ">

            {{-- //*pagination --}}
            <div class="mx-4 my-2 text-nowrap">

                {{ $users->links() }}

            </div>

            {{-- //* per page --}}
            <div class="flex items-center px-4 py-2 mb-3">

                <label class="text-sm font-medium text-gray-900 w-15">Per Page</label>

                <select wire:model.live = "perPage"
                    class="bg-[rgb(243,243,243)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 p-2.5 ml-4">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>

            </div>


        </div>

    </div>


</div>
