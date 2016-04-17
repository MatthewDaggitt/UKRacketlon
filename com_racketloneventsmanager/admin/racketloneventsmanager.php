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
 
 // Set some global property
$document = JFactory::getDocument();
$document->addStyleDeclaration('.icon-racketloneventsmanager {background-image: url(../media/com_racketloneventsmanager/images/racketlon.gif);}');

// Get an instance of the controller prefixed by RacketlonEventsManager
$controller = JControllerLegacy::getInstance('RacketlonEventsManager');
 
// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));
 
// Redirect if set by the controller
$controller->redirect();