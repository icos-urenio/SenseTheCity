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

jimport('joomla.application.component.controllerform');

/**
 * Issue controller class.
 */
class SensethecityControllerStaphen extends JControllerForm
{

    function __construct() {
        //$this->view_list = 'staphens';
    	$this->view_list = 'staphen';
        parent::__construct();
    }
    
    public function add()
    {
    	if (parent::add()) {
    		$app = JFactory::getApplication();
    		$context = "$this->option.edit.$this->context";
    			
    		$app->setUserState($context . '.station_id', JRequest::getCmd('station_id'));
    			
    		return true;
    	}
    }
    
    
    public function cancel($key = null)
    {
    	if (parent::cancel($key)) {
    		// Set right layout
    		$app = JFactory::getApplication();
    		$context = "$this->option.edit.$this->context";
    
    		$this->setRedirect(
    				JRoute::_(
    						'index.php?option=' . $this->option . '&view=' . $this->view_list
    						. '&layout=edit'
    						. '&id=' . $app->getUserState($context . '.station_id')
    						. $this->getRedirectToListAppend(), false
    				)
    		);
    
    		return true;
    	}
    
    	return false;
    }
    
    
    public function save($key = null, $urlVar = null)
    {
    	if (parent::save($key, $urlVar)) {
    		$task = $this->getTask();
    
    		if ($task == 'save')
    		{
    			// Add the master pk and the right layout
    			$app = JFactory::getApplication();
    			$context = "$this->option.edit.$this->context";
    
    			$this->setRedirect(
    					JRoute::_(
    							'index.php?option=' . $this->option . '&view=' . $this->view_list
    							. '&layout=edit'
    							. '&id=' . $app->getUserState($context . '.station_id')
    							. $this->getRedirectToListAppend(), false
    					)
    			);
    		}
    
    		return true;
    	}
    
    	return false;
    }    

}