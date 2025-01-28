<section class="content-wrapper">
    <x-loading />

    <section class="flex justify-between items-center">
        <h1 class="title">Online Drivers</h1>

        <div id="map" style="height: 500px; width: 100%;"></div>

        <div id="driver-details" class="hidden">
            <h3 id="driver-name"></h3>
            <p id="driver-info"></p>
        </div>
    </section>

</section>
@push('script')
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&libraries=places" async defer></script>

<script>
    let map;
    let markers = [];
    window.onload = function() {
        const drivers = "{{JSON_ENCODE($drivers)}}"; // This will be an array of drivers with lat/lng data
        initMap(drivers);
    };
    function initMap(drivers) {
        // Initialize the map centered on a default location
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 0, lng: 0 },
            zoom: 12
        });

        // Loop through drivers and place markers
        drivers.forEach((driver) => {
            const latLng = new google.maps.LatLng(driver.latitude, driver.longitude);

            // Create marker for each driver
            const marker = new google.maps.Marker({
                position: latLng,
                map: map,
                title: driver.username,
            });

            // Add an info window that will show when the marker is clicked
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div>
                        <h3>${driver.first_name} ${driver.last_name}</h3>
                        <p>${driver.email}</p>
                    </div>
                `
            });

            // When marker is clicked, open the info window
            marker.addListener('click', () => {
                infoWindow.open(map, marker);

                // Display driver details on the page
                document.getElementById('driver-name').innerText = driver.name;
                document.getElementById('driver-info').innerText = driver.info;
                document.getElementById('driver-details').classList.remove('hidden');
            });

            markers.push(marker);
        });
    }
</script>
@endpush
