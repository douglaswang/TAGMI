Proj4js.defs["EPSG:32630"] = "+proj=utm +zone=30 +ellps=WGS84 +datum=WGS84 +units=m +no_defs";

var dataNodeOptions = {
    '3': 'Positive - very strong',
    '2': 'Positive - strong',
    '1': 'Positive - weak',
    '-1': 'Negative - weak',
    '-2': 'Negative - strong',
    '-3': 'Negative - very strong'
};

var dataNodeOptionsFr = {
    '3': 'Positif - très fort',
    '2': 'Positif - fort',
    '1': 'Positif - faible',
    '-1': 'Négatif - faible',
    '-2': 'Négatif - fort',
    '-3': 'Négatif - très fort'
};

var factorNodeOptions = {
    '1': 'Essential',
    '0.75': 'Very important',
    '0.5': 'Important',
    '0.25': 'Somewhat important',
    '0.05': 'Not important'
};

var factorNodeOptionsFr = {
    '1': 'Essentiel',
    '0.75': 'Très important',
    '0.5': 'Importante',
    '0.25': 'Assez important',
    '0.05': 'Pas importante'
};

var capitalNodeOptions = {
    '4': 'Essential',
    '3': 'Important'
            //'2': 'Necessary',
            //'1': 'Somewhat necessary',
            //'0': 'Not necessary'
};

var capitalNodeOptionsFr = {
    '4': 'Essential',
    '3': 'Important'
            //'2': 'Nécessaire',
            //'1': 'Assez nécessaire',
            //'0': 'Pas nécessaire'
};

