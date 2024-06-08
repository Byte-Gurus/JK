<div class="flex flex-col justify-center w-screen h-screen"
style="background-image: linear-gradient(115deg, #008DDA, #F7EEDD)">
<div
    class="flex justify-center w-screen mx-auto overflow-hidden align-middle shadow-lg rounded-xl vsm:flex-col vsm:w-fit phone:flex-col phone:p-18 phone:w-fit tablet:flex-col tablet-1/2 laptop:flex-row shadow-gray-500">
    <div
        class=" flex flex-col gap-4 items-center justify-center
    vsm:bg-[rgb(190,223,252)] vsm:w-fit  vsm:p-4 vsm:rounded-tl-xl vsm:rounded-tr-xl vsm:rounded-bl-none vsm:rounded-br-none
    phone:bg-[rgb(243,252,190)] phone:w-screen phone:p-4 phone:rounded-tl-xl phone:rounded-tr-xl phone:rounded-bl-none phone:rounded-br-none
     tablet:bg-[rgb(220,178,178)] tablet:w-full tablet:rounded-tl-xl tablet:rounded-tr-xl tablet:rounded-bt -none tablet:rounded-br-none
     laptop:bg-[rgb(202,202,202)] laptop:p-8 laptop:w-fit laptop:rounded-tl-xl laptop:rounded-bl-xl laptop:rounded-tr-none laptop:rounded-br-none ">
        <img src="jk-logo-cropped.png" alt="jk" class="vsm:w-1/5 phone:w-1/4 tablet:w-2/4 laptop:w-2/4">
        <p
            class="text-[rgb(53,53,53)] font-bold text-center pointer-events-none
                vsm:text-[1em]
                phone:text-[1.2em]
                tablet:text-[1.2em]
                laptop:text-[1.6em]">
            JK Frozen
            Products and Consumer
            Supplies</p>
    </div>
    <div
        class=" bg-white flex transition-all duration-100 ease-in-out
            vsm:flex-col vsm:rounded-bl-xl vsm:rounded-br-xl vsm:rounded-tr-none vsm:rounded-tl-none vsm:p-2
            phone:flex-col phone:rounded-bl-xl phone:rounded-br-xl phone:rounded-tr-none phone:rounded-tl-none phone:p-8
            tablet:flex-row tablet:w-full tablet:rounded-br-xl  tablet:rounded-bl-xl tablet:rounded-tr-none tablet:rounded-tl-none tablet:p-4
            laptop:flex-row laptop:rounded-br-xl laptop:w-[520px] laptop:rounded-tr-xl laptop:rounded-bl-none laptop:p-10">

        <form wire:submit.prevent="authenticate"
            class="flex justify-center w-full flex-nowrap text-nowrap vsm:flex-col phone:flex-col tablet:flex-col laptop:flex-col">
            @csrf
            <div class="flex flex-col mb-8">
                <p
                    class="font-bold pointer-events-none
                vsm:text-[2em]
                phone:text-[4em]
                tablet:text-[2em]
                laptop:text-[3em]">
                    Sign In </p>
                <p class="pointer-events-none">Enter your Account Details!</p>
            </div>

            <div class="flex mb-4  vsm:flex-col phone:flex-col tablet:flex-col laptop:flex-col">
                <label for="username" class=" text-[rgb(53,53,53)]">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}"
                    class=" w-full px-4 py-2 text-sm rounded-md bg-gray-50 border-2 border-black focus:outline-none focus:border-[rgb(81,114,185)] cursor-pointer"
                    wire:model="username">
                @error('username')
                    <span
                        class="mt-2 font-medium text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col mb-12 ">
                <label for="password" class="text-[rgb(53,53,53)]">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 text-sm rounded-md bg-gray-50 border-2 border-black focus:outline-none focus:border-[rgb(81,114,185)]cursor-pointer"
                    wire:model="password">
                @error('password')
                    <span
                        class="mt-2 font-medium text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
                @enderror
            </div>

            <div class="laptop:text-right">
                <button type="submit"
                    class="w-full px-8 py-2 font-bold text-black bg-blue-400 border-2 border-black rounded-sm shadow-lg text-md hover:bg-blue-500 hover:border-blue-700 hover:text-white shadow-gray-400">
                    Sign In</button>
            </div>

            @error('submit')
                <span
                    class="mt-4 font-medium text-center text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
            @enderror
        </form>
    </div>
