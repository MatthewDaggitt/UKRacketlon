<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_racketlonrankings
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Rankings Model
 *
 * @since  0.0.1
 */
class RacketlonRankingsModelRankings extends JModelItem
{
	/**
	 * @var string message
	 */
	protected $message;
 
 	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Player', $prefix = 'RacketlonRankingsTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}


	/**
	 * Get the message
         *
	 * @return  string  The message to be displayed to the user
	 */
	public function getMsg($number=10)
	{
		if (!isset($this->message))
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true)
					->select('*')
					->from($db->quoteName('#__players'))
					->order($db->quoteName('rating') . ' desc');
			$db->setQuery($query);
			$this->message = $db->loadAssocList();
		}
 
		return $this->message;
	}
}