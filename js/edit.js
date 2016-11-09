$(document).ready(function(){
  $(".school-edit-btn").click(function(){
    $('#editmodal').modal('show');
    $('#country-input').dropdown("set selected", $(this).data('country'));
    $('#city-input').dropdown("set selected", $(this).data('city'));
    $('.ui.dropdown').dropdown('refresh');
    $('#school-input').val($(this).data("school"));

    var schoolname = $('#school-input').val();
    var country = $('#city-input').val();
    var city = $('#country-input').val();

    $.ajax({
      method: "POST",
      url : "api/edit.php",
      data: {
        schoolname: schoolname,
        city: city,
        country: country,
      }
    })
  });

  $("#add-school-btn").click(function(){
  	$("#addmodal").modal("show");

  	var schoolname = $("#addschoolname").val();
    var city = $("#addcity").val();
    var country = $("#addcountry").val();
  	var placeid = $("#addplaceid").val();

  	/*$.ajax({
  		method: "POST",
  		url: "api/edit.php",
  		data: {
        schoolname: schoolname,
        city: city,
        country: country,
        placeid: placeid,
      }
  	});*/


  });

  $('.ui.checkbox').checkbox();

  $('select.dropdown').dropdown();

var map;
var google;
var results;
var service;


function initMap() {
  map = new google.maps.Map(document.getElementById('map'));
  service = new google.maps.places.PlacesService(map);
}


$("#addschoolname").on("input", (function(){
        var request = {
       query: $("#addschoolname").val(),
       key: "AIzaSyDaRfRL0VME9zL0OZrRNjiLxIMWgis-W5U",
      };
      service.textSearch(request, callback);
      function callback(results, status){
        console.log(results);
      }
    }));
});