<form id="checkoutForm">
    @csrf
    <div class="row">
        <div id="paymentErrorWallet" style="color: red;"></div>

        <div class="col-md-6 mb-3">
            <label>Full Name</label>
            <input type="text" name="full_name" readonly value="{{ old('full_name', Auth::user()->name) }}"
                class="form-control" required>
            @error('full_name')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <input type="hidden" name="product_id" value="{{ $id }}">
            <input type="hidden" name="quantity" value="{{ $quantity }}">
        </div>

        <div class="col-md-6 mb-3">
            <label>Email</label>
            <input type="email" name="email" readonly value="{{ old('email', Auth::user()->email) }}"
                class="form-control" required>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label>Phone</label>
            <input type="text" name="phone" readonly value="{{ old('phone', Auth::user()->phone_number) }}"
                class="form-control" required>
            @error('phone')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label>Delivery Date</label>
            <input type="date" name="date" class="form-control" value="{{ old('date') }}">
            @error('date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <div id="dateError" style="color: red;"></div>
        </div>

        <div hidden class="col-md-6 mb-3">
            <label>Shop</label>
            <input type="text" name="shop" class="form-control" value="{{ $shop }}">
            @error('shop')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>


        <div class="col-md-6 mb-3">
            <label>Payment Type</label>
            <select name="paymenttype" class="form-control">
                <option value="">Select...</option>
                <option value="cod" {{ old('paymenttype') == 'cod' ? 'selected' : '' }}>Cash on Delivery</option>
                <option value="wallet" {{ old('paymenttype') == 'wallet' ? 'selected' : '' }}>Wallet</option>
                <option value="online" {{ old('paymenttype') == 'online' ? 'selected' : '' }}>Online</option>
            </select>
            <div id="paymentTypeError" style="color: red;"></div>

            @error('paymenttype')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label>Note</label>
            <textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea>
            @error('note')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label>Select Location (Click on map)</label>
            <input type="text" id="searchBox" class="form-control mb-2" placeholder="Search...">

            <div id="autocompleteResults" class="autocomplete-result"></div>
            <div id="map" style="height: 400px;"></div>

            <input type="hidden" name="latitude" id="selectedLat" value="{{ old('latitude') }}">
            <input type="hidden" name="longitude" id="selectedLng" value="{{ old('longitude') }}">
            <input type="hidden" name="address" id="selectedAddress" value="{{ old('address') }}">

            <label class="mt-2">Selected Address</label>
            <input type="text" id="addressInput" class="form-control" readonly value="{{ old('address') }}">

            @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            @error('latitude')
                <small class="text-danger d-block">{{ $message }}</small>
            @enderror
            @error('longitude')
                <small class="text-danger d-block">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3 w-100">Place Order</button>
</form>

{{-- Styles --}}
<style>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $('#checkoutForm').on('submit', function(e) {
        e.preventDefault();
        $('#dateError').html("");
        $('#paymentTypeError').html("");
        $.ajax({
            url: "{{ route('checkout.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                console.log(response);

                if (response.paymenttype) {
                    // $('#paymentErrorWallet').html(response.paymenttype);
                    toastr.error(response.paymenttype);
                    return;
                }

                if (response.status == 'success' && response.message ==
                    'Your order has been placed!') {
                    toastr.success(response.message);
                    location.reload();
                }

            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    console.log(xhr.responseJSON.errors); // 👈 see what failed
                    let errors = xhr.responseJSON.errors;
                    console.log(errors);

                    let errorMessages = '';

                    // Display specific error messages under each field
                    if (errors.date) {
                        $('#dateError').html(errors.date[0]);
                    }
                    if (errors.paymenttype) {
                        $('#paymentTypeError').html(errors.paymenttype[0]);
                    }
                } else {
                    alert("Something went wrong.");
                }
            }

        });
    });
</script>


{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/ol@v10.1.0/dist/ol.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const MAPTILER_API_KEY = 'PUaOztgqHkXzwRSyKshM';

    const latInput = $('#selectedLat');
    const lngInput = $('#selectedLng');
    const addressInput = $('#addressInput');
    const addressHiddenInput = $('#selectedAddress');
    const searchBox = $('#searchBox');
    const resultsBox = $('#autocompleteResults');

    const vectorSource = new ol.source.Vector();
    const vectorLayer = new ol.layer.Vector({
        source: vectorSource
    });

    const map = new ol.Map({
        target: 'map',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.XYZ({
                    url: `https://api.maptiler.com/maps/streets-v2/256/{z}/{x}/{y}.png?key=${MAPTILER_API_KEY}`
                })
            }),
            vectorLayer
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([73.0551, 33.6844]),
            zoom: 6
        })
    });

    function isInPakistan([lng, lat]) {
        return lng >= 60.9 && lng <= 77.0 && lat >= 23.6 && lat <= 37.1;
    }

    function addMarker(coords) {
        if (!isInPakistan(coords)) {
            alert("Location outside Pakistan.");
            return;
        }

        vectorSource.clear();
        const marker = new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.fromLonLat(coords))
        });

        marker.setStyle(new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1],
                src: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                scale: 0.07
            })
        }));

        vectorSource.addFeature(marker);
        latInput.val(coords[1]);
        lngInput.val(coords[0]);

        fetch(`https://api.maptiler.com/geocoding/${coords[0]},${coords[1]}.json?key=${MAPTILER_API_KEY}`)
            .then(res => res.json())
            .then(data => {
                const address = data?.features?.[0]?.place_name || 'Address not found';
                addressInput.val(address);
                addressHiddenInput.val(address);
            });
    }

    map.on('click', function(e) {
        const coords = ol.proj.toLonLat(e.coordinate);
        addMarker(coords);
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
            const coords = [pos.coords.longitude, pos.coords.latitude];
            if (isInPakistan(coords)) {
                map.getView().setCenter(ol.proj.fromLonLat(coords));
                map.getView().setZoom(15);
                addMarker(coords);
            }
        });
    }

    let timeout;
    searchBox.on('input', function() {
        const query = $(this).val().trim();
        clearTimeout(timeout);
        if (query.length < 3) return resultsBox.html('');

        timeout = setTimeout(() => {
            fetch(
                    `https://api.maptiler.com/geocoding/${encodeURIComponent(query)}.json?key=${MAPTILER_API_KEY}&country=PK`
                )
                .then(res => res.json())
                .then(data => {
                    resultsBox.html('');
                    data.features.forEach(f => {
                        const [lng, lat] = f.geometry.coordinates;
                        if (!isInPakistan([lng, lat])) return;
                        const item = $('<div></div>').text(f.place_name);
                        item.on('click', () => {
                            map.getView().setCenter(ol.proj.fromLonLat([lng, lat]));
                            map.getView().setZoom(15);
                            addMarker([lng, lat]);
                            searchBox.val(f.place_name);
                            resultsBox.html('');
                        });
                        resultsBox.append(item);
                    });
                });
        }, 400);
    });
</script>
