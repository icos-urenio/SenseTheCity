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

jimport('joomla.application.component.modelitem');
jimport('joomla.application.component.helper');
jimport('joomla.application.categories');

/**
 * Model
 */
class SensethecityModelIssue extends JModelItem
{
	/**
	 * Model context string.
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $_context = 'com_sensethecity.station';

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication();
		$params	= $app->getParams();

		// Load the object state.
		$id	= JRequest::getInt('station_id');
		$this->setState('sensethecity.id', $id);

		// Load the parameters.
		$this->setState('params', $params);
	}
	

	function &getItem($id = null)
	{
		if (!isset($this->_item))
		{

			if ($this->_item === null) {
				if (empty($id)) {
					$id = $this->getState('sensethecity.id');
				}				

				$db		= $this->getDbo();
				$query	= $db->getQuery(true);
				$query->select(
					'a.*'
					);
				$query->from('#__sensethecity as a');
				$query->where('a.id = ' . (int) $id);

				// Join on catid table.
				$query->select('c.title AS catname');
				$query->join('LEFT', '#__categories AS c on c.id = a.catid');	

				
				$db->setQuery((string) $query);

				if (!$db->query()) {
					JError::raiseError(500, $db->getErrorMsg());
				}

				$this->_item = $db->loadObject();
				
			}
		}
		if ($this->_item != null){
			$this->_item->reported_rel = SensethecityHelper::getRelativeTime($this->_item->reported);
			$this->_item->acknowledged_rel = SensethecityHelper::getRelativeTime($this->_item->acknowledged);
			$this->_item->closed_rel = SensethecityHelper::getRelativeTime($this->_item->closed);
		}
		return $this->_item;
	}	
	
	public function getCategoryIcon($pk = 0)
	{
		$pk = (!empty($pk)) ? $pk : (int) $id = $this->getState('sensethecity.id');
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		$query->select('a.catid');
		$query->from('#__sensethecity as a');
		$query->where('a.id = ' . (int) $id);
		// Join on catid table.
		$query->select('c.params AS params');
		$query->join('LEFT', '#__categories AS c on c.id = a.catid');	
		
		$db->setQuery($query);
		//$result = $db->loadResult();
		$row = $db->loadAssoc();

		$parameters = new JRegistry();
		$parameters->loadJSON($row['params']);
		$image = $parameters->get('image');		

		return $image;
	}
}

