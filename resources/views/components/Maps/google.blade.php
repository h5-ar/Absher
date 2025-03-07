@props([
    'label' => '',
    'size' => 'col-12 my-2',
    'long' => '36.287841796875',
    'lat' => '33.49559774486575',
    'editable' => true,
    'description' => false,
])

<div class="{{ $size }}">
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="card-title">{{ translate($label) }}
                <x-SVG.alert-circle description="{{ $description }}" />
            </h4>
        </div>
        <div class="card-body">
            <div id="map"></div>
        </div>
        @if ($editable === true)
            <input type="hidden" name="long" id="long" value="{{ $long }}">
            <input type="hidden" name="lat" id="lat" value="{{ $lat }}">
        @else
            <input type="hidden" name="long" id="long">
            <input type="hidden" name="lat" id="lat">
        @endif
    </div>
</div>


@push('layout-scripts')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap">
    </script>
    <script>
        let map;
        let marker;

        function initMap() {
            var initLong = parseFloat('{{ $long }}');
            var initLat = parseFloat('{{ $lat }}');

            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: initLat,
                    lng: initLong
                },
                zoom: 10
            });

            marker = new google.maps.Marker({
                position: {
                    lat: initLat,
                    lng: initLong
                },
                map: map,
                draggable: true
            });

            @if ($editable === true)

                // Update marker position on marker drag
                marker.addListener('dragend', function(event) {
                    updateMarkerPosition(marker.getPosition());
                });

                // Update marker position on map click
                map.addListener('click', function(event) {
                    marker.setPosition(event.latLng);
                    updateMarkerPosition(marker.getPosition());
                });
            @endif
        }

        function updateMarkerPosition(latLng) {
            $('#long').val(latLng.lng());
            $('#lat').val(latLng.lat());
        }
    </script>
@endpush
