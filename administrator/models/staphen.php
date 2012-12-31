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


class SensethecityModelStaphen extends JModelAdmin
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
	public function getTable($type = 'Staphen', $prefix = 'SensethecityTable', $config = array())
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
		$form = $this->loadForm('com_sensethecity.staphen', 'staphen', array('control' => 'jform', 'load_data' => $loadData));
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
		$data = JFactory::getApplication()->getUserState('com_sensethecity.edit.staphen.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		
		// Set value for the person_id (insert)
		
		if (!$data->station_id)
		{
			$app = JFactory::getApplication();
			$context = "$this->option.edit.task";
				
			$data->station_id = $app->getUserState($context . '.station_id');
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
				$db->setQuery('SELECT MAX(ordering) FROM #__sensethecity_sta_phen');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}

		}
		
		$table->b = ($table->y2*$table->x1-$table->x2*$table->y1)/($table->x1-$table->x2);
		$table->a = ($table->y1-$table->b)/$table->x1;
	}
	
	public function calibrateValuesInRange($station_id, $phen_id, $a, $b, $dateTo, $dateFrom = '2000-01-01 00:00:00')
	{
		
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
	
		//corrected_value = (numeric_value - b)/a
		$query->update('`#__sensethecity_observation` AS a');
		$query->set('a.corrected_value = (a.numeric_value - '.$b.') / '. $a);
		$query->where('a.station_id = '.$station_id);
		$query->where('a.phenomenon_id = '.$phen_id);
		$query->where("a.timestamp >= '".$dateFrom."'");
		$query->where("a.timestamp <= '".$dateTo."'");
		$db->setQuery($query);
		$res = $db->query();
		
		if($res)
			return $db->getAffectedRows($res);
		
		return false;		
		
	}
}
