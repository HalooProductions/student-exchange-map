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
  }
];

var map;

function initMap() {
  // Create a map object and specify the DOM element for display.
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 30, lng: 0},
    scrollwheel: false,
    zoom: 3,
    disableDefaultUI: true,
    styles: styles
  });
}

function highlightEurope () {
  if (settings.highlighted === 'eu') {
    settings.highlighted = 'none';

  } else {
    settings.highlighted = 'eu';
    var world_geometry = new google.maps.FusionTablesLayer({
      query: {
        select: 'geometry',
        from: '1N2LBk4JHwWpOY4d9fobIn27lfnZ5MDy-NoqqRpk',
        where: "ISO_2DIGIT IN ('BE', 'BG', 'CZ', 'DK', 'DE', 'EE', 'IE', 'EL', 'ES', 'FR', 'HR', 'IT', 'CY', 'LV', 'LT', 'LU', 'HU', 'MT', 'NL', 'AT', 'PL', 'PT', 'RO', 'SI', 'SK', 'FI', 'SE', 'GB', 'NO', 'CH', 'GR', 'AL', 'MK', 'RS', 'ME', 'BA', 'UA', 'RO', 'MD', 'BY', 'TR')"
      },
      map: map,
      suppressInfoWindows: true,
      styles: [
        {
          polygonOptions: {
            fillColor: '#0288D1'
          }
        }
      ]
    });
  }
}

function panToEurope () {
  var latLng = new google.maps.LatLng(55, 15);
  map.panTo(latLng);
  map.setZoom(4);
}

var map = $("#map");
map.height(settings.viewHeight);