</div>
</div> --}}

<div class="flex flex-col items-center justify-center w-screen h-screen"
    style="background-image: linear-gradient(115deg, #dadada, #1b1b1b)">
    <div class="flex flex-row items-center justify-center shadow-lg ">
        {{-- LOGO SECTION --}}
        <div
            class=" flex flex-col h-full justify-center items-center bg-[rgb(53,53,53)]
    vsm:w-fit  vsm:p-4  vsm:rounded-tr-xl vsm:rounded-bl-none vsm:rounded-br-none
    phone:w-screen phone:p-4 phone:rounded-bl-none phone:rounded-br-none
     tablet:w-full  tablet:rounded-tr-xl tablet:rounded-bl-none tablet:rounded- tablet:rounded-bt-none tablet:rounded-br-none
     laptop:w-fit laptop:h-full laptop:rounded-bl-xl laptop:rounded-tr-none laptop:rounded-br-none ">
            <img src="jk-logo-cropped.png" alt="jk" class="vsm:w-1/5 phone:w-1/4 tablet:w-2/4 laptop:w-2/4">
            <p
                class="text-[rgb(255,255,255)] font-bold text-center pointer-events-none
                vsm:text-[1em]
                phone:text-[1.2em]
                tablet:text-[1.2em]
                laptop:text-[1.6em]">
                JK Frozen
                Products and Consumer
                Supplies</p>
        </div>
        {{-- FORM SECTION --}}
        <div
            class=" bg-white flex transition-all duration-100 ease-in-out border-2 border-[rgb(22,22,22)]
            vsm:flex-col vsm:rounded-bl-xl vsm:rounded-br-xl vsm:rounded-tr-none vsm:rounded-tl-none vsm:p-2
            phone:flex-col phone:rounded-bl-xl phone:rounded-br-xl phone:rounded-tr-none phone:rounded-tl-none phone:p-8
            tablet:flex-row tablet:w-full tablet:rounded-br-xl  tablet:rounded-bl-xl tablet:rounded-tr-none tablet:rounded-tl-none tablet:p-4
            laptop:flex-row laptop:rounded-br-xl laptop:w-[520px] laptop:rounded-tr-xl laptop:rounded-bl-none laptop:p-10">

            <form wire:submit.prevent="authenticate"
                class="flex justify-center w-full flex-nowrap text-nowrap vsm:flex-col phone:flex-col tablet:flex-col laptop:flex-col">
                @csrf
                <div class="flex flex-col mb-8">
                    <p
                        class="font-bold pointer-events-none
                vsm:text-[2em]
                phone:text-[4em]
                tablet:text-[2em]
                laptop:text-[3em]">
                        Sign In </p>
                    <p class="pointer-events-none">Enter your Account Details!</p>
                </div>

                <div class="flex mb-4 vsm:flex-col phone:flex-col tablet:flex-col laptop:flex-col">
                    <label for="username" class=" text-[rgb(53,53,53)]">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}"
                        class="w-full px-4 py-2 text-sm border-2 border-black rounded-md outline-none cursor-pointer bg-gray-50 text-none focus:outline-none"
                        wire:model="username">
                    @error('username')
                        <span
                            class="mt-2 font-medium text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col mb-12 ">
                    <label for="password" class="text-[rgb(53,53,53)]">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-2 text-sm border-2 border-black rounded-md outline-none cursor-pointer bg-gray-50 text-none focus:outline-none"
                        wire:model="password">
                    @error('password')
                        <span
                            class="mt-2 font-medium text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
                    @enderror
                </div>

                <div class="laptop:text-right">
                    <button type="submit"
                        class="w-full px-8 py-2 font-bold outline-none focus:outline-none text-[rgb(249,249,249)] bg-[rgb(53,53,53)] border-2 border-black rounded-md text-md hover:bg-[rgb(80,80,80)] ">
                        Sign In</button>
                </div>

                @error('submit')
                    <span
                        class="mt-4 font-medium text-center text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
                @enderror
            </form>
        </div>
    </div>

</div>
