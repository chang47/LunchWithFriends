var lunchLine = [];

$(document).ready(function() {
	request("get-friends",{}, function(data) {
		var list = $("#friendlist ul");
		list.html("");
		var starttime;
		var endtime;
		$.each(data, function(k, person) {
			starttime = parseTime(person.startdatetime);
			endtime = parseTime(person.enddatetime);
			console.log(person.name + " " + person.dp + " " + endtime + " " + starttime);
			list.append("<li value='" + person.name "'><img src='" + person.dp + "' /><div id='name'>" + person.name 
				+ "</div><div class='smallinfo'>Start: " + starttime 
				+ "<br />End: " + endtime 
				+ "<br />Preference: </div></li>");
			lunchLine.push(person);
		});
	})
});

function parseTime(time) {
	var temp = time.split(" ")[1].split(":");
	if (temp[0][0] == 0) temp[0] = temp[0].substr(1,1);
	return temp[0] + ":" + temp[1];
}

