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
class SensethecityModelKeys extends JModel
{
	
	function getSecretKey()
	{
		
		// Get a database object
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('skey');
		$query->from('#__sensethecity_keys');
		$query->where('id=1');
		
		$db->setQuery($query);
		$result = $db->loadResult();
		return $result;
	}
}
