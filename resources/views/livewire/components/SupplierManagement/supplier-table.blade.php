{{-- // --}}
<div class="relative ">


    <div class="relative overflow-hidden bg-white border border-black shadow-lg sm:rounded-lg">

        {{-- //* filters --}}
        <div class="flex flex-row items-center justify-between px-2 py-4 ">

            {{-- //* search filter --}}
            <div class="relative w-full">

                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">

                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 " fill="currentColor" viewbox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                </div>

                <input type="text" wire:model.live.debounce.100ms="search"
                    class="w-1/3 p-2 pl-10 hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out border-[rgb(53,53,53)] text-[rgb(53,53,53)] rounded-lg cursor-pointer text-s bg-gray-50 focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Search by Company Name" required="" />


            </div>


            <div class="flex flex-row items-center justify-center gap-4">

                {{-- //*user type filter --}}
                <div class="flex flex-row items-center gap-2">



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
        <div class="overflow-x-auto overflow-y-scroll scroll h-[500px] ">

            <table class="w-full h-10 text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                    <tr class=" text-nowrap">

                        {{-- //* company name --}}
                        <th wire:click="sortByColumn('company_name')" scope="col"
                            class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                            <div class="flex items-center">

                                <p>Company Name</p>

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

                        {{-- //* status --}}
                        <th scope="col" class="px-4 py-3 text-center">Status</th>

                        {{-- //* province --}}
                        <th scope="col" class="px-4 py-3">Province</th>

                        {{-- //* city / municipality --}}
                        <th scope="col" class="px-4 py-3">City / Municipality</th>

                        {{-- //* barangay --}}
                        <th scope="col" class="px-4 py-3">Barangay</th>

                        {{-- //* street --}}
                        <th scope="col" class="px-4 py-3">Street</th>

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

                                <p>Updated at</p>

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
                        <th scope="col" class="px-4 py-3 text-nowrap">Actions</th>
                        </th>


                    </tr>
                </thead>

                {{-- //* table body --}}
                <tbody>

                    @foreach ($suppliers as $supplier)

                    <tr
                        class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">

                        {{-- //* contact number --}}
                        <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $supplier->company_name }}
                        </th>

                        <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $supplier->contact_number }}
                        </th>

                        {{-- //* status --}}
                        <th scope="row"
                            class="px-4 py-6 font-medium text-center pointer-events-none text-md whitespace-nowrap">

                            {{-- //* active green, if inactive red --}}
                            <p @if ($supplier->statusJoin->status_type == "Active") class=" text-black bg-green-400
                                border
                                border-green-900 text-xs text-center font-medium px-2 py-0.5 rounded"

                                @elseif ($supplier->statusJoin->status_type == "Inactive")

                                class=" text-black bg-rose-400 border border-red-900 text-xs font-medium px-2 py-0.5
                                rounded " @endif>

                                {{ $supplier->statusJoin->status_type }}
                            </p>

                        </th>

                        <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $supplier->addressJoin->provinceJoin->province_description }}
                        </th>

                        <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $supplier->addressJoin->cityJoin->city_municipality_description }}
                        </th>

                        <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $supplier->addressJoin->barangayJoin->barangay_description }}
                        </th>

                        <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $supplier->addressJoin->street }}
                        </th>

                        {{-- //* created at --}}
                        <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $supplier->created_at->format('d-m-y h:i A') }}
                        </th>

                        {{-- //* updated at --}}
                        <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $supplier->updated_at->format('d-m-y h:i A') }}
                        </th>

                        <th class="px-4 py-6 text-center text-md text-nowrap">
                            <div
                                class="flex items-center justify-center px-1 py-1 font-medium text-blue-600 rounded-md hover:bg-blue-100 ">

                                <button x-on:click="showModal=true;$wire.getSupplierID({{ $supplier->id }})">

                                    <div class="flex items-center">

                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
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

                {{ $suppliers->links() }}

            </div>

            {{-- //* per page --}}
            <div class="flex items-center px-4 py-2 mb-3">

                <label class="text-sm font-medium text-gray-900 w-15">Per Page</label>

                <select wire:model.live="perPage"
                    class="bg-[rgb(243,243,243)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 p-2.5 ml-4">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>

            </div>


        </div>

    </div>


</div>
