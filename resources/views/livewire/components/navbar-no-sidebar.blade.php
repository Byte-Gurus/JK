<div x-cloak
    class="flex flex-row items-center font-['Inter'] h-[10vh] justify-between ml-[0px] z-50 py-2 transition-all duration-100 ease-out border-b-2 border-black px-7 text-nowrap">
    <div class="flex flex-row items-center">
        <div href="{{ route('admin.index') }}" wire:navigate class="pr-4">
            <img src="{{ asset('jk-logo-cropped.png') }}" width="50px" alt="logo">
        </div>
        <div>
            <h1 class="font-bold text-gray-800 pointer-events-none text-md">Frozen and Consumer Goods Store</h1>
        </div>
        <div class="flex flex-row items-center gap-12 ml-24 font-semibold text-gray-700">
            <div class="flex flex-row items-center gap-2">
                <svg class="w-6 h-6 pointer-events-none" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M20 10V7C20 5.89543 19.1046 5 18 5H6C4.89543 5 4 5.89543 4 7V10M20 10V19C20 20.1046 19.1046 21 18 21H6C4.89543 21 4 20.1046 4 19V10M20 10H4M8 3V7M16 3V7"
                        stroke="#000000" stroke-width="2" stroke-linecap="round" />
                    <rect x="6" y="12" width="3" height="3" rx="0.5" fill="#000000" />
                    <rect x="10.5" y="12" width="3" height="3" rx="0.5" fill="#000000" />
                    <rect x="15" y="12" width="3" height="3" rx="0.5" fill="#000000" />
                </svg>
                <p class="pointer-events-none ">{{ $date }}</p>
            </div>
            <div class="flex flex-row items-center gap-2 font-semibold text-gray-700 pointer-events-none">
                <svg class="w-6 h-6 pointer-events-none" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 7V12L14.5 10.5M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                        stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p wire:poll.visible.30000ms class="pointer-events-none ">{{ $time }}</p>
            </div>
        </div>
    </div>

    <div class="flex items-center">

        <div class="flex items-center justify-between">
            <div class="flex flex-row items-center gap-8">
                @if ($this->isAdmin())
                    <div
                        class="relative p-1.5 hover:bg-[rgb(231,231,231)] rounded-full ease-in-out transition-all duration-200 cursor-pointer">
                        <a href="{{ route('admin.index') }}" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class=" size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                        </a>
                    </div>
                @elseif ($this->isInventoryClerk())
                    <div
                        class="relative p-1.5 hover:bg-[rgb(231,231,231)] rounded-full ease-in-out transition-all duration-200 cursor-pointer">
                        <a href="{{ route('inventoryclerk.index') }}" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class=" size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                        </a>
                    </div>
                @endif

                <div x-data="{ openNotifications: false }" x-on:click.away="openNotifications = false;"
                    class="relative p-1.5 hover:bg-[rgb(231,231,231)] rounded-full ease-in-out transition-all duration-200 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        x-on:click="openNotifications = !openNotifications" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>


                    <div x-show="openNotifications" x-transition:enter="transition ease-in-out duration-300"
                        x-transition:enter-start="transform opacity-100 scale-0"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-out duration-300"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-0"
                        class="absolute z-10 w-screen max-w-md origin-top-right transform right-3">
                        <div
                            class=" overflow-y-auto rounded-l-lg h-full max-h-[400px] rounded-br-lg rounded-tr-none
                        min-h-[50%]">
                            <div class="h-fit max-h-[400px]">
                                @livewire('components.notifications')
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    @livewire('components.logout')
                </div>
            </div>
        </div>
    </div>
</div>
