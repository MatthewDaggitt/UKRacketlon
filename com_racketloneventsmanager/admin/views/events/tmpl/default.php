<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_racketloneventsmanager
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JHtml::_('formbehavior.chosen', 'select');
 
$listOrder     = $this->escape($this->filter_order);
$listDirn      = $this->escape($this->filter_order_Dir);
?>

<form action="index.php?option=com_racketloneventsmanager&view=events" method="post" id="adminForm" name="adminForm">
	
	<div class="row-fluid">
		<div class="span6">
			<?php
				echo JLayoutHelper::render(
					'joomla.searchtools.default',
					array('view' => $this)
				);
			?>
		</div>
	</div>

	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="2%">
				<?php echo JHtml::_('grid.checkall'); ?>
			</th>
			<th width="20%">
				<?php echo JHtml::_('grid.sort', 'Name', 'name', $listDirn, $listOrder); ?>
			</th>
			<th width="1px">
				<?php echo JHtml::_('grid.sort', 'Type', 'type', $listDirn, $listOrder); ?>
			</th>
			<th width="10%">
				<?php echo JHtml::_('grid.sort', 'Link', 'link', $listDirn, $listOrder); ?>
			</th>
			<th width="1px">
				<?php echo JHtml::_('grid.sort', 'Singles', 'singles', $listDirn, $listOrder); ?>
			</th>
			<th width="1px">
				<?php echo JHtml::_('grid.sort', 'Doubles', 'doubles', $listDirn, $listOrder); ?>
			</th>
			<th width="1px">
				<?php echo JHtml::_('grid.sort', 'Teams', 'teams', $listDirn, $listOrder); ?>
			</th>
			<th width="1px">
				<?php echo JHtml::_('grid.sort', 'Year', 'year', $listDirn, $listOrder); ?>
			</th>
			<th width="1px">
				<?php echo JHtml::_('grid.sort', 'Start date', 'startdate', $listDirn, $listOrder); ?>
			</th>
			<th width="1px">
				<?php echo JText::_('End date') ?>
			</th>
			<th width="5%">
				<?php echo JText::_('Location'); ?>
			</th>
			<th width="5%">
				<?php echo JText::_('Postcode'); ?>
			</th>
			<th width="5%">
				<?php echo JText::_('Latitude'); ?>
			</th>
			<th width="5%">
				<?php echo JText::_('Longitude'); ?>
			</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="14">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row) : 
					$link = JRoute::_('index.php?option=com_racketloneventsmanager&task=event.edit&id=' . $row->id);
				?>
					<tr>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
						<td>
							<a href="<?php echo $link; ?>" title="<?php echo JText::_('Edit this event'); ?>">
								<?php echo $row->name; ?>
							</a>
						</td>
						<td>
							<?php echo $row->type; ?>
						</td>
						<td>
							<?php
								$link = $row->link;
								if(strlen($link) > 30) {
									$link = substr($link, 0 , 30) . "...";
								}
								echo $link;
							?>
						</td>
						<td>
							<?php echo $row->singles; ?>
						</td>
						<td>
							<?php echo $row->doubles; ?>
						</td>
						<td>
							<?php echo $row->teams; ?>
						</td>
						<td>
							<?php echo $row->year; ?>
						</td>
						<td>
							<?php 
								if ($row->dated) {
									echo $row->startdate;
								}
							?>
						</td>
						<td>
							<?php 
								if ($row->dated) {
									echo $row->enddate;
								}
							?>
						</td>
						<td>
							<?php echo $row->location; ?>
						</td>
						<td>
							<?php echo $row->postcode; ?>
						</td>
						<td>
							<?php echo substr($row->latitude,0,8); ?>
						</td>
						<td>
							<?php echo substr($row->longitude,0,8); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</form>