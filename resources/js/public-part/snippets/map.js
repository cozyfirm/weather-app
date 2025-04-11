/* Google maps */
import {Loader, LoaderOptions} from 'google-maps';
// or const {Loader} = require('google-maps'); without typescript


const hqLat = 43.8552164459567, hqLon = 18.38745423505708;
const options = {/* todo */};
const loader = new Loader('AIzaSyAApiBLPehhhJkDFqzlfNGN99n18N4PZxA', options);

// loader.load().then(function (google) {
//     let map = new google.maps.Map(document.getElementById('map__wrapper'), {
//         center: {lat: hqLat, lng: hqLon},
//         zoom: 6,
//         disableDefaultUI: true,
//         // fullscreenControl: false,
//         styles: [
//             {
//                 "featureType": "administrative",
//                 "elementType": "all",
//                 "stylers": [
//                     {
//                         "saturation": "-100"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "administrative.province",
//                 "elementType": "all",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "landscape",
//                 "elementType": "all",
//                 "stylers": [
//                     {
//                         "saturation": -100
//                     },
//                     {
//                         "lightness": 65
//                     },
//                     {
//                         "visibility": "on"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "poi",
//                 "elementType": "all",
//                 "stylers": [
//                     {
//                         "saturation": -100
//                     },
//                     {
//                         "lightness": "50"
//                     },
//                     {
//                         "visibility": "simplified"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "road",
//                 "elementType": "all",
//                 "stylers": [
//                     {
//                         "saturation": "-100"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "road.highway",
//                 "elementType": "all",
//                 "stylers": [
//                     {
//                         "visibility": "simplified"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "road.arterial",
//                 "elementType": "all",
//                 "stylers": [
//                     {
//                         "lightness": "30"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "road.local",
//                 "elementType": "all",
//                 "stylers": [
//                     {
//                         "lightness": "40"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "transit",
//                 "elementType": "all",
//                 "stylers": [
//                     {
//                         "saturation": -100
//                     },
//                     {
//                         "visibility": "simplified"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "water",
//                 "elementType": "geometry",
//                 "stylers": [
//                     {
//                         "hue": "#ffff00"
//                     },
//                     {
//                         "lightness": -25
//                     },
//                     {
//                         "saturation": -97
//                     }
//                 ]
//             },
//             {
//                 "featureType": "water",
//                 "elementType": "labels",
//                 "stylers": [
//                     {
//                         "lightness": -25
//                     },
//                     {
//                         "saturation": -100
//                     }
//                 ]
//             }
//         ]
//     });
//
//     let location = new google.maps.LatLng(hqLat, hqLon);
//     let marker = new google.maps.Marker({
//         position: location,
//         map: map,
//         // draggable: true
//     });
//
//     /* Get coordinates while moving */
//     google.maps.event.addListener(marker, 'dragend', function() {
//         let latLng = marker.getPosition();
//         let currentLatitude = latLng.lat();
//         let currentLongitude = latLng.lng();
//         console.log(currentLatitude);
//         console.log(currentLongitude);
//     });
// });
