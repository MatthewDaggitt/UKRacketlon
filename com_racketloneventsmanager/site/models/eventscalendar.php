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
 
/**
 * EventsCalendar Model
 *
 * @since  0.0.1
 */
class RacketlonEventsManagerModelEventsCalendar extends JModelList
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
 		
 		$jinput = JFactory::getApplication()->input;
 		$year = $jinput->get('year', '0', 'INT');

		// Create the base select statement.
		$query->select('*');
		$query->from($db->quoteName('#__racketloneventsmanager'));
 		$query->where($db->quoteName('year') . " = '" . $year . "'");
 		$query->limit('0,1000');

 		$this->setState('list.limit', 0);

 		
		return $query;
	}
}