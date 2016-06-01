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

	protected $playerTable = '`#__players`';
	protected $playerColumns = array(
		array('name',			'Player',		'validateName', 		'id'),
		array('dob',			'DoB',			'validateDate', 		'convertDate'),
		array('gender',			'Gender',		'validateGender',		'convertGender'),
		array('country',		'Country',		'validateTrivial',		'convertCountry')
	);

	//			Db name 		CSV name 		validation 				generation
	protected $matchTable = '`#__matches`';
	protected $matchColumns = array(
		array('tournament',	 	'Tournament', 	'validateName', 		'id'),
		array('tour', 			'Tour', 	  	'validateTour', 		'id'),
		array('matchNo', 		'MatchNo', 		'validatePositiveInt',	'id'),
		array('date', 			'Date', 	  	'validateDate', 		'convertDate'),
		array('p1id', 			'P1', 		  	'validateName',			'guaranteedFindPlayerIDByName'),
		array('p2id', 			'P2', 		  	'validateName',			'guaranteedFindPlayerIDByName'),
		array('p2name', 		'P2', 		  	'validateName',			'id'),
		array('p1rating', 		'P1_Rt', 		'validatePositiveInt',	'id'),
		array('p2rating', 		'P2_Rt', 		'validatePositiveInt',	'id'),
		array('p1ratingtt', 	'P1_TT', 		'validatePositiveInt',	'id'),
		array('p2ratingtt', 	'P2_TT', 		'validatePositiveInt',	'id'),
		array('p1ratingbd',	 	'P1_Bd', 		'validatePositiveInt',	'id'),
		array('p2ratingbd',		'P2_Bd', 		'validatePositiveInt',	'id'),
		array('p1ratingsq',		'P1_Sq', 		'validatePositiveInt',	'id'),
		array('p2ratingsq', 	'P2_Sq', 		'validatePositiveInt',	'id'),
		array('p1ratingtn', 	'P1_Tn', 		'validatePositiveInt',	'id'),
		array('p2ratingtn', 	'P1_Tn', 		'validatePositiveInt',	'id'),
		array('tt1', 			'TT1', 			'validatePositiveInt',	'id'),
		array('tt2', 			'TT2', 			'validatePositiveInt',	'id'),
		array('bd1', 			'BD1', 			'validatePositiveInt',	'id'),
		array('bd2', 			'BD2', 			'validatePositiveInt',	'id'),
		array('sq1', 			'SQ1', 			'validatePositiveInt',	'id'),
		array('sq2', 			'SQ2', 			'validatePositiveInt',	'id'),
		array('tn1', 			'TN1', 			'validatePositiveInt',	'id'),
		array('tn2', 			'TN2', 			'validatePositiveInt',	'id'),
		array('tot1', 			'TOT1', 		'validatePositiveInt', 	'id'),
		array('tot2', 			'TOT2', 		'validatePositiveInt', 	'id'),
		array('p1ratingchg', 	'P1_ChgRt', 	'validateInt',			'id'),
		array('p1ratingchgtt', 	'P1_ChgTT', 	'validateInt',			'id'),
		array('p1ratingchgbd', 	'P1_ChgBd', 	'validateInt',			'id'),
		array('p1ratingchgsq',	'P1_ChgSq', 	'validateInt',			'id'),
		array('p1ratingchgtn', 	'P1_ChgTn', 	'validateInt',			'id'),
		array('bonus',			'Bonus',		'validatePositiveInt',	'id')
	);

	protected $db;
	protected $application;
	protected $lineNo;
	protected $commitFrequency = 1000;

	public function submit($t)
	{
		$this->application = JFactory::getApplication();
		$this->db = JFactory::getDbo();

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
						&& $this->calculateCurrentRatings();

					if($success)
					{
						$this->application->enqueueMessage("Rankings successfully updated", "Message");
						$this->db->transactionCommit();
					}
					else
					{
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
		
		$this->application->redirect('/administrator/index.php?option=com_racketlonrankings');
	}

	/**
	*	Read in players from the players file
	**/
	private function process($handle, $table, $metacolumns)
	{
		$header = explode(",", str_replace(' ', '', str_replace(PHP_EOL, '', fgets($handle))));
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

	private function calculateCurrentRatings()
	{
		$query = $this->db->getQuery(true)
			->select($this->db->quoteName(array('id', 'name')))
			->from($this->playerTable);

		$this->db->setQuery($query);
		$people = $this->db->loadRowList();

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
			$id = $p[0];

			$query = $this->db->getQuery(true)
				->select($getColumns)
				->from($this->matchTable)
				->where('p1id = ' . $id)
				->order($this->db->quoteName('date') . ' desc')
				->order($this->db->quoteName('matchNo') . ' desc');

			$this->db->setQuery($query);
			$match = $this->db->loadAssoc();

			if(!is_null($match))
			{
				$rating   = $match['p1rating']   + $match['p1ratingchg'] + $match['bonus'];
				$ratingtt = $match['p1ratingtt'] + $match['p1ratingchgsq'];
				$ratingbd = $match['p1ratingbd'] + $match['p1ratingchgbd'];
				$ratingsq = $match['p1ratingsq'] + $match['p1ratingchgsq'];
				$ratingtn = $match['p1ratingtn'] + $match['p1ratingchgtn'];

				var_dump(array($p[1], $match['p1rating'], $match['p1ratingchg'], $match['bonus'], $rating));
				echo "<br>";

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
					'classtn='  . $this->db->quote($this->calculateClass($ratingtn)),
				);

				$query = $this->db->getQuery(true)
					->update($this->playerTable)
					->set($putColumns)
					->where('id=' . $id);
			}
			else
			{
				$query = $this->db->getQuery(true)
    				->delete($this->playerTable)
    				->where('id=' .$id);

    			$this->application->enqueueMessage("Removed " . $p[1] . " from database as no relevant matches found", "Warning");
			}

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
		if($country == "WAL" || $country == "SCO" || $country == "ENG")
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

	function guaranteedFindPlayerIDByName($name)
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