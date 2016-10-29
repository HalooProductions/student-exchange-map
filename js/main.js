var settings = {
  viewHeight: $(window).height(),
  highlighted: 'none'
};

var styles = [
  {
    featureType: "administrative.country",
    elementType: "labels",
    stylers: [
      {
        visibility: "off"
      }
    ]
  },
  {
    featureType: "administrative.province",
    elementType: "all",
    stylers: [
      {
        visibility: "off"
      }
    ]
  },
  { 
    featureType: "road", 
    stylers: [
      { 
        visibility: "off" 
      } 
    ] 
  }
];

var mapOptions = {
  center: {lat: 30, lng: 0},
  scrollwheel: true,
  zoom: 3,
  disableDefaultUI: true,
  styles: styles
};

var map;
var google;

function initMap () {
  // Create a map object and specify the DOM element for display.
  map = new google.maps.Map(document.getElementById('map'), mapOptions);
}

function focusCountry (index) {
  $.getJSON('data/countries.json', function (countries) {
    var myOptions = {
      center: new google.maps.LatLng(
        countries[index].center_lat,
        countries[index].center_lng),
      }

    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

    var bounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(countries[index].sw_lat, countries[index].sw_lng),
      new google.maps.LatLng(countries[index].ne_lat, countries[index].ne_lng)
    );

    map.fitBounds(bounds);
  });
}

function init () {
  map = $("#map");
  map.height(settings.viewHeight);
  initMap();
}

$(document).ready(function () {
  init();
  $('.ui.dropdown').dropdown();

  $('.ui.dropdown').on('change', function (evt) {
    if (!isNaN(evt.target.value)) {
      focusCountry(parseInt(evt.target.value));
    }
  });
});