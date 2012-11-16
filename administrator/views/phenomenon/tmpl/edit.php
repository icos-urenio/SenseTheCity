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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$params = $this->form->getFieldsets('params');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'phenomenon.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
			Joomla.submitform(task, document.getElementById('item-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_sensethecity&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
	<div class="width-100 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_IMPROVEMYCITY_TITLE_PHENOMENON'); ?></legend>
			<ul class="adminformlist">
				<?php foreach($this->form->getFieldset('details') as $field): ?>
					
					<li>
						<?php 
						echo $field->label;
						
						if ($field->type == 'Editor'){
							echo '<div style="float:left;">'.$field->input . '</div>';
						}
			
						else{
							echo $field->input;
						}
						
						?>
					</li>
				<?php endforeach; ?>
            </ul>
		</fieldset>
	</div>

	<div class="clr"></div>	

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	<div class="clr"></div>
</form>
