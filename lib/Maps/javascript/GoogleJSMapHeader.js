var map;
var userLocationMarker;
var initLat = ___INITIAL_LATITUDE___;
var initLon = ___INITIAL_LONGITUDE___;
var dragListener = null;
var recenterMap;

function loadMap() {
    var mapImage = document.getElementById("___MAPELEMENT___");
    mapImage.style.display = "inline-block";

    var initCoord = new google.maps.LatLng(___CENTER_LATITUDE___, ___CENTER_LONGITUDE___);
    var options = {
        zoom: ___ZOOMLEVEL___,
        center: initCoord,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: false,
        panControl: false,
        zoomControl: false,
        scaleControl: false,
        streetViewControl: false
    };

    map = new google.maps.Map(mapImage, options);

    mapControls.setup({
        zoomin: function() {
            map.setZoom(map.getZoom() + 1);
        },
        zoomout: function() {
            map.setZoom(map.getZoom() - 1);
        },
        recenter: function() {
            map.setCenter(initCoord);
        },
        locationUpdated: function(location) {
            var position = new google.maps.LatLng(location.coords.latitude, location.coords.longitude);
            if (typeof userLocationMarker == 'undefined') {
                // TODO make these more customizable
                var icon = new google.maps.MarkerImage('modules/map/images/map-location@2x.png',
                    null, // original size
                    null, // origin (0, 0)
                    new google.maps.Point(8, 8), // anchor
                    new google.maps.Size(16, 16)); // scaled size

                userLocationMarker = new google.maps.Marker({
                    'clickable' : false,
                    'map'       : map,
                    'position'  : position,
                    'flat'      : true,
                    'icon'      : icon
                });

                map.setCenter(position);

            } else {
                if (userLocationMarker.getMap() === null) {
                    userLocationMarker.setMap(map);
                }
                userLocationMarker.setPosition(position);
                map.setCenter(position);
            }

            if (dragListener === null) {
                dragListener = google.maps.event.addDomListener(map, 'drag', function() {
                    mapControls.stopLocationUpdates(); // this gets bound to something after setup() is complete
                    google.maps.event.removeListener(dragListener);
                    dragListener = null;
                });
            }
        },
        locationUpdateStopped: function() {
            if (typeof userLocationMarker != 'undefined') {
                userLocationMarker.setMap(null); // remove marker
            }
        }
    });
}

function resizeMapOnContainerResize() {
    if (map) {
        google.maps.event.trigger(map, 'resize');
    }
}


