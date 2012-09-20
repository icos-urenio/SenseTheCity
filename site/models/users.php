<?php
/**
 * @version     1.0.0
 * @package     com_sensethecity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the Information Technologies Institute (CERTH/ITI)
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Model
 */
class SensethecityModelUsers extends JModel
{
	
	function authenticateUser($username, $password)
	{

		$response = array();
		
		// Joomla does not like blank passwords
		if (empty($password)) {
			$response['error_message'] = JText::_('JGLOBAL_AUTH_EMPTY_PASS_NOT_ALLOWED');
			return $response;
		}
		
		// Get a database object
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('id, password');
		$query->from('#__users');
		$query->where('username=' . $db->Quote($username));
		
		$db->setQuery($query);
		$result = $db->loadObject();
		
		if ($result) {
			$parts	= explode(':', $result->password);
			$crypt	= $parts[0];
			$salt	= @$parts[1];
			$testcrypt = JUserHelper::getCryptedPassword($password, $salt);
		
			if ($crypt == $testcrypt) {
				$user = JUser::getInstance($result->id); // Bring this in line with the rest of the system
				$response['id'] = $user->id;
				$response['email'] = $user->email;
				$response['fullname'] = $user->name;
				if (JFactory::getApplication()->isAdmin()) {
					$response['language'] = $user->getParam('admin_language');
				}
				else {
					$response['language'] = $user->getParam('language');
				}
				$response['error_message'] = '';
			} else {
				$response['error_message'] = JText::_('JGLOBAL_AUTH_INVALID_PASS');
			}
		} else {
			$response['error_message'] = JText::_('JGLOBAL_AUTH_NO_USER');
		}
		return $response;
	}
}
