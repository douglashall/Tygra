var loadedImages = {};
var centerZoomBased;
var staticMapOptions;
var mapWidth;
var mapHeight;
var apiURL;

// id7 doesn't understand window.innerWidth and window.innerHeight
function getWindowHeight() {
    if (window.innerHeight !== undefined) {
        return window.innerHeight;
    } else {
        return document.documentElement.clientHeight;
    }
}

function getWindowWidth() {
    if (window.innerWidth !== undefined) {
        return window.innerWidth;
    } else {
        return document.documentElement.clientWidth;
    }
}

function hideMapTabChildren() {
    var mapImage = document.getElementById("mapimage");
    if (mapImage) {
        mapImage.className = "";
    }
    var staticMapImage = document.getElementById("staticmapimage");
    if (staticMapImage) {
        staticMapImage.parentNode.removeChild(staticMapImage);
    }
    var mapScrollers = document.getElementById("mapscrollers");
    if (mapScrollers) {
        mapScrollers.parentNode.removeChild(mapScrollers);
    }
}

function loadImage(imageURL,imageID) {
    if (!loadedImages[imageID]) {
        // Loads an image from the given URL into the image with the specified ID
        var img = document.getElementById(imageID);
        if (img) {
            if (imageURL != "") {
                img.src = imageURL;
            } else {
                img.src = "/common/images/blank.png";
            }
        }
        loadedImages[imageID] = true;
    }
}

function loadMapImage(newSrc) {
    var query = newSrc.substring(newSrc.indexOf("?") + 1, newSrc.length);
    staticMapOptions["query"] = escape(query);

    var mapImage = document.getElementById("staticmapimage");
    var oldSrc = mapImage.src;
    mapImage.src = newSrc;
    if (oldSrc != mapImage.src) {
        show("loadingimage");
    }
    mapImage.src = newSrc; // guarentee onload handler gets called at least 
                           // once after showing the loading image (even for cached images)
    mapImage.width = mapWidth;
    mapImage.style.width = mapWidth + "px";
    mapImage.height = mapHeight;
    mapImage.style.height = mapHeight + "px";
}

function pixelsFromString(aString) {
    if (aString.substring(aString.length - 2, aString.length) == "px") {
        return aString.substring(0, aString.length - 2);
    } else if (aString.substring(aString.length - 1, aString.length) == "%") {
        return aString.substring(0, aString.length - 1);
    }
    return aString;
}

var mapControls = {
    recenterMap: function() {},
    locationUpdated: function(location) {},
    locationUpdateStopped: function() {},
    locateMeButton: null,
    timerId: null,
    toggleLocationUpdates: function() {
        if (this.timerId === null) {
            this.startLocationUpdates();
        } else {
            this.stopLocationUpdates();
            this.recenterMap();
        }
    },
    startLocationUpdates: function() {
        this.locateMeButton.style.backgroundPosition = "-200px 0";
        if (this.timerId === null) {
            var that = this;
            this.timerId = setInterval(function() {
                navigator.geolocation.getCurrentPosition(
                    that.locationUpdated,
                    that.locationUpdateStopped,
                    {enableHighAccuracy: true});
               }, 5000);
        }
    },
    // draggable maps should also call this if user drags the map while updates are on
    stopLocationUpdates: function() {
        this.locateMeButton.style.backgroundPosition = "-160px 0";
        if (this.timerId !== null) {
            clearInterval(this.timerId);
            this.timerId = null;
            this.locationUpdateStopped();
        }
    },

    // params: { zoomin:Function,zoomout:Function,recenter:Function,
    //   ?locationUpdated:Function,?locationUpdateStopped:Function }
    setup: function(args) {
        this.recenter = args.recenter;
        if ("locationUpdated" in args) {
            this.locationUpdated = args.locationUpdated;
        }
        if ("locationUpdateStopped" in args) {
            this.locationUpdateStopped = args.locationUpdateStopped;
        }

        var zoominButton = document.getElementById("zoomin");
        zoominButton.onclick = args.zoomin;

        var zoomoutButton = document.getElementById("zoomout");
        zoomoutButton.onclick = args.zoomout;

        var recenterButton = document.getElementById("recenter");
        recenterButton.onclick = this.recenter;

        this.locateMeButton = document.getElementById("locateMe");
        if ("geolocation" in navigator && typeof(showUserLocation) != 'undefined') {
            var that = this;
            this.locateMeButton.onclick = function() {
                that.toggleLocationUpdates();
            };
        } else {
            this.locateMeButton.parentNode.removeChild(this.locateMeButton);
            // realign other buttons
            zoomoutButton.style.left = "35%";
            recenterButton.style.left = "64%";
        }
    }
}

