<div class="flex flex-col items-center justify-center w-screen h-screen font-['Inter']"
    style="background-image: linear-gradient(115deg, #dadada, #1b1b1b)">
    <div class="flex flex-row items-center justify-center shadow-lg">
        {{-- LOGO SECTION --}}
        <div class="flex flex-col h-full justify-center items-center bg-[rgb(53,53,53)] p-4 rounded-l-xl">
            <img src="jk-logo-cropped.png" alt="jk" class="w-2/4">
            <p class="text-[rgb(255,255,255)] font-bold text-center pointer-events-none text-[1.6em]">
                JK Frozen Products and Consumer Supplies
            </p>
        </div>
        {{-- FORM SECTION --}}
        <div
            class="bg-white flex transition-all duration-100 ease-in-out border-2 border-[rgb(22,22,22)] rounded-br-xl rounded-tr-xl p-10 w-[520px]">
            <form wire:submit.prevent="authenticate" class="flex flex-col justify-center w-full flex-nowrap text-nowrap">

                <div class="flex flex-col mb-8">
                    <p class="font-bold pointer-events-none text-[3em]">
                        Sign In
                    </p>
                    <p class="pointer-events-none">Enter your Account Details!</p>
                </div>

                <div class="flex flex-col mb-4">
                    <label for="username" class="text-[rgb(53,53,53)]">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required
                        class="w-full px-4 py-2 text-sm border-2 border-black rounded-md outline-none bg-gray-50 text-none focus:outline-none"
                        wire:model="username">
                    @error('username')
                        <span class="mt-2 font-medium text-red-500 text-md">{{ $message }}</span>
                    @enderror
                </div>

                <div class="relative flex flex-col mb-12" x-data="{ showPassword: @entangle('showPassword') }">
                    <label for="password" class="text-[rgb(53,53,53)]">Password</label>
                    <div class="relative items-center">
                        <input :type="showPassword ? 'password' : 'text'" id="password" name="password" required
                            class="absolute w-full py-2 pl-4 pr-12 text-sm border-2 border-black rounded-md outline-none bg-gray-50 text-none focus:outline-none"
                            wire:model="password">

                        @if ($this->showPassword)
                            <p x-cloak class="absolute right-0 mt-2 mr-4" x-on:click=" $wire.showPasswordStatus()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </p>
                        @else
                            {{-- <p class="relative self-end mt-8 mr-4 cursor-pointer " --}} <p class="absolute right-0 mt-2 mr-4"
                                x-on:click=" $wire.showPasswordStatus()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </p>
                        @endif
                    </div>

                    @error('password')
                        <span class="mt-2 font-medium text-red-500 text-md">{{ $message }}</span>
                    @enderror
                </div>

                {{-- <div class="flex justify-center mt-4">
                    {!! htmlFormSnippet() !!}

                </div> --}}


                <div class="mt-8 text-right">
                    <button type="submit" wire:loading.remove
                        class="w-full px-8 py-2 font-bold outline-none focus:outline-none text-[rgb(249,249,249)] bg-[rgb(53,53,53)] border-2 border-black rounded-md text-md hover:bg-[rgb(80,80,80)]">
                        Log In
                    </button>
                </div>


                <div wire:loading>
                    <div class="flex items-center justify-center loader loader--style3" title="2">
                        <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px"
                            viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                            <path fill="#000"
                                d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z">
                                <animateTransform attributeType="xml" attributeName="transform" type="rotate"
                                    from="0 25 25" to="360 25 25" dur="0.6s" repeatCount="indefinite" />
                            </path>
                        </svg>
                    </div>
                </div>

                @error('submit')
                    <span class="mt-4 font-medium text-center text-red-500 text-md">{{ $message }}</span>
                @enderror


            </form>

        </div>
    </div>
</div>
