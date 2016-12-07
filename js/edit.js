$(document).ready(function(){
  $(".school-edit-btn").click(function(){
    $('#editmodal').modal('show');
    $('#country-input').dropdown("set selected", $(this).data('country'));
    $('#city-input').dropdown("set selected", $(this).data('city'));
    $('#place-id-set-edit').data('place_id', $(this).data('placeid'));
    $('.ui.dropdown').dropdown('refresh');
    $('#school-input').val($(this).data("school"));
    var tempdepartments = [];
    tempdepartments = $(this).data('departments1');
    if (typeof tempdepartments === "number") {
      tempdepartments = tempdepartments + '';
    }
    
    if(tempdepartments.length > 0)
    {  
      var departments1 = tempdepartments.split(",");
    }
    else
    {
      var departments1 = [];
    }
    
    var deplength = departments1.length;
    var schoolid1 = $(this).data('id');

    for (var i = 1; i < 9; i++) {
      $("#editmodal .checkbox").find('[value=' + [i] + ']').prop("checked", false);
    }

    for (var i = 0; i < deplength; i++) {
      $("#editmodal .checkbox").find('[value=' + departments1[i] + ']').prop("checked", true);
    }
    
    $("#save-edit").click(function(){
      var departments1 = [];
      var schoolname1 = $("#school-input").val();
      var city1 = $("#city-input").val();
      var country1 = $("#country-input").val();
      var placeid1 = $('#place-id-set-edit').data('place_id');
      departments1 = $.map($('input[name="departments1"]:checked'), function(c){return c.value; });
      deplength = departments1.length;
      if (deplength == 0)
      {
        deplength = "none";
      }
      var cityint1 = parseInt(city1);
      var countryint1 = parseInt(country1);
      if (schoolname1 != '' && city1 != '' && country1 != '' && typeof(placeid1) != 'undefined') {
        $.ajax({
          method: "POST",
          url: "api/edit.php",
          data: {
            schoolid: schoolid1,
            schoolname: schoolname1,
            city: cityint1,
            country: countryint1,
            placeid: placeid1,
            departments: departments1,
            deplength: deplength,
            action: 1
          },
          success: function(result){
            $("#editmodal").modal("hide");
            location.reload(true);
          }
        });
      }
    })
  });

  // Placeid haku koulua luodessa
  $('#create-set-placeid').click(function() {
    $('#place-id-select-btn').data('createOrUpdate', 'create');
    $('#place-id-selector').css('display', 'initial');
    $('.ui.dimmer').css('z-index', 100);
    initPlaceIDSearch();
  });

  // Placeid haku koulua muokatessa
  $('#edit-set-placeid').click(function() {
    $('#place-id-select-btn').data('createOrUpdate', 'edit');
    $('#place-id-selector').css('display', 'initial');
    $('.ui.dimmer').css('z-index', 100);
    initPlaceIDSearch();
  });

  $("#add-school-btn").click(function(){
  	$("#addmodal").modal("show");

    for (var i = 1; i < 9; i++) {
      $("#addmodal .checkbox").find('[value=' + [i] + ']').prop("checked", false);
    }
  });

  $("#add-pdf-btn").click(function(){
    $("#pdf-modal").modal("show");
  });

  $('.addmodal').form({
    fields: {
      schoolname : 'empty',
      cityname : 'empty',
      countryname : 'empty',
    }
  });

  $('.editmodal').form({
    fields: {
      schoolname1 : 'empty',
      cityname1 : 'empty',
      countryname1 : 'empty',
    }
  });

  $('.ui.checkbox').checkbox();

  $('select.dropdown').dropdown();

  $("#saveschool").click(function(){
    var schoolname;
    var city;
    var country;
    var placeid;
    var departments = $.map($('input[name="departments"]:checked'), function(c){return c.value; });
    var place_id = $('#place-id-set-create').data('place_id');

    if(typeof(place_id) == 'undefined')
    {
      document.getElementById("create-set-placeid").style.background='#db082f';
    }

    schoolname = $("#addschoolname").val();
    city = $("#addcity").val();
    country = $("#addcountry").val();
    var cityint = parseInt(city);
    var countryint = parseInt(country);

    if (schoolname != '' && city != '' && country != '' && typeof(place_id) != 'undefined') {
      $.ajax({
        method: "POST",
        url: "api/edit.php",
        data: {
          schoolname: schoolname,
          city: cityint,
          country: countryint,
          placeid: place_id,
          departments: departments,
          action: 0
        },
        success: function(result){
          $("#addmodal").modal("hide");
          location.reload(true);
        }
      });
    }
  });

  $(".school-delete-btn").click(function(){
    var schoolid = $(this).data('id');

    if(schoolid != 0)
    {
      $.ajax({
        method: "POST",
        url: "api/edit.php",
        data: { 
          schoolid: schoolid,
          action: 2,
        },
        success: function(result){
           location.reload(true);
        }
      })
    }
  });
});
// ajax action 0:luominen, 1:edit, 2:delete

$('#place-id-select-btn').click(function() {
  $('#place-id-selector').css('display', 'none');
  var place_id = $(this).data('place_id');
  if ($(this).data('createOrUpdate') === 'create') {
    $('#place-id-set-create').data('place_id', place_id);
    $('#place-id-set-create').html('Asetettu');
  } else if ($(this).data('createOrUpdate') === 'edit') {
    $('#place-id-set-edit').data('place_id', place_id);
    $('#place-id-set-edit').html('Asetettu');
  }
});

function initPlaceIDSearch() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: -33.8688, lng: 151.2195},
    zoom: 13
  });

  var input = document.getElementById('pac-input');

  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.bindTo('bounds', map);

  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  var infowindow = new google.maps.InfoWindow();
  var marker = new google.maps.Marker({
    map: map
  });
  marker.addListener('click', function() {
    infowindow.open(map, marker);
  });

  autocomplete.addListener('place_changed', function() {
    infowindow.close();
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }

    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);
    }

    // Set the position of the marker using the place ID and location.
    marker.setPlace({
      placeId: place.place_id,
      location: place.geometry.location
    });

    marker.setVisible(true);

    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' +
      place.formatted_address);
      infowindow.open(map, marker);

    $('#place-id-select-btn').data('place_id', place.place_id);
  });
}