<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_racketlonrankings
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>

<form action="index.php?option=com_racketlonrankings&view=dataupload" method="post" enctype="multipart/form-data" id="adminForm" name="adminForm">
	<div class="form-horizontal">
        <fieldset class="adminform">
            <legend>
            	<?php echo JText::_('Update rankings'); ?>
            </legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php foreach ($this->form->getFieldset() as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>

                    <div class="btn-group">
						<button type="submit" name="submit" class="btn btn-primary">
							<i class="icon-ok"></i> Upload and recompute
						</button>
					</div>
                </div>
            </div>
        </fieldset>
    </div>

    <input type="hidden" name="task" value="submit" />
</form>

<script>
    console.log("Hi2");
    jQuery("#adminForm").submit(function(e){
        var count = 0;
        var button = jQuery('[name=submit]');
        window.setInterval(function() {
            count += 1;
            button.text("Calculating" + (".".repeat(count % 4)));
        }, 500);
    });
</script>