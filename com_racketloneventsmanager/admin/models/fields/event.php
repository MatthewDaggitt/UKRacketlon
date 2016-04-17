<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_racketloneventsmanager
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
JFormHelper::loadFieldClass('list');
 
/**
 * RacketlonEventsManager Form Field class for the RacketlonEventsManager component
 *
 * @since  0.0.1
 */
class JFormFieldEvent extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'Event';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array  An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id,name,type,link,singles,doubles,teams,dated,startdate,enddate');
		$query->from('#__racketloneventsmanager');
		$db->setQuery((string) $query);
		$messages = $db->loadObjectList();
		$options  = array();
 
		if ($messages)
		{
			foreach ($messages as $message)
			{
				$options[] = JHtml::_('select.option',
										 $message->id,
										 $message->name,
										 $message->type,
										 $message->link,
										 $message->singles,
										 $message->doubles,
										 $message->teams,
										 $message->year,
										 $message->dated,
										 $message->startdate,
										 $message->enddate,
										 $message->location,
										 $message->postcode,
										 $message->latitude,
										 $message->longitude);
			}
		}
 
		$options = array_merge(parent::getOptions(), $options);
 
		return $options;
	}
}