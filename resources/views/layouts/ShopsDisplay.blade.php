  <!-- Map Section -->
  <div id="map" style="width: 100%; height: 400px; margin-top: 40px;"></div>
  @php
      $shops = DB::table('shops')->get();
  @endphp
  <script src="https://cdn.jsdelivr.net/npm/ol@v10.1.0/dist/ol.js"></script>
  <script>
      const MAPTILER_API_KEY = 'PUaOztgqHkXzwRSyKshM';
      // Shop data from backend
      const shops = @json($shops);

      // Default center (Pakistan)
      let center = [71.5249, 30.1575];
      let zoom = 5;
      let shopMarker = null;

      if (shops.length > 0) {
          // Use first shop's lat/lng for center
          center = [parseFloat(shops[0].long), parseFloat(shops[0].lat)];
          zoom = 13;
      }

      const map = new ol.Map({
          target: 'map',
          layers: [
              new ol.layer.Tile({
                  source: new ol.source.XYZ({
                      url: `https://api.maptiler.com/maps/streets/256/{z}/{x}/{y}.png?key=${MAPTILER_API_KEY}`,
                      attributions: '© MapTiler © OpenStreetMap contributors'
                  })
              })
          ],
          view: new ol.View({
              center: ol.proj.fromLonLat(center),
              zoom: zoom
          })
      });

      if (shops.length > 0) {
          const shopFeatures = shops.map(shop => {
              const feature = new ol.Feature({
                  geometry: new ol.geom.Point(ol.proj.fromLonLat([parseFloat(shop.long), parseFloat(shop
                      .lat)])),
                  name: shop.name,
                  shopId: shop.id
              });
              feature.setStyle(new ol.style.Style({
                  image: new ol.style.Icon({
                      anchor: [0.5, 1],
                      src: 'https://cdn.mapmarker.io/api/v1/pin?icon=shop&size=50&background=%23fd5f17'
                  }),
                  text: new ol.style.Text({
                      text: shop.name,
                      offsetY: -30,
                      font: 'bold 14px Arial',
                      fill: new ol.style.Fill({
                          color: '#fd5f17'
                      }),
                      stroke: new ol.style.Stroke({
                          color: '#fff',
                          width: 2
                      })
                  })
              }));
              return feature;
          });
          const vectorSource = new ol.source.Vector({
              features: shopFeatures
          });
          const vectorLayer = new ol.layer.Vector({
              source: vectorSource
          });
          map.addLayer(vectorLayer);

          // Add click event for shop markers
          map.on('singleclick', function(evt) {
              map.forEachFeatureAtPixel(evt.pixel, function(feature) {
                  if (feature.get('shopId')) {
                      window.livewire.emit('shopMarkerClicked', feature.get('shopId'));
                  }
              });
          });
      }
  </script>
