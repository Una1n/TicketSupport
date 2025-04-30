<div>
    <!-- <div class="mb-5 text-2xl font-bold">Home</div> -->
    <x-mary-header title="Home" separator />
    <div class="flex gap-10">
        <div class="w-full max-w-lg rounded-lg bg-base-300 shadow">
            <div class="flex gap-5 p-4">
                <div class="flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                        stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium">Open Tickets</h3>
                    <p class="mt-1 text-2xl font-bold text-error">
                        {{ $openTickets }} <span class="text-base-content">/ {{ $totalTickets }}</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="w-full max-w-lg rounded-lg bg-base-300 shadow">
            <div class="flex gap-5 p-4">
                <div class="flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                        stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium">Closed Tickets</h3>
                    <p class="mt-1 text-2xl font-bold text-success">
                        {{ $closedTickets }} <span class="text-base-content">/ {{ $totalTickets }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
