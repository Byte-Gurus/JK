<div class="flex justify-center">
    <div class="flow-root">
        @foreach ($logs as $log)
        <ul role="list" class="-mb-8">
            <li>
                <div class="relative pb-8">
                    <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                    <div class="relative flex space-x-3">
                        @if (strpos($log->action, 'Logged in') !== false)

                        @elseif(strpos($log->action, 'Logged out') !== false)

                        @elseif(strpos($log->action, 'Created') !== false)
                        @elseif(strpos($log->action, 'Updated') !== false)Adjusted
                        
                        @elseif(strpos($log->action, 'Restocked') !== false)
                        @elseif(strpos($log->action, 'Voided') !== false)
                        @elseif(strpos($log->action, 'Returned  ') !== false)

                        @endif
                        <div>
                            <span
                                class="flex items-center justify-center w-8 h-8 bg-gray-400 rounded-full ring-8 ring-white">
                                <svg class="w-5 h-5 text-white" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true" data-slot="icon">
                                    <path
                                        d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
                                </svg>
                            </span>
                        </div>
                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                            <div>
                                <p class="text-sm text-gray-500">{{$log->message}}</p>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-500">{{$log->action}}</p>
                            </div>
                            <div class="text-sm text-right text-gray-500 whitespace-nowrap">
                                <p>{{ $log->created_at->format('M d Y h:i:s A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        @endforeach

        <div class="mx-4 my-2 text-nowrap">

            {{ $logs->links() }}

        </div>
    </div>
</div>
