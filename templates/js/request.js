function request(action, parameters, callback) {
	parameters['action'] = action;
	$.get('../request.php', parameters, function(response) {
		if(response.success == false) {
			alert("SOMETHINGS WRONG BRO: " + response.msg);
			if(response.url) {
				location.href = response.url;
			}
		} else {
			callback(response.data);
		}
	}, "json");
}
