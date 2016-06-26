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

function validateName($value, $column, $er) 
{
	$stripped = preg_replace('/[^A-Za-z0-9\-]/', '', $value);
	if(empty($stripped))
	{
		$er($value, $column, "");
		return false;
	}
	return true;
}

function validateGender($value, $column, $er) 
{
	if($value != "1" && $value != "2")
	{
		$er($value, $column, "must be either '1' or '2'");
		return false;
	}
	return true;
}

function validateInt($value, $column, $er)
{
	if(filter_var($value, FILTER_VALIDATE_INT) === false)
	{
		$er($value, $column, "it must be an integer");
		return false;
	}
	return true;
}

function validateEmptyPositiveInt($value, $column, $er)
{
	if(!empty($value) && (filter_var($value, FILTER_VALIDATE_INT) === false || ((int) $value) < 0))
	{
		$er($value, $column, "it must be an integer");
		return false;
	}
	return true;
}

function validatePositiveInt($value, $column, $er)
{
	if(filter_var($value, FILTER_VALIDATE_INT) === false || ((int) $value) < 0)
	{
		$er($value, $column, "it must be an integer >= 0");
		return false;
	}
	return true;
}

function validateGameScore($value, $column, $er) 
{
	if(filter_var($value, FILTER_VALIDATE_INT) === false || ((int) $value) < 0 || ((int) $value) > 21)
	{
		$er($value, $column, "it must be in the range [0,21]");
		return false;
	}
	return true;
}

function validateMatchScore($value, $column, $er) 
{
	if(filter_var($value, FILTER_VALIDATE_INT) === false || ((int) $value) < 0 || ((int) $value) > 84)
	{
		$er($value, $column, "it must be in the range [0,84]");
		return false;
	}
	return true;
}

function validateTour($tour, $column, $er)
{
	if($tour != "FIR" && $tour != "GBR")
	{
		$er($value, $column, "it must be either 'GBR' or 'FIR'");
		return false;
	}
	return true;
}

function validateDate($value, $column, $er)
{
	if($value !== "" && !DateTime::createFromFormat('m/d/Y', $value))
	{
		$er($value, $column, "dates must be in the format M/D/Y");
		return false;
	}
	return true;
}

function validateTrivial($value, $column, $er)
{
	return true;
}