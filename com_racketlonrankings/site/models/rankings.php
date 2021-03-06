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

	public function getUpdating()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select($db->quoteName('value'))
			->where($db->quoteName('property') . ' = ' . $db->quote('updating'))
			->from($db->quoteName('#__rankings_config'));
		$db->setQuery($query);
		return $db->loadResult();
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
					->where('active=1')
					->order($db->quoteName('rating') . ' desc');
			$db->setQuery($query);
			$players = $db->loadAssocList();
			
			$query = $db->getQuery(true)
				->select('date')
				->from($db->quoteName('#__matches'))
				->order($db->quoteName('date') . ' desc');
			$db->setQuery($query);
			$updateDate = $db->loadResult();

			$this->message = array(
				"players" 	=> $this->convertDoBToAgeGroups($players),
				"countries" => $this->generateCountries($players),
				"updateDate" => $updateDate
			);
		}
 
		return $this->message;
	}

	private function convertDoBToAgeGroups($players)
	{
		$now = new DateTime();
		foreach ($players as $i => $p) 
		{
			$ageStr = "";
			if($p["dob"] != "0000-00-00")
			{
				$dob21 = (new DateTime($p["dob"]))->add(new DateInterval('P21Y'));
				$dob45 = (new DateTime($p["dob"]))->add(new DateInterval('P45Y'));
				$dob55 = (new DateTime($p["dob"]))->add(new DateInterval('P55Y'));

				if($now < $dob21)
				{
					$ageStr .= 'U21';
				}
				if($now > $dob45)
				{
					$ageStr .= 'O45';
				}
				if($now > $dob55)
				{
					$ageStr .= 'O55';
				}

			}
			$players[$i]["dob"] = $ageStr;
		}
		return $players;
	}

	private function generateCountries($players)
	{
		require_once("countries.php");

		$countries = array();
		foreach($players as $p)
		{
			$code = $p['country'];
			$countries[$code] = $allCountries[$code];
		}

		asort($countries);
		unset($countries['']);
		return $countries;	
	}
}