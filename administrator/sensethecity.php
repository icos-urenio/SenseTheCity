<?php
/**
 * @version     1.0.0
 * @package     com_sensethecity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the Information Technologies Institute (CERTH/ITI)
 */


// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_sensethecity')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// require helper file
JLoader::register('SensethecityHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'sensethecity.php');

// Include dependancies
jimport('joomla.application.component.controller');

$controller	= JController::getInstance('Sensethecity');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
