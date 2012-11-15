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
	
	/* BELOW FUNCTIONS NEED valid username and encrypted_password */
	
	public function insertMeasurements()
	{
		$username = JRequest::getVar('username');
		$password = JRequest::getVar('password');
		//Check authentication
		$auth = $this->authenticate($username, $password);
		if(!empty($auth['error_message'])){
			echo json_encode("Authentication failed");
			return;
		}
		$username = JRequest::getVar('username');
		
		//$measurements = JRequest::getVar('measurements');
		$measurements = file_get_contents('php://input');
		
		//get model
		$model = $this->getModel('measurements');
		$ret = $model->insertMeasurements($measurements);
		echo json_encode($ret); //return the number of errors (0 if none)
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
