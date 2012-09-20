<?php
/**
 * @version     1.0.0
 * @package     com_sensethecity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the Information Technologies Institute (CERTH/ITI)
 */

defined('_JEXEC') or die;

// require helper file
JLoader::register('SensethecityHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'sensethecity.php');
 
// Include dependancies
jimport('joomla.application.component.controller');

// Execute the task.
$controller	= JController::getInstance('Sensethecity');
$controller->execute(JRequest::getVar('task'));
$controller->redirect();
