<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_racketlonrankings
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

require_once("validation.php");

/**
 * General Controller of RacketlonRankings component
 *
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @since       0.0.7
 */
class RacketlonRankingsController extends JControllerLegacy
{
	/**
	 * The default view for the display method.
	 *
	 * @var string
	 * @since 12.2
	 */
	protected $default_view = 'dataupload';

	protected $rankingsConfigTable = '`#__rankings_config`';

	protected $playerTable = '`#__players`';
	protected $playerColumns = array(
		array('name',			'Player',		'validateName', 			'id'),
		array('dob',			'DoB',			'validateDate', 			'convertDate'),
		array('gender',			'Gender',		'validateGender',			'convertGender'),
		array('country',		'Country',		'validateTrivial',			'convertCountry'),
		array('firdate',		'FIRDate',		'validateDate',				'convertDate'),
		array('gbrdate',		'GBRDate',		'validateDate',				'convertDate'),
		array('matches',		'Matches',		'validateEmptyPositiveInt',	'id')
	);

	//			Db name 		CSV name 		validation 					generation
	protected $matchTable = '`#__matches`';
	protected $matchColumns = array(
		array('tournament',	 	'Tournament', 	'validateName', 			'id'),
		array('tour', 			'Tour', 	  	'validateTour', 			'id'),
		array('matchNo', 		'MatchNo', 		'validatePositiveInt',		'id'),
		array('date', 			'Date', 	  	'validateDate', 			'convertDate'),
		array('p1id', 			'P1', 		  	'validateName',				'guaranteedFindPlayerIDByName'),
		array('p2id', 			'P2', 		  	'validateName',				'guaranteedFindPlayerIDByName'),
		array('p2name', 		'P2', 		  	'validateName',				'id'),
		array('p1rating', 		'P1_Rt', 		'validatePositiveInt',		'id'),
		array('p2rating', 		'P2_Rt', 		'validatePositiveInt',		'id'),
		array('p1ratingtt', 	'P1_TT', 		'validatePositiveInt',		'id'),
		array('p2ratingtt', 	'P2_TT', 		'validatePositiveInt',		'id'),
		array('p1ratingbd',	 	'P1_Bd', 		'validatePositiveInt',		'id'),
		array('p2ratingbd',		'P2_Bd', 		'validatePositiveInt',		'id'),
		array('p1ratingsq',		'P1_Sq', 		'validatePositiveInt',		'id'),
		array('p2ratingsq', 	'P2_Sq', 		'validatePositiveInt',		'id'),
		array('p1ratingtn', 	'P1_Tn', 		'validatePositiveInt',		'id'),
		array('p2ratingtn', 	'P1_Tn', 		'validatePositiveInt',		'id'),
		array('tt1', 			'TT1', 			'validatePositiveInt',		'id'),
		array('tt2', 			'TT2', 			'validatePositiveInt',		'id'),
		array('bd1', 			'BD1', 			'validatePositiveInt',		'id'),
		array('bd2', 			'BD2', 			'validatePositiveInt',		'id'),
		array('sq1', 			'SQ1', 			'validatePositiveInt',		'id'),
		array('sq2', 			'SQ2', 			'validatePositiveInt',		'id'),
		array('tn1', 			'TN1', 			'validatePositiveInt',		'id'),
		array('tn2', 			'TN2', 			'validatePositiveInt',		'id'),
		array('tot1', 			'TOT1', 		'validatePositiveInt', 		'id'),
		array('tot2', 			'TOT2', 		'validatePositiveInt', 		'id'),
		array('p1ratingchg', 	'P1_ChgRt', 	'validateInt',				'id'),
		array('p1ratingchgtt', 	'P1_ChgTT', 	'validateInt',				'id'),
		array('p1ratingchgbd', 	'P1_ChgBd', 	'validateInt',				'id'),
		array('p1ratingchgsq',	'P1_ChgSq', 	'validateInt',				'id'),
		array('p1ratingchgtn', 	'P1_ChgTn', 	'validateInt',				'id'),
		array('bonus',			'Bonus',		'validatePositiveInt',		'id')
	);

