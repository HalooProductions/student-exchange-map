$(document).ready(function () {
	//your code here
	$('.small.modal')
	.modal({
		autofocus: true,
		blurring: true
	}).modal('show');

	$("#log").click(function() {
		var username = $("#username").val();
		var password = $("#password").val();
	});
});