##########
Map Module
##########

The map module allows you to browse and search for places and view them on a map.
Places may be grouped by feed groups, category, and subcategory.

========================
Configuring Feed Groups
========================

Each feed group corresponds to a base map, characterized by center location
and background appearance.  For organizations with multiple campuses, feed
groups are a logical way to split up maps by campus.

Groups are configured in the *SITE_DIR/config/map/feedgroups.ini* file.  There
must be at least one entry that looks like the following: ::

    [groupID]
    title                = "Title of my map"
    subtitle             = "Subtitle of my map"
    center               = "42.3584308,-71.0597732"
    JS_MAP_CLASS         = "ArcGISJSMap"
    DYNAMIC_MAP_BASE_URL = "http://myhost/MapServer"
    STATIC_MAP_CLASS     = ArcGISStaticMap
    STATIC_MAP_BASE_URL  = "http://myhost/MapServer"


* *[groupID]* is a short, alphanumeric identifier for the group, e.g. "boston",
  "newyork", "daytime", etc.
* *title* (required) - a short description of this group, e.g. "Boston Campus"
* *subtitle* (optional) - more explanatory text if title is not sufficient.
* *center* (required) - the latitude, longitude point that represents the 
  center of this group
* *JS_MAP_CLASS* (optional) - the type of base map to use for devices that 
  support JavaScript maps, see :ref:`section-base-map-types`.
* *DYNAMIC_MAP_BASE_URL* (required if *JS_MAP_CLASS* is ArcGISJSMap) - the base 
  URL where the base map JavaScript API is hosted.
* *STATIC_MAP_CLASS* (optional) - the type of base map to use for devices that
  do not support JavaScript maps, see :ref:`section-base-map-types`.
* *STATIC_MAP_BASE_URL* (required if *STATIC_MAP_CLASS* is ArcGISStaticMap or
  WMSStaticMap) - the base URL where the static base map service is hosted.

.. _section-base-map-types::

=====================
Configuring Base Maps
=====================

Kurogo selects the base map following the configuration and these default 
rules:

If both JS_MAP_CLASS and STATIC_MAP_CLASS are left unspecified, Kurogo by 
default will select Google Static Maps for basic/touch devices and Google Maps
for compliant/tablet devices.  If both are specified, JS_MAP_CLASS will be used
for compliant/tablet and STATIC_MAP_CLASS for touch/basic.

If **only** STATIC_MAP_CLASS is specified, both compliant/tablet and 
basic/touch devices will use the base map specified by STATIC_MAP_CLASS.  If 
**only** JS_MAP_CLASS is specified, Google Static Maps will be chosen for 
basic/touch devices.

JavaScript base maps (compliant and tablet only)
-------------------------------------------------

Acceptable options for JS_MAP_CLASS are as follows.

Google Maps
^^^^^^^^^^^^^^

To use Google Maps, enter the configuration: ::

    JS_MAP_CLASS = "GoogleJSMap"


`Google Maps documentation <http://code.google.com/apis/maps/documentation/javascript/reference.html>`_


ArcGIS Tiled Service Maps
^^^^^^^^^^^^^^^^^^^^^^^^^

To use tiles from an ArcGIS tile server, enter the configuration: ::

    JS_MAP_CLASS = "ArcGISJSMap"
    DYNAMIC_MAP_BASE_URL = "http://..."

We may shortly be adding support for ArcGIS dynamic maps.

`ArcGIS JavaScript documentation <http://help.arcgis.com/en/webapi/javascript/arcgis/help/jsapi_start.htm>`_


Static image base maps
-----------------------

Acceptable options for STATIC_MAP_CLASS are as follows.


Google Static Maps
^^^^^^^^^^^^^^^^^^^

To use Google Static Maps, enter the configuration: ::

    STATIC_MAP_CLASS = "GoogleStaticMap"

Google Static Maps does not currently have support for polygon overlays.

`Google Static Maps documentation <http://code.google.com/apis/maps/documentation/staticmaps/>`_ 

Web Map Service (WMS)
^^^^^^^^^^^^^^^^^^^^^^

To use images from a WMS service, enter the configuration: ::

    STATIC_MAP_CLASS = "WMSStaticMap"
    STATIC_MAP_BASE_URL = "http://..."

