<section :class="toggleSidebar ? '' : 'sidebar-wrapper'" x-on:click="toggleSidebar = !toggleSidebar" x-cloak>
    <div x-on:click="event.stopPropagation()" class=" h-screen bg-light relative overflow-hidden"
        :class="toggleSidebar ? 'w-0 md:w-[250px]' : 'w-[270px] md:w-0'">
        <div class="flex justify-center py-3">
            <a href="/admin" class="btn btn-sm btn-primary">
                Go Back
            </a>
        </div>
        <ul class="sidebar z-0">
            <li class="{{request()->routeIs('admin.dashboard') ? 'active' : ''}}">
                <a href="{{route('admin.dashboard')}}">
                    <i class="las la-video"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="{{request()->routeIs('admin.live') ? 'active' : ''}}">
                <a href="{{route('admin.dashboard')}}">
                    <i class="las la-play"></i>
                    <span>Go Live</span>
                </a>
            </li>

            {{-- <li class="{{request()->routeIs('admin.plans.*') ? 'active' : ''}}">
                <a href="{{route('admin.plans.list')}}">
                    <i class="las la-box"></i>
                    <span>Membership Plans</span>
                </a>
            </li> --}}
        </ul>


        <ul class="sidebar-bottom absolute left-0 bottom-0 border-t w-full bg-white z-20">
            {{-- <li>
                <a href="{{route('admin.setting.home')}}" class="logout">
                    <i class="las la-cog"></i>
                    <span>Settings</span>
                </a>
            </li> --}}
            {{-- <li>
                <a href="{{route('admin.logout')}}" class="logout">
                    <i class="las la-power-off logout"></i>
                    <span>Log out</span>
                </a>
            </li> --}}
        </ul>
    </div>
</section>