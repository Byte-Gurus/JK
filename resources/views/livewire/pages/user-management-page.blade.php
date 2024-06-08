<div>
    @livewire('components.navbar')
    <div x-data="{showModal:false}">
        <div class=" ml-[250px] py-[28px] mr-8">
            <div class="flex flex-col justify-between">
                <div class="flex flex-row items-center justify-between">
                    <div>
                        <h1 class="text-[2em] font-bold pointer-events-none">Manage User</h1>
                    </div>
                    <div>
                        {{-- <a type="button" data-modal-target="UserModal123" data-modal-show="UserModal123"
                            class=" px-4 py-2 text-sm font-bold bg-orange-200 border border-black rounded-md hover:bg-orange-300 hover:text-[rgb(53,53,53)]">Add
                            New User</a></button> --}}
                            <button class=" px-4 py-2 text-sm font-bold bg-[rgb(53,53,53)] text-white border rounded-md hover:bg-[rgb(71,71,71)] transition-all duration-100 ease-in-out" x-on:click="showModal=true;$wire.emitEvent()">
                                Add New User
                            </button>
                    </div>
                </div>

            </div>
            @livewire('components.UserManagement.user-form')
        </div>
            @livewire('components.UserManagement.user-table')
    </div>
</div>
