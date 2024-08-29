<div class="flex flex-col items-center justify-center w-screen h-screen font-['Inter']"
    style="background-image: linear-gradient(115deg, #dadada, #1b1b1b)">
    <div class="flex flex-row items-center justify-center shadow-lg">
        {{-- LOGO SECTION --}}
        <div
            class="flex flex-col h-full justify-center items-center bg-[rgb(53,53,53)] p-4 rounded-tr-xl rounded-bl-none rounded-br-none">
            <img src="jk-logo-cropped.png" alt="jk" class="w-2/4">
            <p class="text-[rgb(255,255,255)] font-bold text-center pointer-events-none text-[1.6em]">
                JK Frozen Products and Consumer Supplies
            </p>
        </div>
        {{-- FORM SECTION --}}
        <div
            class="bg-white flex transition-all duration-100 ease-in-out border-2 border-[rgb(22,22,22)] rounded-bl-xl rounded-br-xl rounded-tr-xl p-10 w-[520px]">
            <form wire:submit.prevent="authenticate" class="flex justify-center w-full flex-nowrap text-nowrap flex-col">
                @csrf
                <div class="flex flex-col mb-8">
                    <p class="font-bold pointer-events-none text-[3em]">
                        Sign In
                    </p>
                    <p class="pointer-events-none">Enter your Account Details!</p>
                </div>

                <div class="flex mb-4 flex-col">
                    <label for="username" class="text-[rgb(53,53,53)]">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required
                        class="w-full px-4 py-2 text-sm border-2 border-black rounded-md outline-none cursor-pointer bg-gray-50 text-none focus:outline-none"
                        wire:model="username">
                    @error('username')
                        <span class="mt-2 font-medium text-red-500 text-md">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col mb-12">
                    <label for="password" class="text-[rgb(53,53,53)]">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 text-sm border-2 border-black rounded-md outline-none cursor-pointer bg-gray-50 text-none focus:outline-none"
                        wire:model="password">
                    @error('password')
                        <span class="mt-2 font-medium text-red-500 text-md">{{ $message }}</span>
                    @enderror
                </div>

                <div class="text-right">
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
