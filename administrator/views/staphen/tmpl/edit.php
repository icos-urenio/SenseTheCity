<?php
/**
 * @version     1.0.0
 * @package     com_sensethecity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the Information Technologies Institute (CERTH/ITI)
 */

// no direct access
defined('_JEXEC') or die;

$option = JRequest::getCmd('option');

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

//jimport( 'joomla.form.form' );
//$params = $this->form->getFieldsets('params');


$station_id = JRequest::getInt('station_id');
$phen_id = JRequest::getInt('phenomenon_id');

?>

<?php /*
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		
		if (task == 'statphen.cancel' || document.formvalidator.isValid(document.id('station-admin-form'))) {
			Joomla.submitform(task, document.getElementById('station-admin-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>
*/?>

<form action="index.php" method="post" name="adminForm" id="station-admin-form" class="form-validate">
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="station_id" value="<?php echo $station_id; ?>" />
	<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
	<?php echo JHtml::_('form.token'); ?>
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_SENSETHECITY_STA_PHEN_DETAILS' ); ?></legend>
			<ul class="adminformlist">
				<?	foreach ($this->form->getFieldset() as $field) { ?>
				<li><?php echo $field->label; ?><?php echo $field->input; ?></li>
				<?	} ?>
			</ul>
		</fieldset>
	</div>
</form>

	<div class="width-40 fltrt">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_SENSETHECITY_UPDATE_CALIBRATION' ); ?></legend>
				<form action="index.php?option=com_sensethecity&task=staphen.calibrateValues" method="post" name="calibrate" id="calibrate-form">
					<!-- 
					<input type="hidden" name="station_id" value="<?php echo $station_id; ?>" />
					<input type="hidden" name="phen_id" value="<?php echo $this->item->id; ?>" />
					 -->
					 
					<input type="hidden" name="id" value="<?php echo JRequest::getInt('id'); ?>" /> 
					<input type="hidden" name="a" value="<?php echo $this->item->a; ?>" /> 
					<input type="hidden" name="b" value="<?php echo $this->item->b; ?>" /> 
					 
					<label for="datefrom">Update Values FROM Date:</label>
					<input type="text" id="datefrom" name="datefrom" class="inputbox" />
					<label for="dateto">Update Values TO Date:</label>
					<input type="text" id="dateto" name="dateto" class="inputbox" value="<?php echo date("Y-m-d H:i:s");?>" />
					<div style="clear:both;"></div>
					<p><input type="submit" style="cursor:pointer;" value="Batch change all values within range" /></p>
					
					
					<?php echo JHtml::_('form.token'); ?>
				</form>
				

		</fieldset>
	
	</div>	
	
	
	
	

