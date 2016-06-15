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
 * Player Model
 *
 * @since  0.0.1
 */
class RacketlonRankingsModelPlayer extends JModelItem
{
	/**
	 * @var string message
	 */
	protected $messages;
 	protected $players;

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
	public function getMsg($id=1)
	{
		if (!is_array($this->messages))
		{
			$this->messages = array();
		}

		if (!isset($this->messages[$id]))
		{
			// Request the selected id
			$jinput = JFactory::getApplication()->input;
			$id     = $jinput->get('player_id', 1, 'INT');
 
			// Get a TablePlayer instance

			$db = JFactory::getDbo();

			$query = $db->getQuery(true)
				->select('*')
				->from($db->quoteName('#__players'))
				->where('id=' . $id);
			$db->setQuery($query);
			$player = $db->loadAssoc();

			require_once("countries.php");
			$player['country'] = $allCountries[$player['country']];
			$player['ageCategory'] = $this->convertDoBToAgeCategory($player['dob']);

			$query = $db->getQuery(true)
				->select('*')
				->from($db->quoteName('#__matches'))
				->where('p1id=' . $id)
				->order($db->quoteName('date') . ' asc')
				->order($db->quoteName('matchNo') . ' asc');
			$db->setQuery($query);
			$matches = $db->loadAssocList();

			// Assign the message
			$this->messages[$id] = $this->collateResults($player, $matches);
		}
 
		return $this->messages[$id];
	}

	public function getPlayers()
	{
		if (!isset($this->players))
		{
			$db = JFactory::getDbo();

			$query = $db->getQuery(true)
				->select($db->quoteName(array('id', 'name')))
				->from($db->quoteName('#__players'));
			$db->setQuery($query);
			$this->players = $db->loadAssocList();
		}
		return $this->players;
	}

	private function collateResults($player, $matches)
	{
		$tournaments = array();
		foreach($matches as $match)
		{
			if(!array_key_exists($match['tournament'], $tournaments))
			{
				$tournaments[$match['tournament']] = array('matches' => array());
			}
			$tournaments[$match['tournament']]['matches'][] = $match;
		}

		foreach($tournaments as $name => $tournament)
		{
			$firstMatch = $tournament['matches'][0];
			$lastMatch = end($tournament['matches']);
			$matches = $tournament['matches'];

			$r   = $lastMatch['p1rating']   + $lastMatch['p1ratingchg'];
			$rtt = $lastMatch['p1ratingtt'] + $lastMatch['p1ratingchgtt'];
			$rbd = $lastMatch['p1ratingbd'] + $lastMatch['p1ratingchgbd'];
			$rsq = $lastMatch['p1ratingsq'] + $lastMatch['p1ratingchgsq'];
			$rtn = $lastMatch['p1ratingtn'] + $lastMatch['p1ratingchgtn'];

			$tournaments[$name]['finalRating']   = $r == 0 ? null : $r;
			$tournaments[$name]['finalRatingtt'] = $rtt == 0 ? null : $rtt;
			$tournaments[$name]['finalRatingbd'] = $rbd == 0 ? null : $rbd;
			$tournaments[$name]['finalRatingsq'] = $rsq == 0 ? null : $rsq;
			$tournaments[$name]['finalRatingtn'] = $rtn == 0 ? null : $rtn;

			$tournaments[$name]['startDate']     = $firstMatch['date'];
			$tournaments[$name]['endDate']       = $lastMatch['date'];
		}

		return array('player' => $player, 'tournaments' => $tournaments);
	}

	private function convertDoBToAgeCategory($dob)
	{
		if($p["dob"] != "0000-00-00")
		{
			$dob21 = (new DateTime($dob))->add(new DateInterval('P21Y'));
			$dob45 = (new DateTime($dob))->add(new DateInterval('P45Y'));
			$dob55 = (new DateTime($dob))->add(new DateInterval('P55Y'));

			$now = new DateTime();
			if($now < $dob21)
			{
				return 'Junior';
			}
			if($now > $dob55)
			{
				return 'O55';
			}
			if($now > $dob45)
			{
				return 'O45';
			}
		}
		return "";
	}
}