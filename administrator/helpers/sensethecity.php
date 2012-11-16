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
 * Sensethecity helper.
 */
class SensethecityHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{

		JSubMenuHelper::addEntry(
			JText::_('COM_SENSETHECITY_TITLE_ITEMS'),
			'index.php?option=com_sensethecity&view=stations',
			$vName == 'stations'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_SENSETHECITY_SUBMENU_CATEGORIES'), 
			'index.php?option=com_categories&view=categories&extension=com_sensethecity', 
			$vName == 'categories'
		);
		JSubMenuHelper::addEntry(
				JText::_('COM_SENSETHECITY_SUBMENU_PHENOMENONS'),
				'index.php?option=com_sensethecity&view=phenomenons',
				$vName == 'phenomenons'
		);		
		JSubMenuHelper::addEntry(
				JText::_('COM_SENSETHECITY_SUBMENU_REPORTS'),
				'index.php?option=com_sensethecity&view=reports',
				$vName == 'reports'
		);
		JSubMenuHelper::addEntry(
				JText::_('COM_SENSETHECITY_SUBMENU_KEYS'),
				'index.php?option=com_sensethecity&view=keys',
				$vName == 'keys'
		);		
				
		// set some global property
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-item {background-image: url(../media/com_sensethecity/images/sensethecity-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-items {background-image: url(../media/com_sensethecity/images/sensethecity-48x48.png);}');
		if ($vName == 'categories') 
		{
			$document->setTitle(JText::_('COM_SENSETHECITY_ADMINISTRATION_CATEGORIES'));
		}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_sensethecity';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
}
