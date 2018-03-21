$(document).ready(function() {

	$.ajax({
	    url: "style-switcher.html",
	    success: function (data) { $('body').append(data); },
	    dataType: 'html'
	});

});