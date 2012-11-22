<?php
/**
 * @version     1.0.0
 * @package     com_sensethecity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the Information Technologies Institute (CERTH/ITI)
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Issues list controller class.
 */
class SensethecityControllerStaphens extends JControllerAdmin
{
	
	public function __construct($config = array())
	{
		$this->view_list = 'staphen';
	
		parent::__construct($config);
	}
		
		
	/**
	* Set default values when no action is specified (ie for cancel)
	*/
	public function &getModel($name = 'staphen', $prefix = 'SensethecityModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
	
	
	public function delete()
	{
		parent::delete();
	
		$app = JFactory::getApplication();
		$context = "$this->option.edit.task";
	
		$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list
				. '&layout=edit'
				. '&id=' . $app->getUserState($context . '.station_id'), false));
	}	
	
}
