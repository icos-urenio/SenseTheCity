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

jimport('joomla.application.component.controller');

class SensethecityController extends JController
{

	public function display($cachable = false, $urlparams = false)
	{
		
		$view = JRequest::getCmd('view', 'stations');
		JRequest::setVar('view', $view);
		$v = & $this->getView($view, 'html');
		$v->setModel($this->getModel($view), true); //the default model (true) :: $view is either stations or station
		$v->display();

		return $this; 
	}
	
	/**
	* only called async from ajax as format=raw from ajax
	*/	
	function getMarkersAsXML()
	{
		JRequest::checkToken('get') or jexit('Invalid Token');
		$v = & $this->getView('stations', 'raw');
		$v->setModel($this->getModel('stations'), true);
		$v->display(); 
	}

	/**
	* only called async from ajax as format=raw from ajax
	*/	
	function getMarkerAsXML()
	{
		//JRequest::checkToken() or jexit('Invalid Token'); //for write
		JRequest::checkToken('get') or jexit('Invalid Token');	//for read
		
		$v = & $this->getView('station', 'raw');
		$v->setModel($this->getModel('station'), true);
		$v->display();
	}	
	

	function printStation()
	{
		$v = & $this->getView('station', 'print');		//view.print.php
		$v->setModel($this->getModel('station'), true);	//load station model
		$v->display('print');							//template set to tmpl/default_print.php
	}
	
	/* 
		model loads and inside view.print.php all stations without paging
		are loaded.
	*/
	function printStations()
	{
		$v = & $this->getView('stations', 'print');			//view.print.php
		$v->setModel($this->getModel('stations'), true);	//load stations model
		$v->display('print');								//template set to tmpl/default_print.php
	}
	
	
}
