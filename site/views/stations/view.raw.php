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
 * Raw View class for the Sensethecity component
 */
class SensethecityViewStations extends JView
{
	protected $items;

	function display($tpl = null)
	{
		// Get some data from the models
		$this->items	= $this->get('Items');
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
        //parent::display($tpl);
		$this->getMarkersAsXML();
	}	

	protected function getMarkersAsXML()
	{
		JRequest::checkToken('get') or jexit('Invalid Token');

		$dom = new DOMDocument('1.0', 'UTF-8');
		$node = $dom->createElement("markers2");
		$parnode = $dom->appendChild($node); 		
		
		$document = &JFactory::getDocument();
		$document->setMimeEncoding('text/xml');
		foreach($this->items as $item){
			$node = $dom->createElement("marker");  
			$newnode = $parnode->appendChild($node);   
			$newnode->setAttribute("name",$item->title);
			$newnode->setAttribute("description", $item->description);  
			$newnode->setAttribute("lat", $item->latitude);  
			$newnode->setAttribute("lng", $item->longitude);  
			$newnode->setAttribute("catid", $item->catid);
			$newnode->setAttribute("id", $item->id);
		}		
		echo $dom->saveXML();
	}
	

}
