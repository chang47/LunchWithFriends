var lunchLine = [];

$(document).ready(function() {
	request("get-friends",{}, function(data) {
		$list = $("#friendlist ul");
		for (var person in data) {
			$list.append("<li><img src='" + person.dp + "' /> + person.name + "</li>");
			lunchLine.push(person);
		}
	})
});

