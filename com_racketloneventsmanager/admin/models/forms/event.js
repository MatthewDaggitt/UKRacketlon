jQuery(function() {
	document.formvalidator.setHandler('name', function (value) {
		regex=/^[a-z0-9 .&-()]+$/i;
		return regex.test(value);
	});

	document.formvalidator.setHandler('year', function (value) {
		regex=/^\d{4}$/;
		return regex.test(value);
	});

	document.formvalidator.setHandler('startdate', function (value) {
		regex=/^\d{4}-[01]\d-[0123]\d$/;
		dated = jQuery('.validate-dated > :checked').attr('value') == "1";
		year = jQuery('.validate-year')[0].value;
		return !dated || (regex.test(value) && value.substring(0,4) == year);
	});

	document.formvalidator.setHandler('enddate', function (value) {
		regex=/^\d{4}-[01]\d-[0123]\d$/;
		dated = jQuery('.validate-dated > :checked').attr('value') == "1";
		startdate = jQuery('.validate-startdate')[0].value;
		return !dated || (regex.test(value) && startdate <= value);
	});

	document.formvalidator.setHandler('location', function (value) {
		regex=/^[a-z0-9 .,&-]+$/i;
		return regex.test(value);
	});

	document.formvalidator.setHandler('postcode', function (value) {
		regex=/^[a-z]{1,2}\d{1,2}\s?\d[a-z]{2}$/i;
		return regex.test(value);
	});

	document.formvalidator.setHandler('latitude', function (value) {
		return true;
	});

	document.formvalidator.setHandler('longitude', function (value) {
		return true;
	});
});