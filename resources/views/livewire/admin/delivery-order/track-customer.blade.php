<div>
    <div class="p-4 space-y-4">
        <h2 class="text-2xl font-bold mb-4">Track Route to Customer</h2>

        <div class="flex items-center gap-4 ">
            <select style="width: 170px" class="border px-4 py-2 rounded" wire:model="orderId">
                <option value="">Please Select</option>
                @foreach ($ordersList as $item)
                    <option value="{{ $item->orderid }}">{{ $item->orderid }}</option>
                @endforeach
            </select>
            {{-- <input type="text" wire:model="orderId" placeholder="Enter Order Number"
                class="border px-4 py-2 rounded w-64"> --}}
            <button wire:click="searchOrder" id="searchBtn"
                class="bg-blue-600 text-black px-3 py-2 rounded">Search</button>
            <button id="googleMapsBtn" class="bg-blue-600 text-black px-3 py-2 rounded">
                Google Maps
            </button>
        </div>

        @if ($error)
            <div class="text-red-600">{{ $error }}</div>
        @endif
        <br><br>

        <div id="map" wire:ignore style="width: 100%; height: 400px;"></div>
    </div>

    <!-- Dependencies -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v10.1.0/ol.css" />
    <script src="https://cdn.jsdelivr.net/npm/ol@v10.1.0/dist/ol.js"></script>
    <script src="https://unpkg.com/@mapbox/polyline"></script>

    <script>
        let map, vectorSource, userMarker, customerMarker;
        let routeFeatures = [];
        let userCoords = null;

        const ORS_API_KEY =
            'eyJvcmciOiI1YjNjZTM1OTc4NTExMTAwMDFjZjYyNDgiLCJpZCI6IjgzZTJiMjFlYmY5MDQ4NDI4Mzk1ZGRhZGIxYzdkYjgwIiwiaCI6Im11cm11cjY0In0='; // replace with your actual ORS API key

        document.addEventListener('DOMContentLoaded', () => {
            vectorSource = new ol.source.Vector();
            const markerLayer = new ol.layer.Vector({
                source: vectorSource
            });

            map = new ol.Map({
                target: 'map',
                layers: [
                    new ol.layer.Tile({
                        source: new ol.source.OSM()
                    }),
                    markerLayer
                ],
                view: new ol.View({
                    center: ol.proj.fromLonLat([73.0479, 33.6844]),
                    zoom: 10
                })
            });

            if ('geolocation' in navigator) {
                navigator.geolocation.watchPosition(pos => {
                    userCoords = [pos.coords.longitude, pos.coords.latitude];
                    addUserMarker(userCoords);

                    const lat = @this.customerLat;
                    const lng = @this.customerLng;

                    if (lat && lng) {
                        updateCustomerMarker(lat, lng);
                        getRoutes(userCoords, [lng, lat]);
                    }
                }, () => {
                    alert('Geolocation permission denied.');
                }, {
                    enableHighAccuracy: true,
                    maximumAge: 1000,
                    timeout: 5000
                });
            }
        });

        function addUserMarker(coords) {
            if (userMarker) vectorSource.removeFeature(userMarker);

            userMarker = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat(coords))
            });

            userMarker.setStyle(new ol.style.Style({
                image: new ol.style.Icon({
                    src: 'https://cdn-icons-png.flaticon.com/512/1077/1077012.png',
                    scale: 0.05
                }),
                text: new ol.style.Text({
                    text: 'My Location',
                    offsetY: -25,
                    fill: new ol.style.Fill({
                        color: 'blue'
                    }),
                    stroke: new ol.style.Stroke({
                        color: 'white',
                        width: 3
                    }),
                    font: 'bold 14px Arial'
                })
            }));

            vectorSource.addFeature(userMarker);
        }

        function updateCustomerMarker(lat, lng) {
            if (customerMarker) vectorSource.removeFeature(customerMarker);

            customerMarker = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat([lng, lat]))
            });

            customerMarker.setStyle(new ol.style.Style({
                image: new ol.style.Icon({
                    src: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                    scale: 0.05
                }),
                text: new ol.style.Text({
                    text: 'Customer',
                    offsetY: -25,
                    fill: new ol.style.Fill({
                        color: 'red'
                    }),
                    stroke: new ol.style.Stroke({
                        color: 'white',
                        width: 3
                    }),
                    font: 'bold 14px Arial'
                })
            }));

            vectorSource.addFeature(customerMarker);
        }

        function calculateBearing(lat1, lon1, lat2, lon2) {
            const toRad = deg => deg * Math.PI / 180;
            const toDeg = rad => rad * 180 / Math.PI;

            const dLon = toRad(lon2 - lon1);
            const y = Math.sin(dLon) * Math.cos(toRad(lat2));
            const x = Math.cos(toRad(lat1)) * Math.sin(toRad(lat2)) -
                Math.sin(toRad(lat1)) * Math.cos(toRad(lat2)) * Math.cos(dLon);
            const bearing = toDeg(Math.atan2(y, x));
            return (bearing + 360) % 360;
        }

        async function getRoutes(start, end) {
            const url = 'https://api.openrouteservice.org/v2/directions/driving-car';

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': ORS_API_KEY
                    },
                    body: JSON.stringify({
                        coordinates: [start, end],
                        alternative_routes: {
                            target_count: 2,
                            share_factor: 0.6,
                            weight_factor: 1.4
                        }
                    })
                });

                const json = await res.json();

                // Remove old features
                routeFeatures.forEach(f => vectorSource.removeFeature(f));
                routeFeatures = [];

                if (!json.routes?.length) {
                    alert("No route found.");
                    return;
                }

                json.routes.forEach((route, index) => {
                    const decoded = polyline.decode(route.geometry);
                    const coords = decoded.map(([lat, lng]) => ol.proj.fromLonLat([lng, lat]));

                    // Draw route line
                    const geom = new ol.geom.LineString(coords);
                    const feature = new ol.Feature({
                        geometry: geom
                    });

                    feature.setStyle(new ol.style.Style({
                        stroke: new ol.style.Stroke({
                            color: index === 0 ? 'blue' : 'gray',
                            width: index === 0 ? 4 : 2,
                            lineDash: index === 0 ? undefined : [10, 10]
                        })
                    }));

                    vectorSource.addFeature(feature);
                    routeFeatures.push(feature);

                    // Add arrows every 10 steps
                    for (let i = 0; i < decoded.length - 1; i += 10) {
                        const [lat1, lng1] = decoded[i];
                        const [lat2, lng2] = decoded[i + 1];
                        const bearing = calculateBearing(lat1, lng1, lat2, lng2);

                        const arrow = new ol.Feature({
                            geometry: new ol.geom.Point(ol.proj.fromLonLat([lng1, lat1]))
                        });

                        arrow.setStyle(new ol.style.Style({
                            image: new ol.style.Icon({
                                src: 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Red_Arrow_Up.svg/32px-Red_Arrow_Up.svg.png',
                                scale: 0.5,
                                rotation: bearing * Math.PI / 180,
                                rotateWithView: true
                            })
                        }));

                        vectorSource.addFeature(arrow);
                        routeFeatures.push(arrow);
                    }
                });

                const mainLine = routeFeatures[0].getGeometry();
                map.getView().fit(mainLine.getExtent(), {
                    padding: [50, 50, 50, 50],
                    maxZoom: 16
                });

            } catch (e) {
                console.error('Route error', e);
                alert('Route fetch failed.');
            }
        }

        // Livewire event after Search click
        document.getElementById('searchBtn').addEventListener('click', () => {
            setTimeout(() => {
                const lat = @this.customerLat;
                const lng = @this.customerLng;

                if (lat && lng) {
                    updateCustomerMarker(lat, lng);
                    if (userCoords) getRoutes(userCoords, [lng, lat]);
                }
            }, 500);
        });
    </script>

    <script>
        // Google Maps Navigation Handler
        document.getElementById('googleMapsBtn').addEventListener('click', () => {
            if (!userCoords) {
                alert('User location not available yet.');
                return;
            }

            const origin = `${userCoords[1]},${userCoords[0]}`;
            const destLat = @this.customerLat;
            const destLng = @this.customerLng;

            if (!destLat || !destLng) {
                alert('Customer location not set.');
                return;
            }

            const destination = `${destLat},${destLng}`;
            const isAndroid = /Android/i.test(navigator.userAgent);

            let url = '';

            if (isAndroid) {
                // Android App Deep Link
                url =
                    `intent://maps.google.com/maps?daddr=${destination}&travelmode=driving#Intent;package=com.google.android.apps.maps;scheme=https;end`;
            } else {
                // Web Google Maps
                url =
                    `https://www.google.com/maps/dir/?api=1&origin=${origin}&destination=${destination}&travelmode=driving`;
            }

            window.open(url, '_blank');
        });
    </script>
</div>
