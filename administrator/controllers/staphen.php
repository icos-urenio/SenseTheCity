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
    	$this->view_list = 'station';
        
    	parent::__construct();
    }
    
    public function edit()
    {
        if (parent::edit()) {
    		$app = JFactory::getApplication();
    		$context = "$this->option.edit.$this->context";
    			
    		$app->setUserState($context . '.station_id', JRequest::getCmd('station_id'));
    		$app->setUserState($context . '.phenomenon_id', JRequest::getCmd('phenomenon_id'));
    			
    		return true;
    	}
    	
    }
    
    public function calibrateValues()
    {
    	JRequest::checkToken() or jexit('Invalid Token');
    	
    	$app = JFactory::getApplication();
    	$context = "$this->option.edit.$this->context";
    	
		$station_id = $app->getUserState($context . '.station_id');
		$phen_id = $app->getUserState($context . '.phenomenon_id');
		$dateFrom = JRequest::getVar('datefrom');
		$dateTo = JRequest::getVar('dateto');
		$id = JRequest::getInt('id');	//needed only for proper redirection
		$a = JRequest::getCmd('a');	
		$b = JRequest::getCmd('b');	

		//call the model
    	$model = $this->getModel('staphen');
    	if(empty($dateFrom))
    		$res = $model->calibrateValuesInRange($station_id, $phen_id, $a, $b, $dateTo);
    	else    	
    		$res = $model->calibrateValuesInRange($station_id, $phen_id, $a, $b, $dateTo, $dateFrom);
    	
    	//set an appropriate msg
    	JFactory::getApplication()->enqueueMessage('Rows affected: '. $res);

    	//redirect back to edit page
    	$this->setRedirect(
    			JRoute::_(
    					'index.php?option=' . $this->option 
    					. '&view=staphen' 
    					. '&layout=edit'
    					. '&id=' . $id 
    					, false
    			)
    	);
    	
    	return true;
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
    		$context = "$this->option.edit.$this->context";	//com_sensethecity.edit.staphen
    
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
