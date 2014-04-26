$(document).ready(function() {
	$friends = $('#friendlist li');
	$friends.filter(':even').css('background', 'gray');
	$friends.filter(':odd').css('background', 'black')
});