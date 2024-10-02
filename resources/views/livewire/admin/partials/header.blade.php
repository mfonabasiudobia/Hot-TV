<header class="border-b border-secondary w-full flex justify-center items-center py-7 sticky top-0 z-50 ">
    @if(!AppHelper::isAdminAuthRoute())
    <button class="text-xl text-dark absolute left-2 dark:text-white" x-on:click="toggleSidebar = !toggleSidebar">
        <i class="las la-bars"></i>
    </button>
    @endIf
    {{--<img src="{{asset('images/logo/logo.png')}}" class="scale-50" />--}}
    @if(!AppHelper::isAdminAuthRoute())
    <div class="absolute right-5" x-data="{show : false }" x-cloak>
        <button class="text-xl text-white bg-danger rounded-full py-1 px-2" x-on:click="show = !show">
            <i class="las la-user"></i>
        </button>

        <div class="absolute w-[200px] right-[15px] z-50 bg-white rounded-lg shadow-xl overflow-hidden" x-show="show"
            x-cloak x-on:click.away="show = false">
            <ul>
                {{-- <li>
                    <a href="{{route('admin.setting.update_password')}}"
                        class="py-2 px-3 block hover:bg-gray-100">Account Setting</a>
                </li> --}}
                <li>
                    <a href="/admin/logout" class="py-2 px-3 block hover:bg-gray-100">Logout</a>
                </li>
            </ul>
        </div>
    </div>
    @endIf
</header>