function init() {
    //tooltip
    $('#tooltip-strength-of-evidence').tooltip();

    $('#tooltip-technology').tooltip({
        content: function () {
            return $(this).prop('title');
        },
        open: function (event, ui) {
            ui.tooltip.css("max-width", "450px");
        }
    });

    $(document).mouseup(function (e) {
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
        ],
        fallThrough: true
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
//    var blank = new OpenLayers.Layer.OSM("Blank", "img/blank.png");
//    map.addLayer(blank);
    map.addLayer(googleTempLayer);

    map.setCenter(new OpenLayers.LonLat(-1.04152, 8.90827).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject()), 7);
    //block ui
    $(document).ajaxStart(function () {
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
    $('button#btn-run-calculation').click(function () {
        viewData();
    });
    /**
     * TODO: update
     */
    $('select#pId').change(function () {
        var pId = $(this).val();
        window.location.href = "tool.php?p_id=" + pId;
    });

    $('select#tId').change(function () {
        loadNodes();
        updateImage();
    });
    $('button#btn-reset').click(function () {
        loadNodes();
    });

    $('a#btn-table-result').click(function (e) {
        viewTableResult();
        e.preventDefault();
    });

    $('a#btn-download-result').click(function (e) {
        downloadResult();
        e.preventDefault();
    });

    loadNodes();
    updateImage();
    viewData();

}


function viewData() {
    //set resultCache to null
    resultCache = new Array();
    //close existing dialog
    $('div.featureInfo').dialog('close');
    //remove layer first (need edited)
    for (var key in layerList) {
        map.removeLayer(layerList[key]);
    }
    layerList = new Array();
    //set centre
    var pId = $('select#pId').val();
    // Construct the selector for this country
    map.setCenter(new OpenLayers.LonLat(mapCenterLon, mapCenterLat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject()), 7);

    var geoJsonReaderOptions = {
        'internalProjection': map.baseLayer.projection,
        'externalProjection': new OpenLayers.Projection('EPSG:4326')
    };
    var geoJsonReader = new OpenLayers.Format.GeoJSON(geoJsonReaderOptions);
    var qInst = $.qjax({
        timeout: 20000
    });
    //add basin layer
    var pId = $('select#pId').val();
    qInst.Queue({
        url: 'getBasinOutline.php',
        data: {'pId': pId},
        dataType: 'json',
        type: 'POST',
        success: function (data) {
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
    //country layer
    var req = qInst.Queue({
        url: 'getData.php',
        data: $('form#formControl,form#formModelModification').serialize(), //data to be sent to server
        dataType: 'json',
        type: 'POST',
        success: function (data) {
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
                var select = new OpenLayers.Control.SelectFeature(layer);
                //If stopDown is set to true, handled mousedowns do not propagate to
                //other mousedown listeners.  Otherwise, handled mousedowns do propagate.
                //Unhandled mousedowns always propagate, whatever the value of stopDown.
                //
                //If stopUp is set to true, handled mouseups do not propagate to other
                //mouseup listeners.  Otherwise, handled mouseups do propagate.
                //Unhandled mouseups always propagate, whatever the value of stopUp.
                select.handlers['feature'].stopDown = false;
                select.handlers['feature'].stopUp = false;
                var successString = ['Low', 'Medium', 'High'], successStringFr = ['Faible', 'Moyenne', 'Grande '];
                var infoString = ['Weak', 'Moderate', 'Strong'], infoStringFr = ['Weak', 'Moderate', 'Strong'];
                layer.events.on({
                    "featureselected": function onFeatureSelect(evt) {
                        var feature = evt.feature;
                        var result = parseInt(feature.attributes.result);
                        var success, information;
                        if (currentLanguage == 'en_EN') {
                            success = successString[(result & 3) - 1];
                            information = infoString[(result >>> 2) - 1];
                        } else {
                            success = successStringFr[(result & 3) - 1];
                            information = infoStringFr[(result >>> 2) - 1];
                        }
                        var content = '';
                        for (var name in data.display) {
                            if ($('div#div-field-to-dispaly input[value="' + data.display[name] + '"]').is(':checked')) {
                                var value = feature.attributes[data.display[name]];
                                if (!value) {
                                    value = (currentLanguage == 'en_EN' ? 'Not available' : 'Non disponible');
                                }
                                content += "<p>" + name + ": " + value + "</p>";
                            }
                        }
                        content += "<p><b>" + (currentLanguage == 'en_EN' ? 'Probability of success' : 'Probabilité de succès') + ": </b>" + success + "</p>";
                        //content += "<p>Strength of evidence: " + information + "</p>";
                        dialog = $("<div title='" + (currentLanguage == 'en_EN' ? 'Feature info ' : 'Informations sur les caractéristiques') + "' class='featureInfo'>" + content + "</div>").dialog({
                            'close': function () {
                                select.unselectAll();
                            },
                            'position': [mouseClickPosition.X, mouseClickPosition.Y],
                            'width': 'auto',
                            'closeText': "hide"
                        });
                    },
                    "featureunselected": function onFeatureUnselect(evt) {
                        dialog.dialog("destroy").remove();
                    }
                });
                map.addControl(select);
                select.activate();
                layerList.push(layer);

                //save resultCache
                //title
                var title = new Array();
                //title.push('id');
                for (var name in data.display) {
                    title.push(name);
                }
                title.push(currentLanguage == 'en_EN' ? 'Probability of success' : 'Probabilité de succès');
                title.push(currentLanguage == 'en_EN' ? 'Strength of evidence' : 'Strength of evidence');
                resultCache.push(title);
                //data
                for (var index in data.geojson.features) {
                    var properties = data.geojson.features[index].properties;
                    var nodeResult = new Array();
                    //nodeResult.push(properties.id)
                    for (var name in data.display) {
                        var value = properties[data.display[name]];
                        if (!value) {
                            value = (currentLanguage == 'en_EN' ? 'Not available' : 'Non disponible');
                        }
                        nodeResult.push(value);
                    }
                    var result = parseInt(properties.result);
                    var success, information;
                    if (currentLanguage == 'en_EN') {
                        success = successString[(result & 3) - 1];
                        information = infoString[(result >>> 2) - 1];
                    } else {
                        success = successStringFr[(result & 3) - 1];
                        information = infoStringFr[(result >>> 2) - 1];
                    }
                    //nodeResult.push(result);
                    nodeResult.push(success);
                    nodeResult.push(information);
                    resultCache.push(nodeResult);
                }
            } else {
                alert('ERROR: UNEXPECTED DATA.');
            }
        }
    });

}

function loadNodes() {
    var pId = $('select#pId').val();
    var tId = $('select#tId').val();
    $('table#tableModificationCapital').empty();
    $('table#tableModificationFactor').empty();
    $('table#tableModificationData').empty();

    $.get('getAvailableNodes.php', {
        'pId': pId,
        'tId': tId
    }, function (data) {
        for (var i in data) {
            var row = data[i];
            var tempContent = '';
            if (row['node'].substring(0, 2) == 'D_') {//data
                tempContent = getQuestionForDataNode(row['node'], row['description'], row['description_fr'], row['parent_description'], row['parent_description_fr']);
                $('table#tableModificationData').append(tempContent);
                $('select#modification-' + row['node']).val(row['default']);
            } else if (row['node'].substring(0, 2) == 'I_') {//indicator
                tempContent = getQuestionForFactorNode(row['node'], row['description'], row['description_fr'], row['parent_description'], row['parent_description_fr']);
                $('table#tableModificationFactor').append(tempContent);
                $('select#modification-' + row['node']).val(row['default']);
            } else if (row['node'].substring(0, 4) == 'PFC_') {//capital
                tempContent = getQuestionForCapitalNode(row['node'], row['description'], row['description_fr']);
                $('table#tableModificationCapital').append(tempContent);
                $('select#modification-' + row['node']).val(row['default']);
            }
        }
    }, 'json').fail(function () {
        alert("error");
    })
}

function getQuestionForDataNode(node, desc, descFr, parentDesc, parentDescFr) {
    var tempContent;
    if (currentLanguage == 'en_EN') {
        tempContent = '<tr>'
                + '<td>How positively (or negatively) will <b>' + parentDesc + '</b>'
                + ' change with (an) increasing <b>' + desc + '</b>?</td>'
                + '<td style="width:40%;">'
                + '<select name="modification[' + node + ']" id="modification-' + node + '" class="input-block-level">';
        for (var j in dataNodeOptions) {
            tempContent += '<option value="' + j + '">' + dataNodeOptions[j] + '</option>'
        }
        tempContent += '</select></<td></tr>';
    } else {
        tempContent = '<tr>'
                + '<td>Quel impact sur <b>' + parentDescFr + '</b>'
                + ' aura une augmentation <b>' + descFr + '</b>?</td>'
                + '<td style="width:40%;">'
                + '<select name="modification[' + node + ']" id="modification-' + node + '" class="input-block-level">';
        for (var j in dataNodeOptionsFr) {
            tempContent += '<option value="' + j + '">' + dataNodeOptionsFr[j] + '</option>'
        }
        tempContent += '</select></<td></tr>';
    }
    return tempContent;
}

function getQuestionForFactorNode(node, desc, descFr, parentDesc, parentDescFr) {
    var tempContent;
    if (currentLanguage == 'en_EN') {
        tempContent = '<tr>'
                + '<td>How important is a high level of <b>' + desc + '</b>'
                + ' to achieving high <b>' + parentDesc + '</b>?</td>'
                + '<td style="width:40%;">'
                + '<select name="modification[' + node + ']" id="modification-' + node + '" class="input-block-level">';
        for (var j in factorNodeOptions) {
            tempContent += '<option value="' + j + '">' + factorNodeOptions[j] + '</option>'
        }
        tempContent += '</select></<td></tr>';
    } else {
        tempContent = '<tr>'
                + '<td>Quelle est l’importance d’un niveau de <b>' + descFr + '</b>'
                + ' élévé pour atteindre <b>' + parentDescFr + '</b> élévé?</td>'
                + '<td style="width:40%;">'
                + '<select name="modification[' + node + ']" id="modification-' + node + '" class="input-block-level">';
        for (var j in factorNodeOptionsFr) {
            tempContent += '<option value="' + j + '">' + factorNodeOptionsFr[j] + '</option>'
        }
        tempContent += '</select></<td></tr>';
    }

    return tempContent;
}

function getQuestionForCapitalNode(node, desc, descFr) {
    var tempContent;
    if (currentLanguage == 'en_EN') {
        tempContent = '<tr>'
                + '<td>How necessary is <b>' + desc + '</b>'
                + ' for successful projects?</td>'
                + '<td style="width:40%;">'
                + '<select name="modification[' + node + ']" id="modification-' + node + '" class="input-block-level">';
        for (var j in capitalNodeOptions) {
            tempContent += '<option value="' + j + '">' + capitalNodeOptions[j] + '</option>'
        }
        tempContent += '</select></<td></tr>';
    } else {
        tempContent = '<tr>'
                + '<td>Dans quelle mesures <b>' + descFr + '</b>'
                + ' est-il nécessaire pour mener des projets à bien?</td>'
                + '<td style="width:40%;">'
                + '<select name="modification[' + node + ']" id="modification-' + node + '" class="input-block-level">';
        for (var j in capitalNodeOptionsFr) {
            tempContent += '<option value="' + j + '">' + capitalNodeOptionsFr[j] + '</option>'
        }
        tempContent += '</select></<td></tr>';
    }

    return tempContent;
}

function updateImage() {
    var fileName = $('#tId option:selected').data('network');
    var imageUrl = 'img/bayes_net_images/' + fileName;

    $('div#modification-image p a img').attr('src', imageUrl);
}

function viewTableResult() {
    if (resultCache.length > 0) {
        var dialog;

        var content = '<p><b>' + (currentLanguage == 'en_EN' ? 'Results' : 'Résultats') + ':</b></p>';
        content += '<table class="table table-bordered table-striped">'
        for (var rowIndex in resultCache) {
            content += '<tr>';
            if (rowIndex == 0) {
                for (var colIndex in resultCache[rowIndex]) {
                    content += '<th>' + resultCache[rowIndex][colIndex] + '</th>';
                }
            } else {
                for (var colIndex in resultCache[rowIndex]) {
                    content += '<td>' + resultCache[rowIndex][colIndex] + '</td>';
                }
            }
            content += '</tr>';
        }
        content += "</table>";

        dialog = $("<div title='" + (currentLanguage == 'en_EN' ? 'Results' : 'Résultats') + "' class='featureInfo'>" + content + "</div>").dialog({
            'close': function () {
                dialog.dialog("destroy").remove();
            },
            'width': 'auto',
            'height': $(window).height() * 0.8,
            'closeText': "Close"
        });
    } else {
        alert('ERROR: Result set is empty.');
    }
}

function downloadResult() {
    if (resultCache.length > 0) {
        $.post('generateCsv.php', {
            'result': resultCache
        }, function (data) {
            window.open('download.php?fileName=' + data['file'], '_blank');
        }, 'json');
    } else {
        alert('ERROR: Result set is empty.');
    }
}