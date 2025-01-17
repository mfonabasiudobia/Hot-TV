<section>
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-autorounded-lg overflow-hidden text-white">
            <!-- Header -->
            <div class="bg-secondary p-6">
                <div class="flex justify-between">
                    <div class="flex items-center space-x-4">
                        <img class="h-10 w-10 rounded-full border-4 border-white"
                            src="{{ $ride->stream_thumbnail ? '/storage/' . $ride->stream_thumbnail : 'https://placehold.co/600x400' }}"
                            alt="Stream Thumbnail">
                        <div>
                            <h1 class="text-2xl font-semibold text-white">{{ $ride->street_name }}</h1>
                            <p class="">{{ $ride->status }}</p>
                        </div>
                    </div>
                    <div>
                        <strong>Date:</strong> {{ date( 'Y-m-d H:i', strtotime($ride->created_at)) }}
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="p-6">
                <!-- Section: Ride Information -->
                <div class="my-4 shadow-lg">
                    <ul class="space-y-2">
                        <li>
                            <strong>Email:</strong> <a href="#">{{$ride->customer->email}}</a>
                        </li>
                        <li>
                            <strong>Phone:</strong> {{ $ride->customer->phone_number }}
                        </li>
                        <li>
                            <strong>Location:</strong> {{$ride->details}}
                        </li>
                    </ul>
                </div>

                <!-- Section: Ride History -->
                <div class="my-4">
                    <div class="max-w-4xl mx-auto shadow-lg rounded-lg overflow-hidden">
                        <!-- Header -->
                        <div class="bg-gray-800 p-4">
                            <h1 class="text-2xl font-bold">Ride History</h1>
                            <p class="">Ride activities and changes</p>
                        </div>

                        <!-- Log List -->
                        <div class="py-6">
                            <ul class="divide-y divide-gray-200">
                                @foreach ($ride->ride_events as $index => $event)
                                    <!-- Log Item -->
                                    <li class="py-4 flex items-start">
                                        <div class="ml-4">
                                            <p class="text-sm text-white-500">Latitude: {{$event->user_latitude}}</p>
                                            <p class="text-sm text-white-500">Longitude: {{$event->user_longitude}}</p>
                                            <p class="text-sm text-white-500">{{$event->timestamp}}</p>
                                            <p class="text-white-700">
                                                <span class="font-semibold">{{$event->event_type}}</span>.
                                            </p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="my-4 shadow-lg">
                    <h2 class="text-xl font-bold text-white-800 mb-4">Customer Information</h2>
                    <ul class="space-y-2">
                        <li>
                            <strong>Name:</strong> <a href="#">{{$ride->customer->first_name}} {{$ride->customer->first_name}}</a>
                        </li>
                        <li>
                            <strong>Email:</strong> <a href="#">{{$ride->customer->email}}</a>
                        </li>
                        <li>
                            <strong>Phone:</strong> {{ $ride->customer->phone_number }}
                        </li>
                    </ul>
                </div>

                <div class="my-4 shadow-lg">
                    <h2 class="text-xl font-bold text-white-800 mb-4">Driver Information</h2>
                    <ul class="space-y-2">
                        <li>
                            <strong>Name:</strong> <a href="#">{{$ride->driver->first_name ?? ''}} {{ $ride->driver->first_name ?? 'Not Assigned' }}</a>
                        </li>
                        <li>
                            <strong>Email:</strong> <a href="#">{{$ride->driver->email ?? 'Not Assigned'}}</a>
                        </li>
                        <li>
                            <strong>Phone:</strong> {{ $ride->driver->phone_number ?? 'N/A' }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="my-4 shadow-lg">
                    <h2 class="text-xl font-bold text-white-800 mb-4">Customer Information</h2>
                    <ul class="space-y-2">
                        <li>
                            <strong>Channel:</strong> <a href="#">{{$ride->stream_channel_name}}</a>
                        </li>
                        <li>
                            <strong>Status:</strong> <a href="#">{{$ride->stream_status}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</section>
