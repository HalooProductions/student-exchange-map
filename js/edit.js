$(document).ready(function(){
  $(".school-edit-btn").click(function(){
    $('#editmodal').modal('show');
    $('#country-input').dropdown("set selected", $(this).data('country'));
    $('#city-input').dropdown("set selected", $(this).data('city'));
    $('.ui.dropdown').dropdown('refresh');
    $('#school-input').val($(this).data("school"));
  });

  $("#add-school-btn").click(function(){
  	$("#addmodal").modal("show");

  	var schoolname = $("#addschoolname").val();
  	var placeid = $("#addplaceid").val();

  	$.ajax({
  		method: "POST",
  		url: "api/edit.php",
  		data: {}
  	});
  });

  $('.ui.checkbox').checkbox();

  $('select.dropdown').dropdown();
});



