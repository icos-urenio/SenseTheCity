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

jimport('joomla.application.component.modeladmin');


class SensethecityModelStation extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_SENSETHECITY';


	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Station', $prefix = 'SensethecityTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app	= JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm('com_sensethecity.station', 'station', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		
		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_sensethecity.edit.station.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param	integer	The id of the primary key.
	 *
	 * @return	mixed	Object on success, false on failure.
	 * @since	1.6
	 */
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk)) {
			//Do any procesing on fields here if needed
				
			//keep station status to session so before saving to check for changes...
			$session =& JFactory::getSession();
		}
		
		return $item;
	}

	
	/**
	 * Method to get latest battery and temperature measures
	 */
	public function getStationStatus($pk = null)
	{
		$pk = (!empty($pk)) ? $pk : (int) $id = $this->getState('station.id');
		// Create a new query object.
		$db		= $this->getDbo();
		
		$query = '
		SELECT a.*, c.name, c.unit
		FROM `#__sensethecity_observation` AS a
		LEFT JOIN `#__sensethecity_phenomenon` AS c on c.id = a.phenomenon_id
		WHERE a.measurement_datetime = (
		SELECT MAX( b.measurement_datetime ) AS latest
		FROM `#__sensethecity_observation` AS b
		WHERE b.station_id = '.$pk.' ) AND a.station_id = ' . $pk . ' '.
		'ORDER BY c.id';
		
		$db->setQuery($query);
		$result = $db->loadAssocList();
		return $result;		
	
	}

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @since	1.6
	 */
	protected function prepareTable(&$table)
	{
		jimport('joomla.filter.output');

		if (empty($table->id)) {

			// Set ordering to the last item if not set
			if (@$table->ordering === '') {
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__sensethecity');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}

		}

	}
}
