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
				//console.log($(this).css('background-color') == "rgba(0, 0, 0, 0)");
				if ($(this).css('background-color') != "rgba(0, 0, 0, 0)") {
					var removeColor = $(this).css('background-color');
					$(this).css('background-color', "rgba(0, 0, 0, 0)");
					removeMarkers(removeColor);
				} else {
					$('#friendlist ul li').css('background-color', "rgba(0, 0, 0, 0)");
					licolor++;
					if (licolor >= licolors.length || licolor - 1 < 0) {
						licolor = 0;
					};
					$(this).css('background-color', licolors[licolor]);
				}
				request('get-friend-locations', {facebook_id: $(this).attr("fbid")}, function(data) {
					$.each(data, function(k, v) {
						if (licolor >= licolors.length || licolor - 1 < 0) {
							licolor = 1;
						};
						removeMarkers(licolor - 1);
						addBusinessMarker(v, licolors[licolor]);
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
