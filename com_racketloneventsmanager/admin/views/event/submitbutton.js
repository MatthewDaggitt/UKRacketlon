Joomla.submitbutton = function(task)
{
	if(task == '')
	{
		return false;
	}

	var action = task.split('.')[1];
	if(action == 'cancel' || action == 'close' || document.formvalidator.isValid(document.adminForm))
	{
		Joomla.submitform(task);
		return true;
	}

	error = [];
	if(jQuery('.validate-postcode').hasClass('invalid')) {
		error.push("Please enter a valid postcode");
	}
	if(jQuery('.validate-location').hasClass('invalid')) {
		error.push("Only alphanumeric characters are valid for 'Location'");
	}
	if(jQuery('.validate-enddate').hasClass('invalid')) {
		error.push("Please enter a date of the form 'YYYY-MM-DD' for the 'End date' and make sure it is after 'Start date'");
	}
	if(jQuery('.validate-startdate').hasClass('invalid')) {
		error.push("Please enter a date of the form 'YYYY-MM-DD' for the 'Start date'. It must also agree with the value for 'Year'");
	}
	if(jQuery('.validate-year').hasClass('invalid')) {
		error.push("Please enter a year of the form 'YYYY' for the 'Year'");
	}
	if(jQuery('.validate-name').hasClass('invalid')) {
		error.push("Only alphanumeric characters are valid for the 'Name'");
	}
	Joomla.renderMessages({"error": error});
	window.scrollTo(0,0);

	return false;
}