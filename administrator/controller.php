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
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			$cachable	If true, the view output will be cached
	 * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/sensethecity.php';

		// Load the submenu.
		SensethecityHelper::addSubmenu(JRequest::getCmd('view', 'stations'));
		
		
		$view = JRequest::getCmd('view', 'stations');
		JRequest::setVar('view', $view);
		$viewName = JRequest::getCmd('view', $this->default_view);
		
		switch ($viewName) {
			case "station":
				$document = JFactory::getDocument();
				$viewType = $document->getType();
				$viewLayout = JRequest::getCmd('layout', 'default');
				//$viewLayout = JRequest::getCmd('layout', 'stations');
		
				$view = $this->getView($viewName, $viewType, '', array('base_path' => $this->basePath, 'layout' => $viewLayout));
				
				// Get/Create the model
				$view->setModel($this->getModel('Station'), true);

				$view->setModel($this->getModel('Staphens'));
				
				$view->assignRef('document', $document);
				$view->display();
		
				break;
			default:
				// call parent behavior
				parent::display($cachable, $urlparams);
				break;
		}		
		
		//parent::display();
		//return $this;
	}
}
