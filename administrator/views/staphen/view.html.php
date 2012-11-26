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

jimport('joomla.application.component.view');

/**
 * View to edit
 */
class SensethecityViewStaphen extends JView
{
	
	function display($tpl = null)
	{
		// Get data from the model
		$item = $this->get( 'Item' );
		$form = $this->get( 'Form' );
		$isNew = ($item->id < 1);
	
		// Disable main menu
		JRequest::setVar('hidemainmenu', true);
		// Toolbar
		if ($isNew) {
			JToolBarHelper::title( JText::_( 'COM_SENSETHECITY_STA_PHEN_NEW' ), 'item.png' );
		} else {
			JToolBarHelper::title( JText::_( 'COM_SENSETHECITY_STA_PHEN_EDIT' ), 'item.png' );
		}
		JToolBarHelper::apply('staphen.apply');
		JToolBarHelper::save('staphen.save');
		//JToolBarHelper::save2new('staphen.save2new');
		JToolBarHelper::cancel('staphen.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
		 
		$this->item = $item;
		$this->form = $form;
	
		parent::display($tpl);
		 
		$document = JFactory::getDocument();
		$document->addScript(JURI::root() .
				'/administrator/components/com_sensethecity/models/forms/validation.js');
		JText::script('COM_REGISTRY_VALIDATION_ERROR');
	}	

}
