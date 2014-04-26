$(document).ready(function() {
	$friends = $('#friendlist li');
	$friends.filter(':even').css('background', 'gray');
	$friends.filter(':odd').css('background', 'black');
	var login = false;
	$friendlist = $('#friendlist');
	if (login) {
		$friendlist.css('background', '');
		$friendlist.css('text-align', 'left');
		$friendlist.css('color', 'white');
		$friendlist.css('padding-top', '0px');
	};
	$friendlist.click(function() {
		friendlist_toggle();
	});
});

function friendlist_toggle() {
	$friendlist.css('background', '');
	$friendlist.css('text-align', 'left');
	$friendlist.css('color', 'white');
	$friendlist.css('padding-top', '0px');
	// do fancy stuff
}