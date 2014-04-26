var lunchLine = [];

$(document).ready(function() {
	request("get-friends",{}, function(data) {
		list = $("#friendlist ul");
		list.html("");
		$.each(data, function(k, person) {
			list.append("<li><img src='" + person.dp + "' />    " + person.name + "</li>");
			lunchLine.push(person);
		});
	})
});

