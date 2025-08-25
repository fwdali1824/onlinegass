<div>

    <style>
        .invalid-feedback {
            color: red;
        }

        .col-md-6.mb-3 {
            margin-top: 12px;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v10.1.0/ol.css">
    <script src="https://cdn.jsdelivr.net/npm/ol@v10.1.0/dist/ol.js"></script>
    <script src="https://unpkg.com/ol-mapbox-style@12.1.1/dist/olms.js"></script>

    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 8px;
        }

        #searchBox {
            margin-bottom: 10px;
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }

        .autocomplete-result {
            background: white;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            z-index: 9999;
            width: 100%;
        }

        .autocomplete-result div {
            padding: 8px;
            cursor: pointer;
        }

        .autocomplete-result div:hover {
            background-color: #f1f1f1;
        }
    </style>


    <style>
        .form-control:focus {
            box-shadow: none;
            border-color: #4e73df;
        }

        .order-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 0.5rem;
        }

        .invalid-feedback {
            color: red;
        }

        .col-md-6.mb-3 {
            margin-top: 12px;
        }
    </style>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form wire:submit.prevent="placeOrder">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" readonly wire:model.lazy="full_name"
                    class="form-control @error('full_name') is-invalid @enderror" placeholder="John Doe">
                @error('full_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" readonly wire:model.lazy="email"
                    class="form-control @error('email') is-invalid @enderror" placeholder="email@example.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" readonly wire:model.lazy="phone"
                    class="form-control @error('phone') is-invalid @enderror" placeholder="03xx-xxxxxxx">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Delivery Date</label>
                <input type="date" wire:model.lazy="date" class="form-control @error('date') is-invalid @enderror">
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="paymenttype" class="form-label">Payment Type</label>
                <select wire:model.lazy="paymenttype" id="paymenttype"
                    class="form-control @error('paymenttype') is-invalid @enderror">
                    <option value="">Please select</option>
                    <option value="online">Online</option>
                    <option value="cod">Cash on Delivery</option>
                    <option value="wallet">Wallet</option>
                </select>
                @error('paymenttype')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>



        <!-- Notes section as a full-width field -->
        <div class="mb-3" style="margin-top: 12px;">
            <label class="form-label">Notes</label>
            <textarea wire:model.lazy="note" rows="3" class="form-control @error('note') is-invalid @enderror"
                placeholder="Notes"></textarea>
            @error('note')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3" style="margin-top: 12px">
            <label class="form-label">Select Delivery Location on Map</label>

            <input type="text" id="searchBox" placeholder="Search within Pakistan..." class="form-control mb-2" />
            <div id="autocompleteResults" class="autocomplete-result"
                style="position: absolute; z-index: 1000; background: #fff; width: 100%;">
            </div>

            <div id="map" wire:ignore style="height: 400px; border-radius: 8px;">
            </div>

            <input type="text" id="selectedLat" wire:model.lazy="latitude">
            <input type="text" id="selectedLng" wire:model.lazy="longitude">
            <input type="text" id="selectedAddress" wire:model.lazy="address">

            <label class="form-label mt-2">Selected Address</label>
            <input type="text" id="addressInput" class="form-control" readonly
                placeholder="Selected address will appear here">
        </div>

        <button type="submit" class="btn theme-btn w-100 mt-3" style="margin-top:10px;">Place Order</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/ol@v10.1.0/dist/ol.js"></script>
    <!-- Make sure jQuery is loaded -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        const MAPTILER_API_KEY = 'PUaOztgqHkXzwRSyKshM';

        const vectorSource = new ol.source.Vector();
        const vectorLayer = new ol.layer.Vector({
            source: vectorSource
        });

        const pakistanExtent = ol.proj.transformExtent(
            [60.9, 23.6, 77.0, 37.1], 'EPSG:4326', 'EPSG:3857'
        );

        const map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.XYZ({
                        url: `https://api.maptiler.com/maps/streets-v2/256/{z}/{x}/{y}.png?key=${MAPTILER_API_KEY}`,
                        tileSize: 256
                    })
                }),
                vectorLayer
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([73.0551, 33.6844]), // Islamabad
                zoom: 6,
                extent: pakistanExtent,
                constrainOnlyCenter: true,
                minZoom: 5,
                maxZoom: 18
            })
        });

        function isInPakistan([lng, lat]) {
            return lng >= 60.9 && lng <= 77.0 && lat >= 23.6 && lat <= 37.1;
        }

        function addMarker(coords) {
            if (!isInPakistan(coords)) {
                alert("Selected location is outside Pakistan.");
                return;
            }

            vectorSource.clear();

            const iconFeature = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat(coords))
            });

            iconFeature.setStyle(new ol.style.Style({
                image: new ol.style.Icon({
                    anchor: [0.5, 1],
                    src: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                    scale: 0.07
                })
            }));

            vectorSource.addFeature(iconFeature);

            const [lng, lat] = coords;
            $('#selectedLat').val(lat);
            $('#selectedLng').val(lng);

            const livewireId = $('[wire\\:id]').attr('wire:id');

            if (typeof Livewire !== 'undefined' && livewireId) {
                Livewire.find(livewireId).set('latitude', lat);
                Livewire.find(livewireId).set('longitude', lng);
            }

            $.getJSON(`https://api.maptiler.com/geocoding/${lng},${lat}.json?key=${MAPTILER_API_KEY}&language=en`, function(
                data) {
                const address = data?.features?.[0]?.place_name || 'Address not found';
                $('#addressInput').val(address);
                $('#selectedAddress').val(address);

                if (typeof Livewire !== 'undefined' && livewireId) {
                    Livewire.find(livewireId).set('address', address);
                }
            });
        }

        // On map click
        map.on('click', function(e) {
            const coords = ol.proj.toLonLat(e.coordinate);
            addMarker(coords);
        });

        // Geolocation on load
        $(function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(pos) {
                        const coords = [pos.coords.longitude, pos.coords.latitude];
                        if (isInPakistan(coords)) {
                            map.getView().setCenter(ol.proj.fromLonLat(coords));
                            map.getView().setZoom(15);
                            addMarker(coords);
                        } else {
                            addMarker([73.0551, 33.6844]);
                        }
                    },
                    function() {
                        addMarker([73.0551, 33.6844]);
                    }
                );
            }
        });

        // Search autocomplete
        let timeout;
        $('#searchBox').on('input', function() {
            const query = $(this).val().trim();
            clearTimeout(timeout);
            if (query.length < 3) {
                $('#autocompleteResults').html('');
                return;
            }

            timeout = setTimeout(function() {
                $.getJSON(
                    `https://api.maptiler.com/geocoding/${encodeURIComponent(query)}.json?key=${MAPTILER_API_KEY}&country=PK`,
                    function(data) {
                        $('#autocompleteResults').html('');
                        data.features.forEach(function(feature) {
                            const [lng, lat] = feature.geometry.coordinates;
                            if (!isInPakistan([lng, lat])) return;

                            const item = $('<div>')
                                .text(feature.place_name)
                                .css({
                                    padding: '5px',
                                    cursor: 'pointer',
                                    borderBottom: '1px solid #eee'
                                })
                                .on('click', function() {
                                    map.getView().setCenter(ol.proj.fromLonLat([lng, lat]));
                                    map.getView().setZoom(15);
                                    addMarker([lng, lat]);
                                    $('#searchBox').val(feature.place_name);
                                    $('#autocompleteResults').html('');
                                });

                            $('#autocompleteResults').append(item);
                        });
                    });
            }, 400);
        });
    </script>

</div>
