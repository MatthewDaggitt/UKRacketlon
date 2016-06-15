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
 * HTML View class for the RacketlonRankings Component
 *
 * @since  0.0.1
 */
class RacketlonRankingsViewPlayer extends JViewLegacy
{
	/**
	 * Display the Player view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
		// Assign data to the view
		$this->params = $this->get('Msg');
 		$this->players = $this->get('Players');
 		$this->id = JFactory::getApplication()->input->get('player_id', 1, 'INT');

 		if($this->id >= -1)
 		{
 			JFactory::getDocument()->setTitle($this->params['player']['name']);
 		}

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
 
			return false;
		}
 
		// Display the view
		parent::display($tpl);
	}
}