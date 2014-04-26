var licolors = ['green', 'blue', 'orange', 'purple'];
var licolor = 0;

$(document).ready(function() {
	request("get-friends",{}, function(data) {
		var list = $("#friendlist ul");
		list.html("");
		var starttime;
		var endtime;
		$.each(data, function(k, person) {
			starttime = parseTime(person.startdatetime);
			endtime = parseTime(person.enddatetime);
			var liEl = $("<li fbid='" + person.id  + "' value='" + person.name + "'><img src='" + person.dp + "' /><div id='name'> " + person.name 
				+ "</div><div class='smallinfo'>Start: " + starttime 
				+ "<br />End: " + endtime 
				+ "<br />Preference: </div></li>");
			list.append(liEl);
			liEl.click(function() {
				if ($(this).css('background')) {
					$(this).css('background', '');
				} else {
					$(this).css('background', licolors[licolor]);
					licolor++;
					if (licolor >= licolors.length) {
						licolor = 0;
					};
				}
				request('get-friend-locations', {facebook_id: $(this).attr("fbid")}, function(data) {
					$.each(data, function(k, v) {
						removeMarkers("blue");
						addBusinessMarker(v, "blue");
					});
				});
			});
		});
	});
});

function parseTime(time) {
	var temp = time.split(" ")[1].split(":");
	if (temp[0][0] == 0) temp[0] = temp[0].substr(1,1);
	return temp[0] + ":" + temp[1];
}
