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
