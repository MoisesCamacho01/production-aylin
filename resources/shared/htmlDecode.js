function htmlDecode(string) {
	var entityMap = {
	  '&amp;': '&',
	  '&lt;': '<',
	  '&gt;': '>',
	  '&quot;': '"',
	  '&#039;': "'"
	};

	return string.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g, function(match) {
	  return entityMap[match];
	});
}

function getRandomColor() {
	var letters = '0123456789ABCDEF';
	var color = '#';
	for (var i = 0; i < 6; i++) {
		 color += letters[Math.floor(Math.random() * 16)];
	}
	return color;
}
