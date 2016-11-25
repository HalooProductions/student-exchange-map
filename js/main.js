var headerHeight = $('.header-container').height();

var settings = {
  viewHeight: ($(window).height() / 3) * 2,
  highlighted: 'none'
};

var styles = [
  {
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#D1256E"
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#FFFFFF"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#000000"
      }
    ]
  },
  {
    "featureType": "administrative.country",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#eeeeee"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#eeeeee"
      }
    ]
  },
  {
    "featureType": "administrative.province",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#eeeeee"
      }
    ]
  },
  {
    "featureType": "landscape.man_made",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#ad1f5a"
      }
    ]
  },
  {
    "featureType": "landscape.natural",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#D1256E"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#ad1f5a"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#6f9ba5"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#000000"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#D1256E"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#3C7680"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#000000"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#000000"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#1d2c4d"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#2c6675"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#255763"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#b0d5ce"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#023e58"
      }
    ]
  },
  {
    "featureType": "transit",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#98a5be"
      }
    ]
  },
  {
    "featureType": "transit",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#1d2c4d"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#D1256E"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#ad1f5a"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#FFFFFF"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#FFFFFF"
      }
    ]
  },
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
  $('.controls').height(($(window).height() / 3) * 1 - headerHeight);
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
  var pdfviewer = $("#pdfviewer");
  pdfviewer.height($(window).height() - 5);
  pdfviewer.width($(window).width() - 5);
}

function findSchool(school) {
  var service = new google.maps.places.PlacesService(map);

  service.getDetails({
    placeId: school.place_id
  }, function(place, status) {
    if (status === google.maps.places.PlacesServiceStatus.OK) {
      var marker = new google.maps.Marker({
        map: map,
        position: place.geometry.location
      });

      var contentString =
      '<h3>' + school.name + '</h3>'+
      '<p>' + school.country + ', ' + school.city + '</p>'+
      '<button class="ui button">Stories</button>'
      ;

      var infowindow = new google.maps.InfoWindow({
          content: contentString
      });

      infowindow.open(map, marker);

      /*if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
        map.setZoom(5);
      } else {
        map.setCenter(place.geometry.location);
        map.setZoom(5);
      }*/

      google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' +
                  'Place ID: ' + place.place_id + '<br>' +
                  place.formatted_address + '</div>');
        infowindow.open(map, this);
      });
    }
  });

}

function getSchools() {
  console.log('asdfsdfasdf');
  $.ajax({
    method: "GET",
    url: "api/getschools.php"
  })
    .done(function(response) {
      console.log(response);
      var schools = JSON.parse(response);
      console.log(schools);
      setMarkers(schools);
    });
}

function setMarkers(schools) {
  for(var i = 0; i < schools.length; i++){
    findSchool(schools[i]);
  }
}

function loadPDF() {
  //
  // If absolute URL from the remote server is provided, configure the CORS
  // header on that server.
  //
  var url = './test.pdf';


  //
  // Disable workers to avoid yet another cross-origin issue (workers need
  // the URL of the script to be loaded, and dynamically loading a cross-origin
  // script does not work).
  //
  // PDFJS.disableWorker = true;

  //
  // In cases when the pdf.worker.js is located at the different folder than the
  // pdf.js's one, or the pdf.js is executed via eval(), the workerSrc property
  // shall be specified.
  //
  PDFJS.workerSrc = './js/pdf.worker.min.js';

  var pdfDoc = null,
      pageNum = 1,
      pageRendering = false,
      pageNumPending = null,
      scale = 0.8,
      canvas = document.getElementById('pdf-canvas'),
      ctx = canvas.getContext('2d');

  /**
   * Get page info from document, resize canvas accordingly, and render page.
   * @param num Page number.
   */
  function renderPage(num) {
    pageRendering = true;
    // Using promise to fetch the page
    pdfDoc.getPage(num).then(function(page) {
      var viewport = page.getViewport(scale);
      canvas.height = 800//viewport.height;
      canvas.width = 1000//viewport.width;

      // Render PDF page into canvas context
      var renderContext = {
        canvasContext: ctx,
        viewport: viewport
      };
      var renderTask = page.render(renderContext);

      // Wait for rendering to finish
      renderTask.promise.then(function () {
        pageRendering = false;
        if (pageNumPending !== null) {
          // New page rendering is pending
          renderPage(pageNumPending);
          pageNumPending = null;
        }
      });
    });

    // Update page counters
    document.getElementById('page_num').textContent = pageNum;
  }

  /**
   * If another page rendering in progress, waits until the rendering is
   * finised. Otherwise, executes rendering immediately.
   */
  function queueRenderPage(num) {
    if (pageRendering) {
      pageNumPending = num;
    } else {
      renderPage(num);
    }
  }

  /**
   * Displays previous page.
   */
  function onPrevPage() {
    if (pageNum <= 1) {
      return;
    }
    pageNum--;
    queueRenderPage(pageNum);
  }

  document.getElementById('prev').addEventListener('click', onPrevPage);

  /**
   * Displays next page.
   */
  function onNextPage() {
    if (pageNum >= pdfDoc.numPages) {
      return;
    }
    pageNum++;
    queueRenderPage(pageNum);
  }

  document.getElementById('next').addEventListener('click', onNextPage);

  /**
   * Asynchronously downloads PDF.
   */
  PDFJS.getDocument(url).then(function (pdfDoc_) {
    pdfDoc = pdfDoc_;
    document.getElementById('page_count').textContent = pdfDoc.numPages;

    // Initial/first page rendering
    renderPage(pageNum);
  });
}

$(document).ready(function () {
  init();
  $('.ui.dropdown').dropdown();

  $('.ui.dropdown').on('change', function (evt) {
    if (!isNaN(evt.target.value)) {
      focusCountry(parseInt(evt.target.value));
    }
  });

  getSchools();
});