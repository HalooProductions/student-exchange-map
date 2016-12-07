var headerHeight = $('.header-container').height();
var onNextPage;
var onPrevPage;
var pdfScrollChecker;
var lastScroll = Date.now();
var pdfControlsTimeoutFunc;

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

  var e = document.getElementById("schoolmenu");
  var pl_id = e.value;
  console.log(e.value);
  if(pl_id != '') {
    focusSchool(pl_id, map);
  }
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


function focusSchool(index, map) {
var geocoder = new google.maps.Geocoder;
geocoder.geocode({'placeId': index}, function(results, status) {
  if (status === 'OK') {
    if (results[0]) {
      map.setZoom(11);
      map.setCenter(results[0].geometry.location);
    } else {
      window.alert('No results found');
    }
  } else {
    window.alert('Geocoder failed due to: ' + status);
  }
});
}

function init () {
  map = $("#map");
  map.height(settings.viewHeight);
  initMap();
  var pdfviewer = $("#pdfviewer");
  //pdfviewer.height($(window).height() - 10);
  pdfviewer.width($(window).width() - 10);
  $('#pdf-close').click(function () {
    unloadPDF();
  });

  pdfScrollChecker = function () {
    clearTimeout(pdfControlsTimeoutFunc);
    $('#pdfcontrols').css('opacity', 100);
    pdfControlsTimeoutFunc = setTimeout(function () {
      $('#pdfcontrols').css('opacity', 0);
    }, 3000);
  }

  $('#pdfcontrols').hover(function () {
    $('#pdfcontrols').css('opacity', 100);
  }, function () {
    pdfControlsTimeoutFunc = setTimeout(function () {
      $('#pdfcontrols').css('opacity', 0);
    }, 3000);
  });
}

function findSchool(school) {
  var service = new google.maps.places.PlacesService(map);
  service.getDetails({
    placeId: school.place_id
  }, function(place, status) {
    if (status === google.maps.places.PlacesServiceStatus.OK) {
      var marker = new google.maps.Marker({
        icon: document.baseURI.substring(0, document.baseURI.lastIndexOf('/') + 1) + "img/marker.png",
        map: map,
        position: place.geometry.location
      });



      /*if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
        map.setZoom(5);
      } else {
        map.setCenter(place.geometry.location);
        map.setZoom(5);
      }*/

      google.maps.event.addListener(marker, 'click', function() {
        var contentString =
        '<h3>' + school.name + '</h3>'+
        '<p>' + school.country + ', ' + school.city + '</p>'+
        '<button id="stories-btn" class="ui button">Stories</button>'
        ;

        google.maps.event.addListener(marker, 'click', function() {
          infowindow.close(map, marker);
        });

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        infowindow.open(map, marker);

        setTimeout(function() {
          $('#stories-btn').click(function() {
            modal();
          });
        }, 500);
      });
    }
  });

}

function modal () {
  $('.ui.modal').modal('show')
  ;
  $('#kokemuslink').click(function(){
    loadPDF(document.baseURI.substring(0, document.baseURI.lastIndexOf('/') + 1) + '2016_TeKu_Tuukka Heiskanen_Netherlands.pdf');
  $('.ui.modal').modal('hide');
  }); 
}

function getSchools() {
  $.ajax({
    method: "GET",
    url: "api/getschools.php"
  })
    .done(function(response) {
      var schools = JSON.parse(response);
      setMarkers(schools);
    });
}

function setDropdowns(schools) {
  var select = document.getElementById('schoolmenu');
  var option = document.createElement('option');
  option.value = schools.place_id;
  option.id = schools.id;
  option.text = schools.name;
  console.log(option.text);
  select.add(option, 0);
}

function setMarkers(schools) {
  for(var i = 0; i < schools.length; i++){
    findSchool(schools[i]);
    setDropdowns(schools[i]);
  }
}

function loadPDF(url) {
  $('#pdf-loader').css('display', 'initial');
  $('#pdfcontrols').css('opacity', 100);

  pdfControlsTimeoutFunc = setTimeout(function () {
    $('#pdfcontrols').css('opacity', 0);
  }, 3000);

  window.addEventListener('scroll', pdfScrollChecker);

  PDFJS.workerSrc = './js/pdf.worker.min.js';

  var pdfDoc = null,
      pageNum = 1,
      pageRendering = false,
      pageNumPending = null,
      scale = 1.5,
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
      canvas.height = viewport.height;
      canvas.width = viewport.width;

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
  onPrevPage = function () {
    if (pageNum <= 1) {
      return;
    }
    pageNum--;
    queueRenderPage(pageNum);
  }

  document.getElementById('pdf-viewer-prev').addEventListener('click', onPrevPage);

  /**
   * Displays next page.
   */
  onNextPage = function () {
    if (pageNum >= pdfDoc.numPages) {
      return;
    }
    pageNum++;
    queueRenderPage(pageNum);
  }

  document.getElementById('pdf-viewer-next').addEventListener('click', onNextPage);

  /**
   * Asynchronously downloads PDF.
   */
  PDFJS.getDocument(url).then(function (pdfDoc_) {
    pdfDoc = pdfDoc_;
    document.getElementById('page_count').textContent = pdfDoc.numPages;

    // Initial/first page rendering
    renderPage(pageNum);

    $('#pdf-loader').css('display', 'none');
    $('#pdfviewer').css('display', 'initial');
    $('#pdfcontrols').css('display', 'initial');
  });
}

function unloadPDF() {
  $('#pdfviewer').css('display', 'none');
  $('#pdfcontrols').css('display', 'none');
  document.getElementById('pdf-viewer-prev').removeEventListener('click', onPrevPage);
  document.getElementById('pdf-viewer-next').removeEventListener('click', onNextPage);
  window.removeEventListener('scroll', pdfScrollChecker);
}

$(document).ready(function () {
  $('.ui.dropdown').dropdown();

  $('.ui.dropdown').on('change', function (evt) {
    if (!isNaN(evt.target.value)) {
      focusCountry(parseInt(evt.target.value));
    }
  });

  $('#schoolmenu').on('change', function () {
    initMap();
  });

  getSchools();
});