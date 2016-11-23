$(document).ready(function(){
  var departments = [];
  var schoolid;
  var schoolname;
  var city;
  var country;
  var placeid;
  $(".school-edit-btn").click(function(){
    $('#editmodal').modal('show');
    $('#country-input').dropdown("set selected", $(this).data('country'));
    $('#city-input').dropdown("set selected", $(this).data('city'));
    $('.ui.dropdown').dropdown('refresh');
    $('#school-input').val($(this).data("school"));
    departments = $(this).data('departments').split(",");
    var deplength = departments.length;

    for (var i = 1; i < 9; i++) {
      $("#editmodal .checkbox").find('[value=' + [i] + ']').prop("checked", false);
    }

    for (var i = 0; i < deplength; i++) {
      $("#editmodal .checkbox").find('[value=' + departments[i] + ']').prop("checked", true);
      console.log($("#editmodal .checkbox").find('[value=' + departments[i] + ']'));
    }
    schoolid = $(this).data('id');
    schoolname = $(this).data('school');
    city = $(this).data('city');
    country = $(this).data('country');
    placeid = $(this).data('placeid');
  });

  $("#save-edit").click(function(){
    var departments1 = [];
    console.log(city);
    console.log(country);
    schoolname = $("#school-input").val();
    city = $("#city-input").val();
    country = $("#country-input").val();
    departments1 = $.map($('input[name="departments"]:checked'), function(c){return c.value; });
    console.log(departments1);
    var cityint = parseInt(city);
    var countryint = parseInt(country);

    $.ajax({
      method: "POST",
      url: "api/edit.php",
      data: {
        schoolid: schoolid,
        schoolname: schoolname,
        city: cityint,
        country: countryint,
        placeid: placeid,
        departments: departments1,
        action: 1
      },
      success: function(result){
        $("#addmodal").modal("hide");
      }
    });
  })

  $("#add-school-btn").click(function(){
  	$("#addmodal").modal("show");
  });

  $('.ui.checkbox').checkbox();

  $('select.dropdown').dropdown();

  $("#saveschool").click(function(){

    departments = $.map($('input[name="departments"]:checked'), function(c){return c.value; });

    schoolname = $("#addschoolname").val();
    var map;
    var service;
    var infowindow;
    initialize();
    function initialize() {

      map = new google.maps.Map(document.getElementById('map'));

      var request = {
        query: schoolname,
      };

      service = new google.maps.places.PlacesService(map);
      service.textSearch(request, callback);
    }

    function callback(results, status) {
      if (status == google.maps.places.PlacesServiceStatus.OK) {
          console.log(results);
          schoolname = $("#addschoolname").val();
          city = $("#addcity").val();
          country = $("#addcountry").val();
          placeid = results[0].place_id;

          var cityint = parseInt(city);
          var countryint = parseInt(country);
          console.log(city);
          console.log(country);
          if (schoolname != '' && city != '' && country != '' && placeid != '')
          {
            $.ajax({
              method: "POST",
              url: "api/edit.php",
              data: {
                schoolname: schoolname,
                city: cityint,
                country: countryint,
                placeid: placeid,
                departments: departments,
                action: 0
              },
              success: function(result){
                $("#addmodal").modal("hide");
              }
            });
          }
      }   
    }
  });
});
// ajax action 0:luominen, 1:edit, 2:delete