function initDataTable() {
	var cssLink = $('<link rel="stylesheet" type="text/css" href="'+THEME_URL+'assets/advanced-datatable/media/css/jquery.dataTables.min.css">');
	$("head").append(cssLink);

	var jsLink = $('<script type="text/javascript" src="'+THEME_URL+'assets/advanced-datatable/media/js/jquery.dataTables.js"></script>');
	$("head").append(jsLink);
}