	protected $db;
	protected $application;
	protected $lineNo;
	protected $commitFrequency = 1000;

	public function submit($t=null)
	{
		$this->application = JFactory::getApplication();
		$this->db = JFactory::getDbo();

		if($this->isUpdating())
		{
			$this->application->enqueueMessage("Someone else is currently updating the rankings. Please wait a while and try again", "Error");
		}
		else
		{
			$this->setUpdating('1');

			$files = $_FILES['jform'];
			if($files['error']['players'] || $files['error']['matches']) 
			{
				if($files['error']['players'])
				{
					$this->application->enqueueMessage("Missing players file", "Error");
				}
				if($files['error']['matches'])
				{
					$this->application->enqueueMessage("Missing matches file", "Error");
				}
			}
			else
			{
				$playersHandle = fopen($files["tmp_name"]["players"], "r");
				$matchesHandle = fopen($files["tmp_name"]["matches"], "r");

				if(!$playersHandle || !$matchesHandle)
				{
					if($playersHandle)
					{
						$this->application->enqueueMessage("Could not open file " + $files['name']['players'], "Error");
					}
					if($matchesHandle)
					{
						$this->application->enqueueMessage("Could not open file " + $files['name']['matches'], "Error");
					}
				}
				else
				{
					try
					{
						$this->db->transactionStart();

						$success = $this->process($playersHandle, $this->playerTable, $this->playerColumns)
							&& $this->process($matchesHandle, $this->matchTable,  $this->matchColumns)
							&& $this->playerPostProcessing();

						if($success)
						{
							$this->application->enqueueMessage("Rankings successfully updated", "Message");
							$this->db->transactionCommit();
						}
						else
						{
							var_dump("Rolling back");
							$this->db->transactionRollback();
						}	
					}
					catch(Exception $e)
					{
						$this->db->transactionRollback();
						$this->application->enqueueMessage($e, "Error");
					}
				}
			}

			$this->setUpdating('0');
		}
		
		$this->application->redirect('/administrator/index.php?option=com_racketlonrankings');
	}

	/**
	*	Read in players from the players file
	**/
	private function process($handle, $table, $metacolumns)
	{
		$allHeader = fgets($handle);
		$header = array_map('trim', explode(",", str_replace(PHP_EOL, '', $allHeader)));
		if(!$this->validateHeader($header, $metacolumns, "players"))
		{
			return false;
		}

		$this->deleteAll($table);

		$columns = $this->db->quoteName(array_column($metacolumns, 0));

		$query = $this->db->getQuery(true)
			->insert($table)
	    	->columns($columns);

		$valid = true;
		$this->lineNo = 2;
		while (($line = fgets($handle)) !== false) 
	    {
	    	if($valid && $this->lineNo % $this->commitFrequency == 0)
	    	{
	    		
	    		$this->db->setQuery($query);
	    		$this->db->execute();
				

	    		$query = $this->db->getQuery(true)
					->insert($table)
	    			->columns($columns);
	    	}

	    	$values = explode(",",str_replace(PHP_EOL, '', $line));
	    	$fields = array();

	    	foreach($metacolumns as $c)
	    	{
	    		$key = array_search($c[1], $header);
	    		$value = trim($values[$key]);
	    		$valid &= $c[2]($value, $c[1], [$this, 'er']);
	    		$fields[] = $this->call([$this, $c[3]] , $value);
	    	}

	    	if($valid)
	    	{
	    		$fields = implode(",", $this->db->quote($fields));
	    		$query = $query->values($fields);
	    	}

	    	$this->lineNo += 1;
	    }
	    fclose($handle);

	    if($valid)
	    {
	    	$this->db->setQuery($query);
	    	$this->db->execute();
	    }
	    
	    return $valid;
	}


