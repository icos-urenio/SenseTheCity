window.addEvent('domready', function() {
	document.formvalidator.setHandler('minlenght2',
		function (value) {
			if (value.length < 2) {
				return false;
			} else {
				return true;
			}
	});
});