function addStaticMapControls() {
    if (!staticMapOptions) {
        return;
    }

    var objMap = document.getElementById("staticmapimage");
    mapWidth = objMap.clientWidth;
    mapHeight = objMap.clientHeight;

    var query = objMap.src;
    query = query.substring(query.indexOf("?") + 1, query.length);
    staticMapOptions["query"] = escape(query);

    centerZoomBased = ("center" in staticMapOptions);

    var recenter;

    if (centerZoomBased) {
        var initCenterLat = staticMapOptions['center']['lat'];
        var initCenterLon = staticMapOptions['center']['lon'];
        var initZoom = staticMapOptions['zoom'];

        recenter = function() {
            updateMapImage(null, null, {
                "center": initCenterLat + "," + initCenterLon,
                "zoom": initZoom
            });
        }

    } else {
        var initBBox = staticMapOptions['bbox'];

        recenter = function() {
            var bboxStr = bbox['xmin'] + "," + bbox['ymin'] + "," + bbox['xmax'] + "," + bbox['ymax'];
            updateMapImage(null, null, {"bbox": bboxStr});
        }
    }

    mapControls.setup({
        zoomin: function() {
            updateMapImage("in", null, null);
        },
        zoomout: function() {
            updateMapImage("out", null, null);
        },
        recenter: recenter,
        locationUpdated: function(location) {
            mapControls.stopLocationUpdates();
            var params = {
                'userLat': location.coords.latitude,
                'userLon': location.coords.longitude,
                'center': location.coords.latitude + "," + location.coords.longitude,
            };
            updateMapImage(null, null, params);
        }
    });
}

// n, s, e, w, ne, nw, se, sw
function scrollMap(direction) {
    updateMapImage(null, direction, null);
}

function updateMapImage(zoomDir, scrollDir, overrides) {
    if (!("query" in staticMapOptions)) {
        return;
    }

    params = {
        "baseURL": staticMapOptions["baseURL"],
        "mapClass": staticMapOptions["mapClass"],
        "query": staticMapOptions["query"]};

    if (zoomDir) {
        params["zoom"] = zoomDir;
    }
    if (scrollDir) {
        params["scroll"] = scrollDir;
    }
    if (overrides) {
        overrideParams = [];
        for (var override in overrides) {
            overrideParams.push(override + "=" + overrides[override]);
        }
        if (overrideParams.length) {
            params["overrides"] = escape(overrideParams.join("&"));
        }
    }
    apiRequest(apiURL, params, function(response) {
        loadMapImage(response);
    }, function(code, message) {});
}


// assuming only one of updateMapDimensions or updateContainerDimensions
// gets used so they can reference the same ids
// updateMapDimensions is called for static maps
// updateContainerDimensions is called for dynamic maps
var updateMapDimensionsTimeoutIds = [];
function clearUpdateMapDimensionsTimeouts() {
    for(var i = 0; i < updateMapDimensionsTimeoutIds.length; i++) {
        window.clearTimeout(updateMapDimensionsTimeoutIds[i]);
    }
    updateMapDimensionsTimeoutIds = [];
}

// Prevent firebombing the browser with Ajax calls on browsers which fire lots
// of resize events
function updateMapDimensions() {
    clearUpdateMapDimensionsTimeouts();
    var timeoutId = window.setTimeout(doUpdateMapDimensions, 200);
    updateMapDimensionsTimeoutIds.push(timeoutId);
    timeoutId = window.setTimeout(doUpdateMapDimensions, 500);
    updateMapDimensionsTimeoutIds.push(timeoutId);
}

