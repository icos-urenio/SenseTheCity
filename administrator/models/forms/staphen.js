window.addEvent('domready', function() {
	document.formvalidator.setHandler('minlength2',
		function (value) {
			if (value.length < 2) {
				return false;
			} else {
				return true;
			}
	});
});