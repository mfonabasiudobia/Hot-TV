<section :class="toggleSidebar ? '' : 'sidebar-wrapper'" x-on:click="toggleSidebar = !toggleSidebar" x-cloak>
    <div x-on:click="event.stopPropagation()" class=" h-screen relative overflow-hidden"
        :class="toggleSidebar ? 'w-0 md:w-[250px]' : 'w-[270px] md:w-0'">
        <div class="flex justify-center py-3">
            <a href="/admin" class="btn btn-sm btn-danger">
                Go Back
            </a>
        </div>
        <ul class="sidebar z-0">
            <li class="{{request()->routeIs('admin.dashboard') ? 'active' : ''}}">
                <a href="{{route('admin.dashboard')}}">
                    <i class="las la-video"></i>
                    <span>Manage Channel Content</span>
                </a>
            </li>

            {{-- <li class="{{request()->routeIs('admin.live.*') ? 'active' : ''}}">
                <a href="{{route('admin.live')}}">
                    <i class="las la-play"></i>
                    <span>Manage Channel Content</span>
                </a>
            </li> --}}


            <li class="{{$status = request()->routeIs('admin.podcast.*') ? 'active' : ''}}"
                x-data="{ show : '{{$status ? true : false}}'}">
                <a href="#" x-on:click="show = !show">
                    <i class="las la-podcast"></i>
                    <span>Manage Podcast</span>
                    <i class="las la-angle-right arrow-right" :class="show ? 'rotate-90' : ''"></i>
                </a>


                <ul class="list-2" x-show="show">
                    <li>
                        <a href="{{ route('admin.podcast.list')  }}">
                            <i class="las la-circle"></i>
                            <span>Podcast List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.podcast.create')  }}">
                            <i class="las la-circle"></i>
                            <span>Create Podcast</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="{{$status = request()->routeIs('admin.shoutout.*') ? 'active' : ''}}"
                x-data="{ show : '{{$status ? true : false}}'}">
                <a href="#" x-on:click="show = !show">
                    <i class="las la-podcast"></i>
                    <span>Manage Celebrity Shoutouts</span>
                    <i class="las la-angle-right arrow-right" :class="show ? 'rotate-90' : ''"></i>
                </a>


                <ul class="list-2" x-show="show">
                    <li>
                        <a href="{{ route('admin.shoutout.list')  }}">
                            <i class="las la-circle"></i>
                            <span>Shoutout List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.shoutout.create')  }}">
                            <i class="las la-circle"></i>
                            <span>Create Shoutout</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="{{$status = request()->routeIs('admin.show-category.*') ? 'active' : ''}}"
                x-data="{ show : '{{$status ? true : false}}'}">
                <a href="#" x-on:click="show = !show">
                    <i class="las la-tv"></i>
                    <span>Manage Shows Content</span>
                    <i class="las la-angle-right arrow-right" :class="show ? 'rotate-90' : ''"></i>
                </a>


                <ul class="list-2" x-show="show">
                    <li>
                        <a href="{{ route('admin.show-category.list')  }}">
                            <i class="las la-circle"></i>
                            <span>Manage Show Categories</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.tv-show.list')  }}">
                            <i class="las la-circle"></i>
                            <span>Shows List</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.tv-show.cast.list')  }}">
                            <i class="las la-circle"></i>
                            <span>Manage Casts</span>
                        </a>
                    </li>


                    <li x-data="{ show : false}">
                        <a href="#" x-on:click="show = !show">
                            <i class="las la-video"></i>
                            <span>Manage Episodes</span>
                            <i class="las la-angle-right arrow-right" :class="show ? 'rotate-90' : ''"></i>
                        </a>


                        <ul class="list-3" x-show="show">
                            <li>
                                <a href="{{ route('admin.tv-show.episode.list')  }}">
                                    <i class="las la-circle"></i>
                                    <span>Add New Episode</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.tv-show.episode.list')  }}">
                                    <i class="las la-circle"></i>
                                    <span>Episode List</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="{{$status = request()->routeIs('admin.ride.*') ? 'active' : ''}}"
                x-data="{ show : '{{$status ? true : false}}'}">
                <a href="#" x-on:click="show = !show">
                    <i class="las la-tv"></i>
                    <span>Manage Pedicabs</span>
                    <i class="las la-angle-right arrow-right" :class="show ? 'rotate-90' : ''"></i>
                </a>


                <ul class="list-2" x-show="show">
                    <li class="{{$status = request()->routeIs('admin.ride.*') ? 'active' : ''}}">
                        <a href="{{ route('admin.ride.durations')  }}">
                            <i class="las la-circle"></i>
                            <span>Ride Durations</span>
                        </a>
                    </li>

                    <li class="{{$status = request()->routeIs('admin.ride.*') ? 'active' : ''}}">
                        <a href="{{ route('admin.ride.list')  }}">
                            <i class="las la-circle"></i>
                            <span>Ride List</span>
                        </a>
                    </li>
                </ul>
            </li>


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