Note that it is not possible to add overlays to WMS maps.

`WMS documentation <http://portal.opengeospatial.org/files/?artifact_id=14416>`_

ArcGIS exported images
^^^^^^^^^^^^^^^^^^^^^^^

To use exported images from an ArcGIS server, enter the configuration: ::

    STATIC_MAP_CLASS = "ArcGISStaticMap"
    STATIC_MAP_BASE_URL = "http://..."

Note that it is not possible to add overlays to an exported image.

`ArcGIS export API documentation <http://help.arcgis.com/en/arcgisserver/10.0/apis/rest/exportimage.html>`_



==========================
Configuring Map Data Feeds
==========================

Each data feed is represented as a *category* that a user may browse by from 
the home screen or within a campus.

The feed configuration file is in *SITE_DIR/config/map/feeds-GROUP.ini* (where 
GROUP is the id of the group from feedgroups.ini). Each feed has the following
fields:

* *TITLE* (required) - descriptive name of the category that shows up in the 
  list of categories
* *SUBTITLE* (optional) - brief description that appears in small text 
  alongside the title
* *BASE_URL* (required) - URL location of the data source.
* *CONTROLLER_CLASS* - data controller class associated with the type of
  data source.  It is recomended that you set to to *MapDBDataController*
* *PARSER_CLASS* (required) - data parser to use for the feed, see below for 
  options.
* *SEARCHABLE* - boolean value that indicates whether or not this data
  source should be included in internal search results.
* *DEFAULT_ZOOM_LEVEL* - default zoom level that the base map should use
  when displaying items from this feed.

KML/KMZ
--------

KML (.kml) and zipped KML (.kmz) are both supported by Kurogo.  To use KML, 
specify the following in feeds-<group>.ini: ::

    DATA_PARSER_CLASS = "KMLDataParser"

KML files can easily be created using `Google Earth <http://earth.google.com>`_.

* `KML documentation <http://code.google.com/apis/kml/documentation/kmlreference.html>`_ 

ArcGIS Server
---------------

To use ArcGIS Server, specify the following in feeds-<group>.ini: ::

    DATA_PARSER_CLASS = "ArcGISDataParser"

If the service has multiple layers, Kurogo only uses one layer at a time.  You
may specify different layers for different feeds by specifying

    ARCGIS_LAYER_ID = <number>

where <number> is the numeric ID of the layer.  Sublayers are not currently
supported.

* `ArcGIS Server documentation <http://resources.esri.com/help/9.3/arcgisserver/apis/rest/>`_

Shapefile 
-----------

To use shapefiles, specify the following in feeds-<group>.ini: ::

    DATA_PARSER_CLASS = "ShapefileDataParser"

Shapefiles located across the network must be in a zip folder containing no
directories (i.e. the contents are all .shp, .dbf, .shx, and .prj files).

Larger shapefiles may be unzipped and stored locally in a subdirectory of 
DATA_DIR.  In this case, the BASE_URL must be specified without the extension,
e.g. the shapefile consisting of DATA_DIR"/myshapefile.shp" and 
DATA_DIR"/myshapefile.dbf" must be specified as::

    BASE_URL = DATA_DIR"/myshapefile"

* `Shapefile documentation <http://en.wikipedia.org/wiki/Shapefile>`_


======================
Configuring Map Search
======================

Map search is configured in module.ini.  The map module has two types of 
search, externally-initiated (e.g. a link from the people module) and 
internally-initiated (using the map module search bar).  The search classes
used for these are specified in the configuration parameters 
MAP_EXTERNAL_SEARCH_CLASS and MAP_SEARCH_CLASS.

The search classes available are MapSearch, MapDBSearch, and GoogleMapSearch.
MapSearch simply dispatches the search function to every feed.  MapDBSearch
searches a database that replicates data in the feeds.  GoogleMapSearch
geocodes addresses.

The recommended setup is ::

    MAP_EXTERNAL_SEARCH_CLASS = "GoogleMapSearch"
    MAP_SEARCH_CLASS          = "MapDBSearch"

Note that at any time you use GoogleMapSearch, the base map displaying the 
search results must be a Google map (static or JavaScript).  Kurogo will 
automatically choose a Google map if the search is done externally.

