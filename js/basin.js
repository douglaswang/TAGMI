Proj4js.defs["EPSG:32630"] = "+proj=utm +zone=30 +ellps=WGS84 +datum=WGS84 +units=m +no_defs";
function init() {
    //tooltip
    $('#tooltip-strength-of-evidence').tooltip();
    $('#tooltip-technology').tooltip({
        content: function() {
            return $(this).prop('title');
        }
    });

    $(document).mouseup(function(e) {
        mouseClickPosition.X = e.clientX + 5;
        mouseClickPosition.Y = e.clientY + 5;
    });
    map = new OpenLayers.Map('map-div', {
        displayProjection: new OpenLayers.Projection("EPSG:4326"),
        maxResolution: "auto",
        maxExtent: new OpenLayers.Bounds(-180, -90, 180, 90),
        minResolution: 0.0439453125,
        controls: [
            new OpenLayers.Control.Zoom(),
            new OpenLayers.Control.Navigation({zoomWheelEnabled: false})
        ]
    });
    //layerSwitcher = new OpenLayers.Control.LayerSwitcher();
    map.addControls([
        //layerSwitcher,
        new OpenLayers.Control.MousePosition({})
    ]);
    var googleTempLayer = new OpenLayers.Layer.Google(
            'Google Physical',
            {
                type: google.maps.MapTypeId.TERRAIN,
                numZoomLevels: 12
            });
    map.addLayer(googleTempLayer);

    map.setCenter(new OpenLayers.LonLat(mapCentreLonLat[0], mapCentreLonLat[1]).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject()), mapCentreZoom);
    //block ui
    $(document).ajaxStart(function() {
        var message;
        if (currentLanguage === 'en_EN') {
            message = '<h2>Loading data...Please wait...</h2>';
        } else {
            message = '<h2>Chargement en cours...</h2>';
        }
        $.blockUI({
            message: message
        });
    }).ajaxStop($.unblockUI);
    $('button#btn-run-calculation').click(function() {
        viewData();
    });
    viewData();
}


function viewData() {
    //close existing dialog
    $('div.featureInfo').dialog('close');
    //remove layer first (need edited)
    for (var key in layerList) {
        map.removeLayer(layerList[key]);
    }
    layerList = new Array();
    //set centre
    map.setCenter(new OpenLayers.LonLat(mapCentreLonLat[0], mapCentreLonLat[1]).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject()), mapCentreZoom);
    var geoJsonReaderOptions = {
        'internalProjection': map.baseLayer.projection,
        'externalProjection': new OpenLayers.Projection('EPSG:4326')
    };
    var geoJsonReader = new OpenLayers.Format.GeoJSON(geoJsonReaderOptions);
    var qInst = $.qjax({
        timeout: 20000
    });
    //add basin layer
    qInst.Queue({
        url: 'getBasinOutline.php',
        data: {'basin': basin},
        dataType: 'json',
        type: 'POST',
        success: function(data) {
            var dialog;
            if (data != null) {
                var layer = new OpenLayers.Layer.Vector("polygon", {
                    format: OpenLayers.Format.GeoJSON,
                    styleMap: new OpenLayers.StyleMap({
                        strokeColor: '#DC143C',
                        strokeWidth: 2,
                        fillColor: '#F0E68C',
                        fillOpacity: 0.2
                    }),
                });
                var features = geoJsonReader.read(data, 'FeatureCollection');
                layer.addFeatures(features);
                //add it to the map
                map.addLayer(layer);
                layerList.push(layer);
            } else {
                alert('ERROR: UNEXPECTED DATA.');
            }
        }
    });

    //loop here
    for (var key in countryList) {
        var country = countryList[key];
        //ajax queue

        //manually add country to the form data
        var postData = $('form#formControl').serializeArray();
        postData.push({
            name: 'iso2',
            value: country
        });

        var req = qInst.Queue({
            url: 'getData.php',
            data: postData,
            dataType: 'json',
            type: 'POST',
            success: function(data) {

                var dialog;
                if (data != null) {
                    var layer = new OpenLayers.Layer.Vector("polygon", {
                        format: OpenLayers.Format.GeoJSON,
                        styleMap: getMyStyle()
                    });
                    var features = geoJsonReader.read(data.geojson, 'FeatureCollection');
                    layer.addFeatures(features);
                    //add it to the map
                    map.addLayer(layer);
                    layerList.push(layer);
                } else {
                    alert('ERROR: UNEXPECTED DATA.');
                }
            }
        });
    }
}

