<?php
/**
 * @version     1.0.0
 * @package     com_sensethecity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the Information Technologies Institute (CERTH/ITI)
 * 
 * **** WARNING *****
 * DURING JSON REQUESTS, USERNAME AND PASSWORD ALTHOUGH TRANSMITTED ENCRYPTED, MIGHT BE STOLEN BY SNIFFERS AND USED AS IS. 
 * FOR MAXIMUM PROTECTION YOU ARE ADVISED TO USE THIS CONTROLLER ON SSL (HTTPS) SERVERS ONLY.
 * THIS CONTROLLER IS DISABLED BY DEFAULT. YOU CAN ENABLE IT ON COMPONENT'S SETTINGS UNDER THE 'ADVANCED' TAB
 * YOU SHOULD ALWAYS SEND PASSWORD DECRYPTED LIKE THIS:
	
	-- HOW TO ENCRYPT THE PASSWORD BEFORE CALLING THE MOBILE.JSON CONTROLLER
	$key = 'secret key'; //the secret key as set on component's menu "API KEY" (Keys on client and server should MATCH )
	Follow the instructions on: http://www.androidsnippets.com/encrypt-decrypt-between-android-and-php
	Important: Key length must be 16 characters
	--
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.controller');

class SensethecityControllerMobile extends JController
{
	private $enablejsoncontroller = 0;
	private $key = null;
	function __construct()
	{
		// Load the parameters.
		$app = JFactory::getApplication();
		$params	= $app->getParams();
		$this->enablejsoncontroller = $params->get('enablejsoncontroller');
		if(!$this->enablejsoncontroller)
			die('CONTROLLER MOBILE.JSON IS DISABLED');		
		parent::__construct();

		//populate key from DB
		$model = $this->getModel('keys');
		$key = $model->getSecretKey();
		$this->key = $key;
		
	}
	
	
	/* arguments: 
	 * limit=0 : get ALL stations, limit=5 get recent 5 stationss
	 * showComments=1: includes station's discussion, showComments=0 (default) discussion is not included
	 * x0up: longitude < x0up
	 * x0down: longitude > x0down
	 * y0up: latitude < y0up
	 * y0down: latitude > y0down
	 * */
	public function getStations()
	{
		//get boundaries
		$x0up 	= JRequest::getFloat('x0up');		
		$x0down	= JRequest::getFloat('x0down');
		$y0up 	= JRequest::getFloat('y0up');
		$y0down	= JRequest::getFloat('y0down');		
		
		//get model and items
		$items = array();
		if( !empty($x0up) && !empty($x0down) && !empty($y0up) && !empty($y0down)){
			$model = $this->getModel('stations');
			$items	= $model->getItemsInBoundaries($x0up, $x0down, $y0up, $y0down);
		}
		else {
			$model = $this->getModel('stations');
			$items	= $model->getItems();
		}
				
		//clean up and prepare for json
		foreach($items as $item){
			unset($item->params);
		}

		echo json_encode($items);
		return;
	}	
	
	/* arguments:
	 * stationId=X : get station with ID = X
	* */	
	public function getStation()
	{
		//get request
		$stationId = JRequest::getInt('stationId');
	
		//get model and items
		$model = $this->getModel('station');

		$item = $model->getItem($stationId);
		if($item == null){			
			echo json_encode('StationId: ' .$stationId.' not found');
			return;
		}
		
		//clean up and prepare for json
		unset($item->params);

		echo json_encode($item);
		return;
	}	
	
	private function authenticate($username, $encrypted_password)
	{
		$code = "";
		for ($i = 0; $i < strlen($encrypted_password); $i += 2) {
			$code .= chr(hexdec(substr($encrypted_password, $i, 2)));
		}
		
		$iv = $this->key; //Initialization vector same as key
		$key= $this->key;
		
		$td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
		mcrypt_generic_init($td, $key, $iv);
		$decrypted_password = mdecrypt_generic($td, $code);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		$decrypted_password = utf8_encode(trim($decrypted_password ));
				
		//get model
		$model = $this->getModel('users');
		$response = $model->authenticateUser($username, $decrypted_password);
		return $response;
	}
}
