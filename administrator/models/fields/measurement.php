<?php
/**
 * @version     1.0.0
 * @package     com_sensethecity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the Information Technologies Institute (CERTH/ITI)
 */
 
defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldMeasurement extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Measurement';

	public function getLabel() {
		return '<span style="text-decoration: underline;">' . parent::getLabel() . '</span>';
	}	
	
	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		// Initialize variables.
		//$html = array();
		//return implode($html);
		$db =& JFactory::getDBO();
		$query	= $db->getQuery(true);
		
		$query->select('b.id AS id, b.name AS name, b.unit AS unit');
		$query->from('#__sensethecity_phenomenon AS b');
		$db->setQuery($query);
		$result = $db->loadAssocList();		
		
		$html = '<select id="'.$this->id.'" name="'.$this->name.'">';
		
		$id = JRequest::getCmd('id');
		
		
		foreach($result as $res){
			if ($res['id'] == $this->value)
				$html .= '<option selected="selected" value="'.$res['id'].'" >'.$res['name'].' ('. $res['unit'] .') ' . '</option>';
			else 
				$html .= '<option value="'.$res['id'].'" >'.$res['name'].' ('. $res['unit'] .') ' . '</option>';
		}
		$html .='</select>';		
		
		return $html;
		
	}
	/*
	public function getInput()
	{
		$options = array(
				'08:00:00' => '8:00 AM',
				'09:30:00' => '9:30 AM'
		);
	
		return JHtml::_('select.genericlist', $options, $this->name, null, 'value', 'text', $this->value, $this->id);
	}
	*/	
}
