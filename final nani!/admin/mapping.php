<?php

session_start();

if(!isset($_SESSION['is_loggedin'])){

header('location: ../select user/index.html');
exit;
}

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="qgis2web/css/leaflet.css">
        <link rel="stylesheet" href="qgis2web/css/L.Control.Layers.Tree.css">
        <link rel="stylesheet" href="qgis2web/css/qgis2web.css">
        <link rel="stylesheet" href="qgis2web/css/fontawesome-all.min.css">
        <link rel="stylesheet" href="qgis2web/css/MarkerCluster.css">
        <link rel="stylesheet" href="qgis2web/css/MarkerCluster.Default.css">
           <style>
            html, body, #map {
                width: 100%;
                height: 100%;
                padding: 0;
                margin: 0;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 250px;
                background-color: #2c3e50;
                padding-top: 56px;
                transition: all 0.3s;
                z-index: 1000;
            }

            .sidebar-collapsed {
                width: 70px;
            }

            .sidebar .nav-link {
                color: #ecf0f1;
                padding: 10px 20px;
                transition: all 0.3s;
            }

            .sidebar .nav-link:hover,
            .sidebar .nav-link.active {
                background-color: #34495e;
            }

            .sidebar .nav-link i {
                margin-right: 10px;
            }

            .sidebar-collapsed .nav-link span {
                display: none;
            }

            .sidebar-collapsed .nav-link i {
                margin-right: 0;
            }

            .content {
                margin-left: 250px;
                padding-top: 56px;
                transition: all 0.3s;
            }

            .content-expanded {
                margin-left: 70px;
            }

            .header-content {
                position: absolute;
                top: 10px;
                left: 50%;
                transform: translateX(-50%);
                z-index: 1000;
                background-color: rgba(255, 255, 255, 0.9);
                padding: 10px 20px;
                border-radius: 5px;
                text-align: center;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            @media (max-width: 768px) {
                .sidebar {
                    width: 70px;
                }
                .sidebar .nav-link span {
                    display: none;
                }
                .sidebar .nav-link i {
                    margin-right: 0;
                }
                .content {
                    margin-left: 70px;
                }
                .header-content h2 {
                    font-size: 24px;
                }
                .header-content h5 {
                    font-size: 16px;
                }
            }

            /* Hide unwanted controls */
            .leaflet-control-zoom,
            .leaflet-control-geocoder,
            .leaflet-control-locate,
            .leaflet-control-measure {
                display: none !important;
            }
        </style>

        <title>Barangay Daragan Map</title>
            <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    </head>
    <body>
        <div id="map">
        </div>

          <?php include 'includes/sidebar.php'; ?>

            <div class="header-content">
            <h2 style="font-size: 40px; margin: 0;">BARANGAY DARAGAN/PINA</h2>
            <h5 style="font-size: 20px; margin: 5px 0 0 0;">Buenavista Guimaras Philippines</h5>
        </div>

        <div id="map" class="content">
    
        </div>
        <?php include 'includes/modal.php'?>
        <script src="qgis2web/js/qgis2web_expressions.js"></script>
        <script src="qgis2web/js/leaflet.js"></script>
        <script src="qgis2web/js/L.Control.Layers.Tree.min.js"></script>
        <script src="qgis2web/js/leaflet.rotatedMarker.js"></script>
        <script src="qgis2web/js/leaflet.pattern.js"></script>
        <script src="qgis2web/js/leaflet-hash.js"></script>
        <script src="qgis2web/js/Autolinker.min.js"></script>
        <script src="qgis2web/js/rbush.min.js"></script>
        <script src="qgis2web/js/labelgun.min.js"></script>
        <script src="qgis2web/js/labels.js"></script>
        <script src="qgis2web/js/leaflet.markercluster.js"></script>
        <script src="qgis2web/data/pinadaraganbarangays_1.js"></script>
        <script src="qgis2web/data/Purok1purok_2.js"></script>
        <script src="qgis2web/data/purok2purok_2_3.js"></script>
        <script src="qgis2web/data/purok3purok_3_4.js"></script>
        <script src="qgis2web/data/purok4purok_4_5.js"></script>
        <script src="qgis2web/data/purok5purok_5_6.js"></script>
        <script src="qgis2web/data/purok6purok_6_7.js"></script>
        <script src="qgis2web/data/pinapurok3_8.js"></script>
        <script src="qgis2web/data/pinapurok7_9.js"></script>
        <script src="qgis2web/data/pinapurok6_10.js"></script>
        <script src="qgis2web/data/pinapurok5_11.js"></script>
        <script src="qgis2web/data/pinapurok1_12.js"></script>
        <script src="qgis2web/data/purok7purok_7_13.js"></script>
        <script src="qgis2web/data/pinapurok4_14.js"></script>
        <script src="qgis2web/data/pinapurok2_15.js"></script>
        <script src="qgis2web/data/purok8purok_8_16.js"></script>
        <script src="qgis2web/data/purok9purok_9_17.js"></script>
        <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const sidebarToggle = document.getElementById('sidebarToggle');

            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.classList.toggle('sidebar-collapsed');
                content.classList.toggle('content-expanded');
            });
        });
    </script>

        <script>

       function fetchDataAndShowModal(barangay, purok, modalId) {
    console.log(`Fetching data for Purok: ${purok}, Modal ID: ${modalId}`);
    if (purok === "pag_asa") {
        purok = "pagasa";
    }

    const modal = document.getElementById(modalId);
    const healthStatus = modal.querySelector(`#healthStatus${capitalizeFirstLetter(purok)}`);
    const totalCount = modal.querySelector(`#totalCount${capitalizeFirstLetter(purok)}`);
    const dynamicConditions = modal.querySelector(`#dynamicConditions${capitalizeFirstLetter(purok)}`);
    const Assigned = modal.querySelector("#AssignedArea");
    
    // Show loading state
    if (healthStatus) healthStatus.textContent = "Loading...";
    if (totalCount) totalCount.textContent = "...";
    if (dynamicConditions) dynamicConditions.innerHTML = '<div class="col-12 text-center">Loading...</div>';

    fetch(`fetch_health_status.php?purok=${purok}&barangay=${barangay}`)
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Received data:', data);
            if (!data.success) {
                throw new Error(data.message || 'Unknown error occurred');
            }

            if (dynamicConditions) {
                dynamicConditions.innerHTML = ""; // Clear previous content
                data.counts.forEach(condition => {
                    const conditionDiv = document.createElement('div');
                    // conditionDiv.className = "col-md-4 mb-3";
                    console.log(condition);
                    conditionDiv.innerHTML = `
                  
                    <div class="row mb-4">
                     <div class="col">
                 <div class="card h-100">
              <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Health Status</h6>
                <p  class="card-text lead">${condition.ConditionName}</p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <div class="card-body text-center">
                <h6 class="card-subtitle mb-2 text-muted">Total Cases</h6>
                <p class="display-4 text-primary mb-0">${condition.count}</p>
              </div>
            </div>
          </div>
        </div>
                    `;
                    dynamicConditions.appendChild(conditionDiv);
                });
            } else {
                console.error(`Dynamic conditions container not found for ${purok}`);
            }

            //   console.log(data.fname);
            //   if (Assigned) {
            //     if (data.assignedUser && data.assignedUser.fname) {
            //         // If assigned user exists, display their name
            //         Assigned.textContent = `Assigned Area: ${data.assignedUser.fname}`;
            //     } else {
            //         // If no assigned user, display a message
            //         Assigned.textContent = "Assigned Area: No assigned users";
            //     }
            // }

            // Show the modal
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        })
        .catch(error => {
            console.error("Error fetching data:", error);
            if (healthStatus) healthStatus.textContent = "Error loading data";
            if (totalCount) totalCount.textContent = "N/A";
            if (dynamicConditions) {
                dynamicConditions.innerHTML = `
                    <div class="col-12 text-center text-danger">
                        An error occurred: ${error.message}
                    </div>
                `;
            }
            // Still show the modal to display the error
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        });
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}


        var highlightLayer;
        function highlightFeature(e) {
            highlightLayer = e.target;

            if (e.target.feature.geometry.type === 'LineString' || e.target.feature.geometry.type === 'MultiLineString') {
              highlightLayer.setStyle({
                color: '#ffff00',
              });
            } else {
              highlightLayer.setStyle({
                fillColor: '#ffff00',
                fillOpacity: 1
              });
            }
            highlightLayer.openPopup();
        }
        var map = L.map('map', {
            zoomControl:false, maxZoom:28, minZoom:1
        })
        var hash = new L.Hash(map);
        map.attributionControl.setPrefix('<a href="https://github.com/tomchadwin/qgis2web" target="_blank">qgis2web</a> &middot; <a href="https://leafletjs.com" title="A JS library for interactive maps">Leaflet</a> &middot; <a href="https://qgis.org">QGIS</a>');
        var autolinker = new Autolinker({truncate: {length: 30, location: 'smart'}});
        // remove popup's row if "visible-with-data"
        function removeEmptyRowsFromPopupContent(content, feature) {
         var tempDiv = document.createElement('div');
         tempDiv.innerHTML = content;
         var rows = tempDiv.querySelectorAll('tr');
         for (var i = 0; i < rows.length; i++) {
             var td = rows[i].querySelector('td.visible-with-data');
             var key = td ? td.id : '';
             if (td && td.classList.contains('visible-with-data') && feature.properties[key] == null) {
                 rows[i].parentNode.removeChild(rows[i]);
             }
         }
         return tempDiv.innerHTML;
        }
        // add class to format popup if it contains media
        function addClassToPopupIfMedia(content, popup) {
            var tempDiv = document.createElement('div');
            tempDiv.innerHTML = content;
            if (tempDiv.querySelector('td img')) {
                popup._contentNode.classList.add('media');
                    // Delay to force the redraw
                    setTimeout(function() {
                        popup.update();
                    }, 10);
            } else {
                popup._contentNode.classList.remove('media');
            }
        }
        var zoomControl = L.control.zoom({
            position: 'topleft'
        }).addTo(map);
        var bounds_group = new L.featureGroup([]);
        function setBounds() {
            if (bounds_group.getLayers().length) {
                map.fitBounds(bounds_group.getBounds());
            }
        }
        map.createPane('pane_GoogleSatellite_0');
        map.getPane('pane_GoogleSatellite_0').style.zIndex = 400;
        var layer_GoogleSatellite_0 = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            pane: 'pane_GoogleSatellite_0',
            opacity: 1.0,
            attribution: '<a href="https://www.google.at/permissions/geoguidelines/attr-guide.html">Map data ©2015 Google</a>',
            minZoom: 1,
            maxZoom: 28,
            minNativeZoom: 0,
            maxNativeZoom: 20
        });
        layer_GoogleSatellite_0;
        map.addLayer(layer_GoogleSatellite_0);
        function pop_pinadaraganbarangays_1(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,

            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">fid</th>\
                        <td class="visible-with-data" id="fid">' + (feature.properties['fid'] !== null ? autolinker.link(feature.properties['fid'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2"><strong>ID_0</strong><br />' + (feature.properties['ID_0'] !== null ? autolinker.link(feature.properties['ID_0'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">ISO</th>\
                        <td>' + (feature.properties['ISO'] !== null ? autolinker.link(feature.properties['ISO'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">NAME_0</th>\
                        <td>' + (feature.properties['NAME_0'] !== null ? autolinker.link(feature.properties['NAME_0'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">ID_1</th>\
                        <td>' + (feature.properties['ID_1'] !== null ? autolinker.link(feature.properties['ID_1'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">NAME_1</th>\
                        <td>' + (feature.properties['NAME_1'] !== null ? autolinker.link(feature.properties['NAME_1'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">ID_2</th>\
                        <td>' + (feature.properties['ID_2'] !== null ? autolinker.link(feature.properties['ID_2'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">NAME_2</th>\
                        <td>' + (feature.properties['NAME_2'] !== null ? autolinker.link(feature.properties['NAME_2'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">ID_3</th>\
                        <td>' + (feature.properties['ID_3'] !== null ? autolinker.link(feature.properties['ID_3'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">NAME_3</th>\
                        <td>' + (feature.properties['NAME_3'] !== null ? autolinker.link(feature.properties['NAME_3'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">NL_NAME_3</th>\
                        <td>' + (feature.properties['NL_NAME_3'] !== null ? autolinker.link(feature.properties['NL_NAME_3'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">VARNAME_3</th>\
                        <td>' + (feature.properties['VARNAME_3'] !== null ? autolinker.link(feature.properties['VARNAME_3'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">TYPE_3</th>\
                        <td>' + (feature.properties['TYPE_3'] !== null ? autolinker.link(feature.properties['TYPE_3'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">ENGTYPE_3</th>\
                        <td>' + (feature.properties['ENGTYPE_3'] !== null ? autolinker.link(feature.properties['ENGTYPE_3'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">PROVINCE</th>\
                        <td>' + (feature.properties['PROVINCE'] !== null ? autolinker.link(feature.properties['PROVINCE'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">REGION</th>\
                        <td>' + (feature.properties['REGION'] !== null ? autolinker.link(feature.properties['REGION'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_pinadaraganbarangays_1_0() {
            return {
                pane: 'pane_pinadaraganbarangays_1',
                opacity: 1,
                color: 'rgba(15,2,2,1.0)',
                dashArray: '',
                lineCap: 'square',
                lineJoin: 'bevel',
                weight: 4.0,
                fillOpacity: 0,
                interactive: true,
            }
        }
        map.createPane('pane_pinadaraganbarangays_1');
        map.getPane('pane_pinadaraganbarangays_1').style.zIndex = 401;
        map.getPane('pane_pinadaraganbarangays_1').style['mix-blend-mode'] = 'normal';
        var layer_pinadaraganbarangays_1 = new L.geoJson(json_pinadaraganbarangays_1, {
            attribution: '',
            interactive: true,
            dataVar: 'json_pinadaraganbarangays_1',
            layerName: 'layer_pinadaraganbarangays_1',
            pane: 'pane_pinadaraganbarangays_1',
            onEachFeature: pop_pinadaraganbarangays_1,
            style: style_pinadaraganbarangays_1_0,
        });
        bounds_group.addLayer(layer_pinadaraganbarangays_1);
        map.addLayer(layer_pinadaraganbarangays_1);
        function pop_Purok1purok_2(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
                 click: function(e) {
          
                fetchDataAndShowModal('daragan','pag_asa', 'purokPagasa');
              }
            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">fid</th>\
                        <td>' + (feature.properties['fid'] !== null ? autolinker.link(feature.properties['fid'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">purok 1</th>\
                        <td>' + (feature.properties['purok 1'] !== null ? autolinker.link(feature.properties['purok 1'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_Purok1purok_2_0() {
            return {
                pane: 'pane_Purok1purok_2',
                radius: 10.000000000000002,
                opacity: 1,
                color: 'rgba(128,17,25,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(219,30,42,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_Purok1purok_2');
        map.getPane('pane_Purok1purok_2').style.zIndex = 402;
        map.getPane('pane_Purok1purok_2').style['mix-blend-mode'] = 'normal';
        var layer_Purok1purok_2 = new L.geoJson(json_Purok1purok_2, {
            attribution: '',
            interactive: true,
            dataVar: 'json_Purok1purok_2',
            layerName: 'layer_Purok1purok_2',
            pane: 'pane_Purok1purok_2',
            onEachFeature: pop_Purok1purok_2,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_Purok1purok_2_0(feature));
            },
        });
        var cluster_Purok1purok_2 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_Purok1purok_2.addLayer(layer_Purok1purok_2);

        bounds_group.addLayer(layer_Purok1purok_2);
        cluster_Purok1purok_2.addTo(map);
        function pop_purok2purok_2_3(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
                 click: function(e) {
       
                fetchDataAndShowModal('daragan','makalilibang', 'purokMakalilibang');
              }
            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">fid</th>\
                        <td>' + (feature.properties['fid'] !== null ? autolinker.link(feature.properties['fid'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">purok 2</th>\
                        <td>' + (feature.properties['purok 2'] !== null ? autolinker.link(feature.properties['purok 2'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_purok2purok_2_3_0() {
            return {
                pane: 'pane_purok2purok_2_3',
                radius: 10.000000000000002,
                opacity: 1,
                color: 'rgba(128,17,25,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(219,30,42,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_purok2purok_2_3');
        map.getPane('pane_purok2purok_2_3').style.zIndex = 403;
        map.getPane('pane_purok2purok_2_3').style['mix-blend-mode'] = 'normal';
        var layer_purok2purok_2_3 = new L.geoJson(json_purok2purok_2_3, {
            attribution: '',
            interactive: true,
            dataVar: 'json_purok2purok_2_3',
            layerName: 'layer_purok2purok_2_3',
            pane: 'pane_purok2purok_2_3',
            onEachFeature: pop_purok2purok_2_3,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_purok2purok_2_3_0(feature));
            },
        });
        var cluster_purok2purok_2_3 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_purok2purok_2_3.addLayer(layer_purok2purok_2_3);

        bounds_group.addLayer(layer_purok2purok_2_3);
        cluster_purok2purok_2_3.addTo(map);
        function pop_purok3purok_3_4(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
                 click: function(e) {
          
                fetchDataAndShowModal('daragan','masagana', 'purokMasagana');
              }
            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">fid</th>\
                        <td>' + (feature.properties['fid'] !== null ? autolinker.link(feature.properties['fid'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Purok 3</th>\
                        <td>' + (feature.properties['Purok 3'] !== null ? autolinker.link(feature.properties['Purok 3'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_purok3purok_3_4_0() {
            return {
                pane: 'pane_purok3purok_3_4',
                radius: 10.000000000000002,
                opacity: 1,
                color: 'rgba(128,17,25,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(219,30,42,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_purok3purok_3_4');
        map.getPane('pane_purok3purok_3_4').style.zIndex = 404;
        map.getPane('pane_purok3purok_3_4').style['mix-blend-mode'] = 'normal';
        var layer_purok3purok_3_4 = new L.geoJson(json_purok3purok_3_4, {
            attribution: '',
            interactive: true,
            dataVar: 'json_purok3purok_3_4',
            layerName: 'layer_purok3purok_3_4',
            pane: 'pane_purok3purok_3_4',
            onEachFeature: pop_purok3purok_3_4,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_purok3purok_3_4_0(feature));
            },
        });
        var cluster_purok3purok_3_4 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_purok3purok_3_4.addLayer(layer_purok3purok_3_4);

        bounds_group.addLayer(layer_purok3purok_3_4);
        cluster_purok3purok_3_4.addTo(map);
        function pop_purok4purok_4_5(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
                  click: function(e) {
          
                fetchDataAndShowModal('daragan','mahinahon', 'purokMahinahon');
              }

            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">fid</th>\
                        <td>' + (feature.properties['fid'] !== null ? autolinker.link(feature.properties['fid'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Purok 4</th>\
                        <td>' + (feature.properties['Purok 4'] !== null ? autolinker.link(feature.properties['Purok 4'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_purok4purok_4_5_0() {
            return {
                pane: 'pane_purok4purok_4_5',
                radius: 10.000000000000002,
                opacity: 1,
                color: 'rgba(128,17,25,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(219,30,42,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_purok4purok_4_5');
        map.getPane('pane_purok4purok_4_5').style.zIndex = 405;
        map.getPane('pane_purok4purok_4_5').style['mix-blend-mode'] = 'normal';
        var layer_purok4purok_4_5 = new L.geoJson(json_purok4purok_4_5, {
            attribution: '',
            interactive: true,
            dataVar: 'json_purok4purok_4_5',
            layerName: 'layer_purok4purok_4_5',
            pane: 'pane_purok4purok_4_5',
            onEachFeature: pop_purok4purok_4_5,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_purok4purok_4_5_0(feature));
            },
        });
        var cluster_purok4purok_4_5 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_purok4purok_4_5.addLayer(layer_purok4purok_4_5);

        bounds_group.addLayer(layer_purok4purok_4_5);
        cluster_purok4purok_4_5.addTo(map);
        function pop_purok5purok_5_6(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
                  click: function(e) {
          
                fetchDataAndShowModal('daragan', 'maligaya', 'purokMaligaya');
              }
            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">fid</th>\
                        <td>' + (feature.properties['fid'] !== null ? autolinker.link(feature.properties['fid'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Purok 5</th>\
                        <td>' + (feature.properties['Purok 5'] !== null ? autolinker.link(feature.properties['Purok 5'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_purok5purok_5_6_0() {
            return {
                pane: 'pane_purok5purok_5_6',
                radius: 10.000000000000002,
                opacity: 1,
                color: 'rgba(128,17,25,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(219,30,42,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_purok5purok_5_6');
        map.getPane('pane_purok5purok_5_6').style.zIndex = 406;
        map.getPane('pane_purok5purok_5_6').style['mix-blend-mode'] = 'normal';
        var layer_purok5purok_5_6 = new L.geoJson(json_purok5purok_5_6, {
            attribution: '',
            interactive: true,
            dataVar: 'json_purok5purok_5_6',
            layerName: 'layer_purok5purok_5_6',
            pane: 'pane_purok5purok_5_6',
            onEachFeature: pop_purok5purok_5_6,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_purok5purok_5_6_0(feature));
            },
        });
        var cluster_purok5purok_5_6 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_purok5purok_5_6.addLayer(layer_purok5purok_5_6);

        bounds_group.addLayer(layer_purok5purok_5_6);
        cluster_purok5purok_5_6.addTo(map);
        function pop_purok6purok_6_7(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
                  click: function(e) {
          
                fetchDataAndShowModal('daragan','matibay', 'purokMatibay');
              }
            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">fid</th>\
                        <td>' + (feature.properties['fid'] !== null ? autolinker.link(feature.properties['fid'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Purok 6</th>\
                        <td>' + (feature.properties['Purok 6'] !== null ? autolinker.link(feature.properties['Purok 6'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_purok6purok_6_7_0() {
            return {
                pane: 'pane_purok6purok_6_7',
                radius: 10.000000000000002,
                opacity: 1,
                color: 'rgba(128,17,25,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(219,30,42,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_purok6purok_6_7');
        map.getPane('pane_purok6purok_6_7').style.zIndex = 407;
        map.getPane('pane_purok6purok_6_7').style['mix-blend-mode'] = 'normal';
        var layer_purok6purok_6_7 = new L.geoJson(json_purok6purok_6_7, {
            attribution: '',
            interactive: true,
            dataVar: 'json_purok6purok_6_7',
            layerName: 'layer_purok6purok_6_7',
            pane: 'pane_purok6purok_6_7',
            onEachFeature: pop_purok6purok_6_7,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_purok6purok_6_7_0(feature));
            },
        });
        var cluster_purok6purok_6_7 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_purok6purok_6_7.addLayer(layer_purok6purok_6_7);

        bounds_group.addLayer(layer_purok6purok_6_7);
        cluster_purok6purok_6_7.addTo(map);
        function pop_pinapurok3_8(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
                  click: function(e) {
          
                fetchDataAndShowModal('piña','purok3', 'piñaPurok3');
              }
            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">purok</th>\
                        <td>' + (feature.properties['purok'] !== null ? autolinker.link(feature.properties['purok'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_pinapurok3_8_0() {
            return {
                pane: 'pane_pinapurok3_8',
                radius: 10.000000000000002,
                opacity: 1,
                color: 'rgba(128,17,25,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(219,30,42,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_pinapurok3_8');
        map.getPane('pane_pinapurok3_8').style.zIndex = 408;
        map.getPane('pane_pinapurok3_8').style['mix-blend-mode'] = 'normal';
        var layer_pinapurok3_8 = new L.geoJson(json_pinapurok3_8, {
            attribution: '',
            interactive: true,
            dataVar: 'json_pinapurok3_8',
            layerName: 'layer_pinapurok3_8',
            pane: 'pane_pinapurok3_8',
            onEachFeature: pop_pinapurok3_8,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_pinapurok3_8_0(feature));
            },
        });
        var cluster_pinapurok3_8 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_pinapurok3_8.addLayer(layer_pinapurok3_8);

        bounds_group.addLayer(layer_pinapurok3_8);
        cluster_pinapurok3_8.addTo(map);
        function pop_pinapurok7_9(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
                click: function(e) {
          
                fetchDataAndShowModal('piña','purok7', 'piñaPurok7');
              }
            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">purok</th>\
                        <td>' + (feature.properties['purok'] !== null ? autolinker.link(feature.properties['purok'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_pinapurok7_9_0() {
            return {
                pane: 'pane_pinapurok7_9',
                radius: 10.000000000000002,
                opacity: 1,
                color: 'rgba(128,17,25,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(219,30,42,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_pinapurok7_9');
        map.getPane('pane_pinapurok7_9').style.zIndex = 409;
        map.getPane('pane_pinapurok7_9').style['mix-blend-mode'] = 'normal';
        var layer_pinapurok7_9 = new L.geoJson(json_pinapurok7_9, {
            attribution: '',
            interactive: true,
            dataVar: 'json_pinapurok7_9',
            layerName: 'layer_pinapurok7_9',
            pane: 'pane_pinapurok7_9',
            onEachFeature: pop_pinapurok7_9,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_pinapurok7_9_0(feature));
            },
        });
        var cluster_pinapurok7_9 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_pinapurok7_9.addLayer(layer_pinapurok7_9);

        bounds_group.addLayer(layer_pinapurok7_9);
        cluster_pinapurok7_9.addTo(map);
        function pop_pinapurok6_10(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
                    click: function(e) {
          
                fetchDataAndShowModal('piña','purok6', 'piñaPurok6');
              }
              
              
            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">purok</th>\
                        <td>' + (feature.properties['purok'] !== null ? autolinker.link(feature.properties['purok'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_pinapurok6_10_0() {
            return {
                pane: 'pane_pinapurok6_10',
                radius: 10.000000000000002,
                opacity: 1,
                color: 'rgba(128,17,25,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(219,30,42,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_pinapurok6_10');
        map.getPane('pane_pinapurok6_10').style.zIndex = 410;
        map.getPane('pane_pinapurok6_10').style['mix-blend-mode'] = 'normal';
        var layer_pinapurok6_10 = new L.geoJson(json_pinapurok6_10, {
            attribution: '',
            interactive: true,
            dataVar: 'json_pinapurok6_10',
            layerName: 'layer_pinapurok6_10',
            pane: 'pane_pinapurok6_10',
            onEachFeature: pop_pinapurok6_10,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_pinapurok6_10_0(feature));
            },
        });
        var cluster_pinapurok6_10 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_pinapurok6_10.addLayer(layer_pinapurok6_10);

        bounds_group.addLayer(layer_pinapurok6_10);
        cluster_pinapurok6_10.addTo(map);
        function pop_pinapurok5_11(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,

                    click: function(e) {
          
                fetchDataAndShowModal('piña','purok5', 'piñaPurok5');
              }
            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">purok</th>\
                        <td>' + (feature.properties['purok'] !== null ? autolinker.link(feature.properties['purok'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_pinapurok5_11_0() {
            return {
                pane: 'pane_pinapurok5_11',
                radius: 10.000000000000002,
                opacity: 1,
                color: 'rgba(128,17,25,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(219,30,42,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_pinapurok5_11');
        map.getPane('pane_pinapurok5_11').style.zIndex = 411;
        map.getPane('pane_pinapurok5_11').style['mix-blend-mode'] = 'normal';
        var layer_pinapurok5_11 = new L.geoJson(json_pinapurok5_11, {
            attribution: '',
            interactive: true,
            dataVar: 'json_pinapurok5_11',
            layerName: 'layer_pinapurok5_11',
            pane: 'pane_pinapurok5_11',
            onEachFeature: pop_pinapurok5_11,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_pinapurok5_11_0(feature));
            },
        });
        var cluster_pinapurok5_11 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_pinapurok5_11.addLayer(layer_pinapurok5_11);

        bounds_group.addLayer(layer_pinapurok5_11);
        cluster_pinapurok5_11.addTo(map);
        function pop_pinapurok1_12(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
                     click: function(e) {
          
                fetchDataAndShowModal('piña','purok1', 'piñaPurok1');
              }
            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">purok </th>\
                        <td>' + (feature.properties['purok '] !== null ? autolinker.link(feature.properties['purok '].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_pinapurok1_12_0() {
            return {
                pane: 'pane_pinapurok1_12',
                radius: 10.000000000000002,
                opacity: 1,
                color: 'rgba(128,17,25,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(219,30,42,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_pinapurok1_12');
        map.getPane('pane_pinapurok1_12').style.zIndex = 412;
        map.getPane('pane_pinapurok1_12').style['mix-blend-mode'] = 'normal';
        var layer_pinapurok1_12 = new L.geoJson(json_pinapurok1_12, {
            attribution: '',
            interactive: true,
            dataVar: 'json_pinapurok1_12',
            layerName: 'layer_pinapurok1_12',
            pane: 'pane_pinapurok1_12',
            onEachFeature: pop_pinapurok1_12,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_pinapurok1_12_0(feature));
            },
        });
        var cluster_pinapurok1_12 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_pinapurok1_12.addLayer(layer_pinapurok1_12);

        bounds_group.addLayer(layer_pinapurok1_12);
        cluster_pinapurok1_12.addTo(map);
        function pop_purok7purok_7_13(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
                    click: function(e) {
          
                fetchDataAndShowModal('daragan','matulungin', 'purokMatulungin');
              }
            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">fid</th>\
                        <td>' + (feature.properties['fid'] !== null ? autolinker.link(feature.properties['fid'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Purok 7</th>\
                        <td>' + (feature.properties['Purok 7'] !== null ? autolinker.link(feature.properties['Purok 7'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_purok7purok_7_13_0() {
            return {
                pane: 'pane_purok7purok_7_13',
                radius: 10.0,
                opacity: 1,
                color: 'rgba(128,17,25,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(219,30,42,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_purok7purok_7_13');
        map.getPane('pane_purok7purok_7_13').style.zIndex = 413;
        map.getPane('pane_purok7purok_7_13').style['mix-blend-mode'] = 'normal';
        var layer_purok7purok_7_13 = new L.geoJson(json_purok7purok_7_13, {
            attribution: '',
            interactive: true,
            dataVar: 'json_purok7purok_7_13',
            layerName: 'layer_purok7purok_7_13',
            pane: 'pane_purok7purok_7_13',
            onEachFeature: pop_purok7purok_7_13,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_purok7purok_7_13_0(feature));
            },
        });
        var cluster_purok7purok_7_13 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_purok7purok_7_13.addLayer(layer_purok7purok_7_13);

        bounds_group.addLayer(layer_purok7purok_7_13);
        cluster_purok7purok_7_13.addTo(map);
        function pop_pinapurok4_14(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
                    click: function(e) {
          
                fetchDataAndShowModal('piña','purok4', 'piñaPurok4');
              }
            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">purok</th>\
                        <td>' + (feature.properties['purok'] !== null ? autolinker.link(feature.properties['purok'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_pinapurok4_14_0() {
            return {
                pane: 'pane_pinapurok4_14',
                radius: 10.000000000000002,
                opacity: 1,
                color: 'rgba(128,17,25,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(219,30,42,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_pinapurok4_14');
        map.getPane('pane_pinapurok4_14').style.zIndex = 414;
        map.getPane('pane_pinapurok4_14').style['mix-blend-mode'] = 'normal';
        var layer_pinapurok4_14 = new L.geoJson(json_pinapurok4_14, {
            attribution: '',
            interactive: true,
            dataVar: 'json_pinapurok4_14',
            layerName: 'layer_pinapurok4_14',
            pane: 'pane_pinapurok4_14',
            onEachFeature: pop_pinapurok4_14,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_pinapurok4_14_0(feature));
            },
        });
        var cluster_pinapurok4_14 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_pinapurok4_14.addLayer(layer_pinapurok4_14);

        bounds_group.addLayer(layer_pinapurok4_14);
        cluster_pinapurok4_14.addTo(map);
        function pop_pinapurok2_15(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
                    click: function(e) {
          
                fetchDataAndShowModal('piña','purok2', 'piñaPurok2');
              }
            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">purok</th>\
                        <td>' + (feature.properties['purok'] !== null ? autolinker.link(feature.properties['purok'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_pinapurok2_15_0() {
            return {
                pane: 'pane_pinapurok2_15',
                radius: 10.000000000000002,
                opacity: 1,
                color: 'rgba(128,17,25,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(219,30,42,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_pinapurok2_15');
        map.getPane('pane_pinapurok2_15').style.zIndex = 415;
        map.getPane('pane_pinapurok2_15').style['mix-blend-mode'] = 'normal';
        var layer_pinapurok2_15 = new L.geoJson(json_pinapurok2_15, {
            attribution: '',
            interactive: true,
            dataVar: 'json_pinapurok2_15',
            layerName: 'layer_pinapurok2_15',
            pane: 'pane_pinapurok2_15',
            onEachFeature: pop_pinapurok2_15,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_pinapurok2_15_0(feature));
            },
        });
        var cluster_pinapurok2_15 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_pinapurok2_15.addLayer(layer_pinapurok2_15);

        bounds_group.addLayer(layer_pinapurok2_15);
        cluster_pinapurok2_15.addTo(map);
        function pop_purok8purok_8_16(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
                  click: function(e) {
          
                fetchDataAndShowModal('daragan','mabuhay', 'purokMabuhay');
              }
            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">fid</th>\
                        <td>' + (feature.properties['fid'] !== null ? autolinker.link(feature.properties['fid'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Purok 8</th>\
                        <td>' + (feature.properties['Purok 8'] !== null ? autolinker.link(feature.properties['Purok 8'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_purok8purok_8_16_0() {
            return {
                pane: 'pane_purok8purok_8_16',
                radius: 10.000000000000002,
                opacity: 1,
                color: 'rgba(128,17,25,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(219,30,42,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_purok8purok_8_16');
        map.getPane('pane_purok8purok_8_16').style.zIndex = 416;
        map.getPane('pane_purok8purok_8_16').style['mix-blend-mode'] = 'normal';
        var layer_purok8purok_8_16 = new L.geoJson(json_purok8purok_8_16, {
            attribution: '',
            interactive: true,
            dataVar: 'json_purok8purok_8_16',
            layerName: 'layer_purok8purok_8_16',
            pane: 'pane_purok8purok_8_16',
            onEachFeature: pop_purok8purok_8_16,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_purok8purok_8_16_0(feature));
            },
        });
        var cluster_purok8purok_8_16 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_purok8purok_8_16.addLayer(layer_purok8purok_8_16);

        bounds_group.addLayer(layer_purok8purok_8_16);
        cluster_purok8purok_8_16.addTo(map);
        function pop_purok9purok_9_17(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (var i in e.target._eventParents) {
                        if (typeof e.target._eventParents[i].resetStyle === 'function') {
                            e.target._eventParents[i].resetStyle(e.target);
                        }
                    }
                    if (typeof layer.closePopup == 'function') {
                        layer.closePopup();
                    } else {
                        layer.eachLayer(function(feature){
                            feature.closePopup()
                        });
                    }
                },
                mouseover: highlightFeature,
                    mouseover: highlightFeature,

                click: function(e) {
          
                fetchDataAndShowModal('daragan','mabuhay', 'purokMaunlad');
              }
            });
            var popupContent = '<table>\
                    <tr>\
                        <th scope="row">fid</th>\
                        <td>' + (feature.properties['fid'] !== null ? autolinker.link(feature.properties['fid'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Purok 9</th>\
                        <td>' + (feature.properties['Purok 9'] !== null ? autolinker.link(feature.properties['Purok 9'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            var content = removeEmptyRowsFromPopupContent(popupContent, feature);
            layer.on('popupopen', function(e) {
                addClassToPopupIfMedia(content, e.popup);
            });
            layer.bindPopup(content, { maxHeight: 400 });
        }

        function style_purok9purok_9_17_0() {
            return {
                pane: 'pane_purok9purok_9_17',
                radius: 10.000000000000002,
                opacity: 1,
                color: 'rgba(128,17,25,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(219,30,42,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_purok9purok_9_17');
        map.getPane('pane_purok9purok_9_17').style.zIndex = 417;
        map.getPane('pane_purok9purok_9_17').style['mix-blend-mode'] = 'normal';
        var layer_purok9purok_9_17 = new L.geoJson(json_purok9purok_9_17, {
            attribution: '',
            interactive: true,
            dataVar: 'json_purok9purok_9_17',
            layerName: 'layer_purok9purok_9_17',
            pane: 'pane_purok9purok_9_17',
            onEachFeature: pop_purok9purok_9_17,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_purok9purok_9_17_0(feature));
            },
        });
        var cluster_purok9purok_9_17 = new L.MarkerClusterGroup({showCoverageOnHover: false,
            spiderfyDistanceMultiplier: 2});
        cluster_purok9purok_9_17.addLayer(layer_purok9purok_9_17);

        bounds_group.addLayer(layer_purok9purok_9_17);
        cluster_purok9purok_9_17.addTo(map);
        setBounds();
        var i = 0;
        layer_pinapurok3_8.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['purok'] !== null?String('<div style="color: #323232; font-size: 10pt; font-family: \'Open Sans\', sans-serif;">' + layer.feature.properties['purok']) + '</div>':''), {permanent: true, offset: [-0, -16], className: 'css_pinapurok3_8'});
            labels.push(layer);
            totalMarkers += 1;
              layer.added = true;
              addLabel(layer, i);
              i++;
        });
        resetLabels([layer_pinapurok3_8]);
        map.on("zoomend", function(){
            resetLabels([layer_pinapurok3_8]);
        });
        map.on("layeradd", function(){
            resetLabels([layer_pinapurok3_8]);
        });
        map.on("layerremove", function(){
            resetLabels([layer_pinapurok3_8]);
        });
        </script>
    </body>
</html>