function doUpdateMapDimensions() {
    var oldHeight = mapHeight;
    var oldWidth = mapWidth;

    // TODO google static maps does not generate maps
    // larger than 1000px in either direction
    // need to set caps on mapWidth and mapHeight
    var mapImage = document.getElementById("mapimage");
    var mapTab = document.getElementById("mapTab");
    if (mapImage && mapTab) { // not fullscreen
        mapTab.style.height="auto";

        var topoffset = findPosY(document.getElementById("tabbodies"));
        var bottomoffset = 56;
        
        document.getElementById("mapzoom").style.height = bottomoffset + "px";

        // tablets need to account for bottom nav
        var tabletFoot = document.getElementById("footernav");
        if (tabletFoot) {
            bottomoffset += tabletFoot.clientHeight;
        }

        // 16 is top + bottom padding of mapimage
        // TODO don't hard code these numbers
        mapHeight = (getWindowHeight() - topoffset - bottomoffset - 16);
        mapWidth = getWindowWidth() - 30;

        mapImage.style.width = (mapWidth + 2) + "px"; // border

    } else { // fullscreen
        mapHeight = getWindowHeight();
        mapWidth = getWindowWidth();
        mapImage.style.width = mapWidth+"px";

        var objContainer = document.getElementById("container");
        if (objContainer) {
            objContainer.style.width = mapWidth+"px";
            objContainer.style.height = mapHeight+"px";
        }
    }
    mapImage.style.height = mapHeight + "px";

    var objScrollers = document.getElementById("mapscrollers");
    if (objScrollers) {
        if (mapTab) {
            objScrollers.style.height = mapHeight+"px";
            objScrollers.style.width = mapWidth+"px";

        } else {
            switch (getOrientation()) {
                case 'portrait':
                  objScrollers.style.height = (mapHeight-42)+"px";
                  objScrollers.style.width = mapWidth+"px";
                 break;
        
                case 'landscape':
                  objScrollers.style.height = mapHeight+"px";
                  objScrollers.style.width = (mapWidth-42)+"px";
                break;
            }
        }
    }

    // request new map image if needed

    var overrides = {};

    if ((oldWidth && oldWidth != mapWidth) || (oldHeight && oldHeight != mapHeight)) {
        // sometimes centerZoomBased gets defined later
        if (!centerZoomBased && "bbox" in staticMapOptions) {
            // if width and height changed, we need to update the bbox
            var bbox = staticMapOptions['bbox'];
            var bboxWidth = bbox['xmax'] - bbox['xmin'];
            var bboxHeight = bbox['ymax'] - bbox['ymin'];
            var newBBoxWidth = bboxWidth * mapWidth / oldWidth;
            var newBBoxHeight = bboxHeight * mapHeight / oldHeight;
            
            var dWidth = (newBBoxWidth - bboxWidth) / 2;
            var dHeight = (newBBoxHeight - bboxHeight) / 2;
            
            bbox['xmax'] += dWidth;
            bbox['xmin'] -= dWidth;
            bbox['ymax'] += dHeight;
            bbox['ymin'] -= dHeight;
            
            staticMapOptions['bbox'] = bbox;

            overrides["bbox"] = bbox['xmin'] + "," + bbox['ymin'] + "," + bbox['xmax'] + "," + bbox['ymax'];
            overrides["size"] = mapWidth + "," + mapHeight;
            overrides["width"] = mapWidth;
            overrides["height"] = mapHeight;
        } else {
            overrides["size"] = mapWidth + "x" + mapHeight;
        }
    
        updateMapImage(null, null, overrides);
    }
}

// resizing counterpart for dynamic maps
function updateContainerDimensions() {
    clearUpdateMapDimensionsTimeouts();
    var timeoutId = window.setTimeout(doUpdateContainerDimensions, 200);
    updateMapDimensionsTimeoutIds.push(timeoutId);
    timeoutId = window.setTimeout(doUpdateContainerDimensions, 500);
    updateMapDimensionsTimeoutIds.push(timeoutId);
    timeoutId = window.setTimeout(doUpdateContainerDimensions, 1000);
    updateMapDimensionsTimeoutIds.push(timeoutId);
}

// doUpdateContainerDimensions is split into detail-common.js and fullscreen-common.js

function addDirectionsLink() {
    if ("geolocation" in navigator) {
        var directionsLink = document.getElementById("directionsLink");
        if (directionsLink) {
            navigator.geolocation.getCurrentPosition(
                function(location) {
                    directionsLink.href += "&saddr=" + location.coords.latitude + "," + location.coords.longitude;
                },
                function() {}, {}
            );
        }
    }
}



