<div class="flex flex-col items-center bg-[rgb(13,14,18)] h-screen w-screen p-10 justify-center">
    <div class=" bg-[rgba(20,20,20,0.44)] rounded-lg border border-[rgb(53,53,53)]  p-4">
        <div class="justify-center flow-root pr-4 overflow-y-scroll">
            <ul role="list" class="-mb-8">
                @foreach ($logs as $log)
                    <li>
                        <div class="relative pb-8 mx-2 mt-1">
                            <span class="absolute left-4 top-11 -ml-px h-1/3 w-0.5 bg-gray-700" aria-hidden="true"></span>
                            <div class="relative flex space-x-3">
                                @if (strpos($log->message, 'Logged in') !== false)
                                    <div>
                                        <span
                                            class="flex items-center justify-center w-8 h-8 bg-[rgb(13,47,11)] rounded-full ring-4 ring-[rgb(13,56,19)]">
                                            <svg class="text-green-700" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                            </svg>
                                        </span>
                                    </div>
                                @elseif(strpos($log->message, 'Logged out') !== false)
                                    <div>
                                        <span
                                            class="flex items-center justify-center w-8 h-8 bg-[rgb(47,11,11)] rounded-full ring-4 ring-[rgb(56,13,13)]">
                                            <svg class="text-red-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                            </svg>
                                        </span>
                                    </div>
                                @elseif(strpos($log->message, 'Created') !== false)
                                    <div>
                                        <span
                                            class="flex items-center justify-center w-8 h-8 bg-[rgb(13,47,11)] rounded-full ring-4 ring-[rgb(13,56,19)]">
                                            <svg class="text-green-700" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </span>
                                    </div>
                                @elseif(strpos($log->message, 'Updated') !== false)
                                    <div>
                                        <span
                                            class="flex items-center justify-center w-8 h-8 bg-[rgb(47,34,11)] rounded-full ring-4 ring-[rgb(56,42,13)]">
                                            <svg class="text-orange-700" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </span>
                                    </div>
                                @elseif(strpos($log->message, 'Restocked') !== false)
                                    <div>
                                        <span
                                            class="flex items-center justify-center w-8 h-8 bg-[rgb(13,47,11)] rounded-full ring-4 ring-[rgb(13,56,19)]">
                                            <svg class="text-green-700" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </span>
                                    </div>
                                @elseif(strpos($log->message, 'Voided') !== false)
                                    <div>
                                        <span
                                            class="flex items-center justify-center w-6 h-6 bg-[rgb(47,11,11)] rounded-full ring-4 ring-[rgb(56,13,13)]">
                                            <svg class="text-red-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </span>
                                    </div>
                                @elseif(strpos($log->message, 'Returned  ') !== false)
                                    <div>
                                        <span
                                            class="flex items-center justify-center w-8 h-8 bg-[rgb(47,11,11)] rounded-full ring-4 ring-[rgb(56,13,13)]">
                                            <svg class="text-red-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                                            </svg>
                                        </span>
                                    </div>
                                @endif
                                <div class="flex flex-col pl-2 min-w-0 flex-1 justify-between pt-1.5">
                                    <div>
                                        <p class="font-black text-[rgb(239,239,239)] text-md">{{ $log->action }}</p>
                                    </div>
                                    <div class="flex flex-row justify-between ">
                                        <div>
                                            <p class="text-sm text-wrap text-[rgb(216,216,216)]">{{ $log->message }}</p>
                                        </div>
                                        <div class="pl-4 text-sm text-right text-gray-500 whitespace-nowrap">
                                            <p>{{ $log->created_at->format('M d Y h:i:s A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="gap-6 mx-4 my-2 bottom-0self-center justify-evenly text-nowrap">
            {{ $logs->links() }}

        </div>
    </div>
</div>
