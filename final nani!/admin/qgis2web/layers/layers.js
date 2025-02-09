var wms_layers = [];


        var lyr_GoogleSatellite_0 = new ol.layer.Tile({
            'title': 'Google Satellite',
            'opacity': 1.000000,
            
            
            source: new ol.source.XYZ({
            attributions: ' &middot; <a href="https://www.google.at/permissions/geoguidelines/attr-guide.html">Map data ©2015 Google</a>',
                url: 'https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}'
            })
        });
var format_daraganbarangays_1 = new ol.format.GeoJSON();
var features_daraganbarangays_1 = format_daraganbarangays_1.readFeatures(json_daraganbarangays_1, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:3857'});
var jsonSource_daraganbarangays_1 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_daraganbarangays_1.addFeatures(features_daraganbarangays_1);
var lyr_daraganbarangays_1 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_daraganbarangays_1, 
                style: style_daraganbarangays_1,
                popuplayertitle: 'daragan — barangays',
                interactive: true,
                title: '<img src="styles/legend/daraganbarangays_1.png" /> daragan — barangays'
            });
var format_purokpointspoint_2 = new ol.format.GeoJSON();
var features_purokpointspoint_2 = format_purokpointspoint_2.readFeatures(json_purokpointspoint_2, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:3857'});
var jsonSource_purokpointspoint_2 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_purokpointspoint_2.addFeatures(features_purokpointspoint_2);
cluster_purokpointspoint_2 = new ol.source.Cluster({
  distance: 30,
  source: jsonSource_purokpointspoint_2
});
var lyr_purokpointspoint_2 = new ol.layer.Vector({
                declutter: false,
                source:cluster_purokpointspoint_2, 
                style: style_purokpointspoint_2,
                popuplayertitle: 'purok points — point',
                interactive: true,
                title: '<img src="styles/legend/purokpointspoint_2.png" /> purok points — point'
            });

lyr_GoogleSatellite_0.setVisible(true);lyr_daraganbarangays_1.setVisible(true);lyr_purokpointspoint_2.setVisible(true);
var layersList = [lyr_GoogleSatellite_0,lyr_daraganbarangays_1,lyr_purokpointspoint_2];
lyr_daraganbarangays_1.set('fieldAliases', {'fid': 'fid', 'ID_0': 'ID_0', 'ISO': 'ISO', 'NAME_0': 'NAME_0', 'ID_1': 'ID_1', 'NAME_1': 'NAME_1', 'ID_2': 'ID_2', 'NAME_2': 'NAME_2', 'ID_3': 'ID_3', 'NAME_3': 'NAME_3', 'NL_NAME_3': 'NL_NAME_3', 'VARNAME_3': 'VARNAME_3', 'TYPE_3': 'TYPE_3', 'ENGTYPE_3': 'ENGTYPE_3', 'PROVINCE': 'PROVINCE', 'REGION': 'REGION', });
lyr_purokpointspoint_2.set('fieldAliases', {'fid': 'fid', });
lyr_daraganbarangays_1.set('fieldImages', {'fid': 'TextEdit', 'ID_0': 'Range', 'ISO': 'TextEdit', 'NAME_0': 'TextEdit', 'ID_1': 'Range', 'NAME_1': 'TextEdit', 'ID_2': 'Range', 'NAME_2': 'TextEdit', 'ID_3': 'Range', 'NAME_3': 'TextEdit', 'NL_NAME_3': 'TextEdit', 'VARNAME_3': 'TextEdit', 'TYPE_3': 'TextEdit', 'ENGTYPE_3': 'TextEdit', 'PROVINCE': 'TextEdit', 'REGION': 'TextEdit', });
lyr_purokpointspoint_2.set('fieldImages', {'fid': 'TextEdit', });
lyr_daraganbarangays_1.set('fieldLabels', {'fid': 'inline label - always visible', 'ID_0': 'inline label - always visible', 'ISO': 'inline label - always visible', 'NAME_0': 'inline label - always visible', 'ID_1': 'inline label - always visible', 'NAME_1': 'inline label - always visible', 'ID_2': 'inline label - always visible', 'NAME_2': 'inline label - always visible', 'ID_3': 'inline label - always visible', 'NAME_3': 'inline label - always visible', 'NL_NAME_3': 'inline label - always visible', 'VARNAME_3': 'inline label - always visible', 'TYPE_3': 'inline label - always visible', 'ENGTYPE_3': 'inline label - always visible', 'PROVINCE': 'inline label - always visible', 'REGION': 'inline label - always visible', });
lyr_purokpointspoint_2.set('fieldLabels', {'fid': 'inline label - always visible', });
lyr_purokpointspoint_2.on('precompose', function(evt) {
    evt.context.globalCompositeOperation = 'normal';
});