	private function deleteAll($table)
	{
		$query = $this->db->getQuery(true)
    		->delete($table);

    	$this->db->setQuery($query);
		$this->db->execute();

		$query = $this->db->getQuery(true)
			->setQuery('ALTER TABLE ' . $table . ' AUTO_INCREMENT = 1');

		$this->db->setQuery($query);
		$this->db->execute();
	}

	private function playerPostProcessing()
	{
		$query = $this->db->getQuery(true)
			->select('*')
			->from($this->playerTable);
		$this->db->setQuery($query);
		$people = $this->db->loadAssocList();

		$query = $this->db->getQuery(true)
			->select('date')
			->from($this->db->quoteName('#__matches'))
			->order($this->db->quoteName('date') . ' desc');
		$this->db->setQuery($query);
		$updateDate = new DateTime($this->db->loadResult());

		$getColumns = $this->db->quoteName(array(
			'p1id',
			'date',
			'matchNo',
			'p1rating',
			'p1ratingtt',
			'p1ratingbd',
			'p1ratingsq',
			'p1ratingtn',
			'p1ratingchg',
			'p1ratingchgtt',
			'p1ratingchgbd',
			'p1ratingchgsq',
			'p1ratingchgtn',
			'bonus'
		));

		foreach($people as $p)
		{
			$query = $this->db->getQuery(true)
				->select($getColumns)
				->from($this->matchTable)
				->where('p1id = ' . $p['id'])
				->order($this->db->quoteName('date') . ' desc')
				->order($this->db->quoteName('matchNo') . ' desc');
			$this->db->setQuery($query);
			$match = $this->db->loadAssoc();

			if(!is_null($match))
			{
				$rating   = $match['p1rating']   + $match['p1ratingchg'] + $match['bonus'];
				$ratingtt = $match['p1ratingtt'] + $match['p1ratingchgtt'];
				$ratingbd = $match['p1ratingbd'] + $match['p1ratingchgbd'];
				$ratingsq = $match['p1ratingsq'] + $match['p1ratingchgsq'];
				$ratingtn = $match['p1ratingtn'] + $match['p1ratingchgtn'];

				$putColumns = array(
					'rating='   . $this->db->quote($rating),
					'ratingtt=' . $this->db->quote($ratingtt),
					'ratingbd=' . $this->db->quote($ratingbd),
					'ratingsq=' . $this->db->quote($ratingsq),
					'ratingtn=' . $this->db->quote($ratingtn),
					'class='    . $this->db->quote($this->calculateClass($rating)),
					'classtt='  . $this->db->quote($this->calculateClass($ratingtt)),
					'classbd='  . $this->db->quote($this->calculateClass($ratingbd)),
					'classsq='  . $this->db->quote($this->calculateClass($ratingsq)),
					'classtn='  . $this->db->quote($this->calculateClass($ratingtn))
				);

				$query = $this->db->getQuery(true)
					->update($this->playerTable)
					->set($putColumns)
					->where('id=' . $p['id']);
			}
			else
			{
				$query = $this->db->getQuery(true)
    				->delete($this->playerTable)
    				->where('id=' .$p['id']);

    			$this->application->enqueueMessage("Removed " . $p['name'] . " from database as they have not played in any matches.", "Warning");
			}
			$this->db->setQuery($query);
			$this->db->execute();


			$active = (int)($this->isActive($p, $updateDate));

			// Active status
			$query = $this->db->getQuery(true)
				->update($this->playerTable)
				->set('active=' . $active)
				->where('id=' . $p['id']);
			$this->db->setQuery($query);
			$this->db->execute();
		}

		return true;
	}

