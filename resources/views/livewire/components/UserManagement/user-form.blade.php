<div x-cloak x-show="showModal" x-data="{ showPassword: @entangle('show_password'), isCreate: @entangle('isCreate') }">
    <div class="fixed inset-0 z-40 bg-gray-900/50 dark:bg-gray-900/80"></div>
    <div
        class="fixed top-0 left-0 right-0 z-50 items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        {{-- <div id="UserModal" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"> --}}

        <div class="relative w-full max-w-2xl max-h-full mx-auto">
            <!-- Modal content -->
            @if (!$this->isCreate)
                {{-- if form is edit --}}
                <form class="relative bg-[rgb(238,238,238)] rounded-lg shadow " wire:submit.prevent="update">
            @endif
            <form class="relative bg-[rgb(238,238,238)] rounded-lg shadow " wire:submit.prevent="create">
                @csrf

                <div class="flex items-center justify-between px-6 py-2 border-b rounded-t ">
                    <div class="flex justify-center w-full p-2">
                        <h3 class="text-xl font-black text-gray-900 item ">

                            @if (!$this->isCreate)
                                {{-- if form is edit --}}
                                Edit User
                            @else
                                Create User
                            @endif

                        </h3>
                    </div>
                    <button type="button" x-on:click="showModal=false"
                        class="absolute right-[26px] inline-flex items-center justify-center w-8 h-8 text-sm text-[rgb(53,53,53)] bg-transparent rounded-lg hover:bg-[rgb(52,52,52)] transition duration-100 ease-in-out hover:text-gray-100 ms-auto "
                        data-modal-hide="UserModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>


                <div class="p-6 space-y-6">

                    <div class="flex flex-col gap-4">

                        <div class="border-2 border-[rgb(53,53,53)] rounded-md">
                            <div
                                class="p-2 border-b bg-[rgb(53,53,53)] text-[rgb(242,242,242)] pointer-events-none rounded-br-sm rounded-bl-sm">
                                <h1 class="font-bold">Personal Information</h1>
                            </div>
                            <div class="p-4">
                                <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">
                                    <div class="mb-3">
                                        <label for="firstname"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">First
                                            Name {{ $firstname }}</label>
                                        <input type="text" id="firstname" wire:model.live="firstname"
                                            class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                            placeholder="First Name" tabindex="2" required />
                                        @error('firstname')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="middlename"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Middle
                                            Name <span class="text-red-400 ">*</span></label>
                                        <input type="text" id="middlename" wire:model="middlename"
                                            class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                            placeholder="Middle Name" />
                                        @error('middlename')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">
                                    <div class="mb-3">
                                        <label for="lastname" class="block mb-2 text-sm font-medium text-gray-900 ">Last
                                            Name</label>
                                        <input type="text" id="lastname" wire:model="lastname"
                                            class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                            placeholder="Last Name" required />
                                        @error('lastname')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="contactno"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Contact
                                            No</label>
                                        <input type="number" id="contactno" wire:model="contact_number"
                                            class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                            placeholder="Contact No" required />
                                        @error('contact_number')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">
                                    <div class="mb-3">
                                        <label for="role"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Role</label>
                                        <select id="user_roles" wire:model="roleFilter"
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-lg block w-full p-2.5 ">

                                            <option selected>Select a role</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Cashier</option>
                                            <option value="3">Inventory Staff</option>
                                        </select>
                                        @error('role')
                                            <span class="error ">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="status"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Status</label>
                                        <select id="status" wire:model="status"
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                                            <option selected>Set your status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-2 border-[rgb(53,53,53)] rounded-md">
                            <div
                                class="p-2 border-b  bg-[rgb(53,53,53)] text-[rgb(242,242,242)] pointer-events-none rounded-br-sm rounded-bl-sm">
                                <h1 class="font-bold">Login Information</h1>
                            </div>
                            <div class="p-4">
                                <div class="mb-3">
                                    <label for="username"
                                        class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                                    <input type="text" id="username" wire:model="username" autocomplete="off"
                                        class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                        placeholder="Username" required />
                                    @error('username')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div x-show="showPassword" x-cloak class="transition-all duration-100 ease-in-out">
                                    <div class="mb-3">
                                        <label for="password" autocomplete="off"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Password</label>
                                        <input type="password" wire:model="password" id="password"
                                            class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5" />
                                        @error('password')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="retypepassword"
                                            class="block mb-2 text-sm font-medium text-gray-900">Re-type
                                            Password</label>
                                        <input type="password" id="retype_password" wire:model="retype_password"
                                            class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5" />
                                        @error('retype_password')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                @if (!$this->isCreate)
                                    <input type="checkbox" name="showpassword" id="showpassword"
                                        wire:model.live="show_password" placeholder="">
                                    <label for="showpassword">Update Password</label>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if (!$this->isCreate)
                        {{-- if form is edit --}}
                        <div class="flex flex-row justify-end gap-2">

                            <div>
                                <input type="submit"
                                    class="text-white bg-[rgb(55,55,55)] focus:ring-4 hover:bg-[rgb(28,28,28)] focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" />
                            </div>
                        </div>
                    @else
                        <div class="flex flex-row justify-end gap-2">
                            <div>


                                <button type="reset"
                                    class="text-[rgb(53,53,53)] hover:bg-gray-100 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Clear
                                    All</button>
                            </div>
                            <div>
                                <input type="submit"
                                    class="text-white bg-[rgb(55,55,55)] focus:ring-4 hover:bg-[rgb(28,28,28)] focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" />
                            </div>
                        </div>
                    @endif

                </div>

            </form>

            @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        </div>

    </div>
</div>
