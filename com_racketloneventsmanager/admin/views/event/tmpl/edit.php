<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_racketloneventsmanager
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.formvalidator');
?>

<form action="<?php echo JRoute::_('index.php?option=com_racketloneventsmanager&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="form-horizontal">
		<fieldset class="adminform">
			<legend><?php echo JText::_('Event details'); ?></legend>
			<div class="row-fluid">
				<div class="span6">
					<?php foreach ($this->form->getFieldset() as $field): ?>
						<?php
							$class = '';
							$rel = '';
							if ($showon = $field->getAttribute('showon')) {
								JHtml::_('jquery.framework');
								JHtml::_('script', 'jui/cms.js', false, true);
								$id = $this->form->getFormControl();
								$showon = explode(':', $showon, 2);
								$class = ' showon_' . implode(' showon_', explode(',', $showon[1]));
								$rel = ' rel="showon_' . $id . '[' . $showon[0] . ']"';
							}
						?>
						<div class="control-group<?php echo $class; ?>"<?php echo $rel; ?>>
							<div class="control-label"><?php echo $field->label; ?></div>
							<div class="controls"><?php echo $field->input; ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</fieldset>
	</div>
	<input type="hidden" name="task" value="racketloneventsmanager.edit" />
	<?php echo JHtml::_('form.token'); ?>
</form>


<script type="text/javascript">
	// Smart initialisation of default date values
	var defaultValue = "2016-01-01";

	startDateField = jQuery('.validate-startdate');
	startDateButton = startDateField.next();
	endDateField = jQuery('.validate-enddate');

	if(startDateField.attr('value') == defaultValue && endDateField.attr('value') == defaultValue) {
		var today = new Date().toISOString().slice(0, 10);
		startDateField.attr('value', today);
		endDateField.attr('value', today);
	}

	// Smart update of end date value based on start date value
	var updateEndDate = function() {
		jQuery('.validate-enddate').attr('value', jQuery('.validate-startdate').attr('value'));
	};

	// Horrible hack as Joomla doesn't fire the event changed value
	startDateField.focusout(updateEndDate);
	startDateButton.focusout(updateEndDate);
</script>

<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA-XCnoJQEARUqKqIMI9J16Ax6g5e1Fxh0"></script>
<script type="text/javascript">
	// Auto-finds location details from postcode
	var geocoder = new google.maps.Geocoder();


	var updateLocation = function () {
		console.log("hi");

		var postcode = jQuery('.validate-postcode').attr('value');

		geocoder.geocode({'address': postcode}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				jQuery('.validate-location').attr('value', results[0].address_components[2].long_name);
				jQuery('.validate-latitude').attr('value', results[0].geometry.location.lat());
				jQuery('.validate-longitude').attr('value', results[0].geometry.location.lng());
			} 
			else {
				console.log('Geocode was not successful for the following reason: ' + status);
			}
		});
	};

	jQuery('.validate-postcode').focusout(updateLocation);

</script>