	private function calculateClass($rating)
	{
		if($rating < 10000)
		{
			return "??";
		}
		
		if($rating < 12000)
		{
			return "D" . ceil((12000 - $rating)/500);
		}
		
		if($rating < 14000)
		{
			return "C" . ceil((14000 - $rating)/500);
		}
		
		if($rating < 16000)
		{
			return "B" . ceil((16000 - $rating)/500);
		}
		
		if($rating < 18000)
		{
			return "A" . ceil((18000 - $rating)/500);
		}
		
		if($rating < 20000)
		{
			return ceil((20000 - $rating)/500) . "+";
		}
		
		return '0+';
	}

	/****************/
	/** Generation **/
	/****************/
	
	function call($f , $v)
	{
		return $f($v);
	}

	function tr($v)
	{
		return '1';
	}

	function id($v)
	{
		return $v;
	}

	function convertDate($date)
	{
		return $date == "" ? "" : DateTime::createFromFormat('m/d/Y', $date)->format('Y-m-d');
	}

	function convertGender($gender)
	{
		return $gender - 1;
	}

	function convertCountry($country)
	{
		if(empty($country))
		{
			return "GBR";
		}
		return $country;
	}


	function findPlayerIDByName($name)
	{
		$query = $this->db->getQuery(true)
			->select($this->db->quoteName('id'))
			->from($this->playerTable)
			->where('name = ' . $this->db->quote($name));

		$this->db->setQuery($query);
		return $this->db->loadResult();
	}

	private function guaranteedFindPlayerIDByName($name)
	{
		$id = $this->findPlayerIDByName($name);

		if(is_null($id))
		{
			$values = implode(",", $this->db->quote(array($name)));
			$query = $this->db->getQuery(true)
				->insert($this->db->quoteName('#__players'))
				->columns($this->db->quoteName(array('name')))
				->values($values);

			$this->db->setQuery($query);
			$this->db->execute();

			$id = $this->findPlayerIDByName($name);
		}

		return $id;
	}

	private function isActive($player, $updateDate)
	{
		if($player['matches'] < 5)
		{
			return false;
		}

		if(in_array($player['country'], ['SCO', 'WAL', 'IMN', 'NIR', 'ENG', 'GBR']))
		{
			if($player['gbrdate'] != "0000-00-00")
			{
				$gbrDays = intval((new DateTime($player['gbrdate']))->diff($updateDate)->format('%a'));
			}
		}

		if($player['firdate'] != "0000-00-00")
		{
			$firDays = intval((new DateTime($player['firdate']))->diff($updateDate)->format('%a'));
		}

		return (isset($gbrDays) && $gbrDays <= 270) || (isset($firDays) && $firDays <= 270);
	}

	private function isUpdating()
	{
		$query = $this->db->getQuery(true)
			->select($this->db->quoteName('value'))
			->where($this->db->quoteName('property') . ' = ' . $this->db->quote('updating'))
			->from($this->rankingsConfigTable);
		$this->db->setQuery($query);
		return $this->db->loadResult();
	}

	private function setUpdating($value)
	{
		$query = $this->db->getQuery(true)
			->update($this->rankingsConfigTable)
			->set($this->db->quoteName('value') . ' = ' . $this->db->quote($value))
			->where($this->db->quoteName('property') . ' = ' . $this->db->quote('updating'));
		$this->db->setQuery($query);
		$this->db->execute();
	}

	/****************/
	/** Validation **/
	/****************/

	private function validateHeader($header, $columns, $name)
	{
		$valid = true;
		foreach($columns as $c)
		{
			if(array_search($c[1], $header) === false)
			{
				$this->application->enqueueMessage("Could not find column '" . $c[1] . "' in the header of the " . $name . " file", "Error");
				$valid = false;
			}
		}
		return $valid;
	}

	public function er($name, $column, $extra)
	{
		$this->application->enqueueMessage("Line " . $this->lineNo . " has an invalid value '" . $name . "' for the column " . $column . (empty($extra) ? " " : " - " . $extra), "Error");
	}
}