var lunchLine = [];

$(document).ready(function() {
	request("get-friends",{}, function(data) {
		list = $("#friendlist ul");
		list.html("");
		var starttime;
		var endtime;
		$.each(data, function(k, person) {
			starttime = parseTime(person.startdatetime);
			endtime = parseTime(person.enddatetime);
			list.append("<li><img src='" + person.dp + "' />    <div class='smallinfo'>Start:" + starttime + "<br /> End:" + endtime + "</div>" + person.name + "</li>");
			lunchLine.push(person);
		});
	})
});

function parseTime(time) {
	var temp = time.split(" ")[1].split(":");
	return Math.floor(time[0]) + ":" + time[1];
}

