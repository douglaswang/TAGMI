$(document).ready(function() {
});

function getMyStyle() {
    var myStyle = new OpenLayers.Style({
        strokeColor: '#000000',
        strokeWidth: 1
    });
    var colorSet = ['#87CEFA', '#1E90FF', '#0000CD'];
    for (var information = 1; information < 4; information++) {
        for (var success = 1; success < 4; success++) {
            var tempRule = new OpenLayers.Rule({
                filter: new OpenLayers.Filter.Comparison({
                    type: OpenLayers.Filter.Comparison.EQUAL_TO,
                    property: 'result',
                    value: information * 4 + success
                }),
                symbolizer: {
                    fillColor: colorSet[success - 1],
                    fillOpacity: 0.6,
                }
            });
            myStyle.addRules([tempRule]);
        }
    }

    var mySelectStyle = new OpenLayers.Style({
        fillOpacity: 0.3
    });
    var myStyleMap = new OpenLayers.StyleMap({
        default: myStyle,
        select: mySelectStyle
    });
    return myStyleMap;
}
