<section>
    <h2 class="font-medium text-xl">Streams and recordings</h2>

    <section class="space-y-5">
        <ul class="flex items-center border-b text-sm">
            <li>
                <button 
                    wire:click="setTab('upcoming')"
                    class="py-3 px-5 {{ $currentTab === 'upcoming' ? 'text-primary font-medium border-b-2 border-primary' : null }}">
                    Upcoming
                </button>
            </li>
            <li>
                <button 
                    wire:click="setTab('past')"
                    class="py-3 px-5 {{ $currentTab === 'past' ? 'text-primary font-medium border-b-2 border-primary' : null }}">
                    Past
                </button>
            </li>
        </ul>

        <section class="space-y-5">
            <div class="space-x-2">
                <a href="{{ route('admin.video.create') }}" class="btn btn-sm btn-primary">
                    <i class="las la-plus"></i>
                    <span>Create</span>
                </a>

                <a href="{{ route('admin.calendar') }}" class="btn btn-sm bg-info text-light">
                    <i class="las la-calendar"></i>
                    <span>Calendar</span>
                </a>
            </div>

            

            <section class="md:w-3/4 space-y-3">

            @forelse($streams as $key => $streamItems)
                <h1 class="font-bold text-2xl">{{ $key == now()->today()->format('Y-m-d') ? 'Today' : \Carbon\Carbon::parse($key)->format("d M, Y") }} </h1>
               @foreach($streamItems as $stream)
                   <div class="border-t py-2 flex flex-col md:flex-row items-end md:items-center  justify-between space-y-3 md:space-y-0 md:space-x-5">
                        <section class="flex-2 space-y-3">
                            <div class="flex space-x-3">
                                <img src="{{ asset($stream->thumbnail) }}" alt="" class="max-w-[100px] h-[100px] min-w-[100px]" />
                                <div class="space-y-2">
                                    <h2 class="font-bold">{{ $stream->title }}</h2>
                                    <p class="font-light text-xs">{{ Str::limit($stream->description, 140, '...') }}<p>
                                @if($currentTab === 'upcoming') 
                                    <footer class="flex items-center space-x-5 text-xs">
                                        <a href="{{ route('admin.video.edit', ['id' => $stream->id ]) }}" class="text-primary">Edit</a>
                                    
                                        <a href="javascript:void(0)" 
                                            x-on:click="$dispatch('trigger-delete-modal', {
                                                                        'id' : {{  $stream->id }},
                                                                        'model' : '\App\\Models\\Stream',
                                                                        'title' : 'Are you sure?',
                                                                        'message' : 'Are you sure you want to delete this stream from the pool?'
                                            })" 
                                            class="text-danger">Delete</a>
                                    </footer>
                                @endIf
                                </div>
                            </div>
                        </section>
                        <section class="flex flex-row space-x-3 md:space-x-0 md:flex-col md:items-center md:space-y-2 font-bold text-sm md:text-center">
                            <span>{{ \Carbon\Carbon::parse($stream->start_time)->format('h:i A') }}</span>
                            <span class="font-light">to</span>
                            <span>{{ \Carbon\Carbon::parse($stream->end_time)->format('h:i A') }}</span>
                        </section>
                    </div> 
                @endforeach 
                
                @empty 
                    <div class="p-3 text-center space-y-3">
                        <h2 class="font-medium">You currently have no {{ $currentTab }} recordings</h2>
                        
                        <p>Your recorded broadcasts will show up here</p>
                    </div> 
               @endforelse
            </section>
        </section>
    </section>

    <x-loading />
</section>