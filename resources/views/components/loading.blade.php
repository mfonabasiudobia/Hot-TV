<div class="fixed z-[2000] h-screen w-screen top-0 left-0 bg-black bg-opacity-50" wire:loading>

    <div class="flex items-center  justify-center h-full w-full">

        {{-- <img src="{{ asset(" images/loaders/loading-white.svg") }}" /> --}}

        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            style="margin: auto; background: none; display: block; shape-rendering: auto;" width="50px" height="50px"
            viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
            <circle cx="50" cy="50" fill="none" stroke="blue" stroke-width="10" r="27"
                stroke-dasharray="127.23450247038662 44.411500823462205">
                <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite"
                    dur="1.2048192771084336s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
            </circle>
        </svg>

    </div>

</div>