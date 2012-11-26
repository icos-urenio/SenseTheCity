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
jimport( 'joomla.form.form' );
$params = $this->form->getFieldsets('params');
?>


<form action="<?php echo JRoute::_('index.php?option=com_sensethecity&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_SENSETHECITY_LEGEND_ITEM'); ?></legend>
			<ul class="adminformlist">
					<?php foreach($this->form->getFieldset('details') as $field): ?>
						
						<li>
							<?php 
							echo $field->label;
							
							if ($field->type == 'Editor'){
								echo '<div style="float:left;">'.$field->input . '</div>';
							}
							else if ($field->type == 'Media'){
								echo $field->input;
								echo '<img style="clear: both;padding-left: 140px;" src="'.JURI::root().$this->form->getValue('photo') . '" height="80" alt="'.JText::_('COM_IMPROVEMYCITY_PHOTO_PREVIEW').'" />';
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

	<div class="width-40 fltrt">
		<?php echo JHtml::_('sliders.start', 'sensethecity-slider2'); ?>
		
			<?php echo JHtml::_('sliders.panel', JText::_('COM_SENSETHECITY_SENSETHECITY_MAP'), 'map');?>
			<div style="width: 100%;height: 400px;" id="mapCanvas"><?php echo JText::_('COM_SENSETHECITY_SENSETHECITY_MAP');?></div>				
			<div id="infoPanel" style="margin: 15px;">
				<b><?php echo JText::_('COM_SENSETHECITY_SENSETHECITY_GEOLOCATION');?></b>
				<div id="info"></div>
				<b><?php echo JText::_('COM_SENSETHECITY_SENSETHECITY_CLOSEST_ADDRESS');?></b>
				<div id="near_address"></div>
				<div id="geolocation">
					<input id="address" type="textbox" size="75" value="">
					<input style="background-color: #ccc;cursor:pointer;" type="button" value="<?php echo JText::_('COM_SENSETHECITY_SENSETHECITY_LOCATE');?>" onclick="codeAddress()">
				</div>	
			</div>	
					

			<?php /*	
			<?php foreach ($params as $name => $fieldset): ?>
					<?php echo JHtml::_('sliders.panel', JText::_($fieldset->label), $name.'-params');?>
				<?php if (isset($fieldset->description) && trim($fieldset->description)): ?>
					<p class="tip"><?php echo $this->escape(JText::_($fieldset->description));?></p>
				<?php endif;?>
					<fieldset class="panelform" >
						<ul class="adminformlist">
				<?php foreach ($this->form->getFieldset($name) as $field) : ?>
							<li><?php echo $field->label; ?><?php echo $field->input; ?></li>
				<?php endforeach; ?>
						</ul>
					</fieldset>
			<?php endforeach; ?>				
			*/ ?>
		
			<?php echo JHtml::_('sliders.panel', JText::_('COM_SENSETHECITY_STATION_STATUS'), 'station-status'); ?>
			<fieldset class="panelform">
				<p><strong><?php echo JText::_('COM_SENSETHECITY_STATION_LATEST_MEASUREMENTS');?>: </strong><?php echo $this->stationStatus[0]['measurement_datetime'];?></p>
				<p><strong><?php echo JText::_('COM_SENSETHECITY_STATION_STATUS_BATTERY');?>: </strong><?php echo $this->stationStatus[0]['battery'];?></p>
				<p><strong><?php echo JText::_('COM_SENSETHECITY_STATION_STATUS_TEMPERATURE');?>: </strong><?php echo $this->stationStatus[0]['temperature'];?></p>
				
				
			</fieldset>

			<?php echo JHtml::_('sliders.panel', JText::_('COM_SENSETHECITY_STATION_LATEST_MEASUREMENTS'), 'station-latest-measurements'); ?>
			<fieldset class="panelform">
				<p><strong><?php echo JText::_('COM_SENSETHECITY_STATION_LATEST_MEASUREMENTS');?>: </strong><?php echo $this->stationStatus[0]['measurement_datetime'];?></p>
				<?php  
				$html = '
				<table class="table table-striped">
				<thead>
				<tr>
				<th>'.JText::_('COM_SENSETHECITY_MEASURE').'</th>
				<th>'.JText::_('COM_SENSETHECITY_VALUE').'</th>
				</tr>
				</thead>
				<tbody>
				';
				
				foreach($this->stationStatus as $item){
					$html .='<tr>';
					$html .= '<td>' . $item['name'] . '</td> ';
					//$val = ($item['name'] == 'CO2' ? $item['corrected_value'] / 1.0e+156 : $item['corrected_value'] );
					$val = $item['corrected_value'];
					$html .= '<td>' . number_format(round(floatval($val),1), 1, ',', '') . ' ' . $item['unit'] . '</td> ';
					$html .='</tr>';
				}
				
				$html .= '</tbody></table>';

				echo $html;				
				?>
			</fieldset>
			
			
			
			
		<?php echo JHtml::_('sliders.end'); ?>		
		
		
	</div>
	<div class="clr"></div>	

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	<div class="clr"></div>
</form>


<?php /* MASTER-DETAIL */ ?>

<?php if ($this->item->id) : ?>
<form action="index.php" method="post" name="staphensForm" id="staphensForm">
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="station_id" value="<?php echo $this->item->id; ?>" />
	
	<?php echo JHtml::_('form.token'); ?>
	
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_SENSETHECITY_PHEN_LIST' ); ?></legend>
	
		<?php echo $this->tasksToolBar; ?>
		
		<table class="adminlist">
			<thead>
				<tr>
					<th width="1%">
						<input type="checkbox" onclick="Joomla.checkAll(this)" title="<?php echo JText::_( 'JGLOBAL_CHECK_ALL' ); ?>" value="" name="checkall-toggle">
					</th>
					<th>
						<?php echo JText::_('COM_SENSETHECITY_PHEN_DESCRIPTION'); ?>
					</th>
	
				
					<th>
						<?php echo JText::_('JGLOBAL_FIELD_ID_LABEL'); ?>
					</th>
				</tr>
			</thead>
			<tbody>
		<?php
		$k = 0;
		$i = 0;
		foreach ($this->staphens as &$row)
		{
			$checked = '<input type="checkbox" id="cb' . $i . '" name="cid[]" value="' . $row->id
				. '" onclick="Joomla.isChecked(this.checked, document.staphensForm);" title="' . JText::sprintf('JGRID_CHECKBOX_ROW_N', ($i + 1)) . '" />';
			$i++;
			$link = JRoute::_( 'index.php?option=' . $option . '&task=staphen.edit&id=' . $row->id . '&phenomenon_id=' . $row->phenomenon_id . '&station_id='.$this->item->id);
		?>
				<tr class="row<?php echo $k; ?>">
					<td><?php echo $checked; ?></td>
					<td>
						<a href="<?php echo $link; ?>">
							<?php echo $row->name; ?>
						</a>
					</td>
					<td>
						<a href="<?php echo $link; ?>">
							<?php echo $row->id; ?>
						</a>
					</td>
				</tr>
		<?php
			$k = 1 - $k;
		}
		?>
			</tbody>
		</table>
	</fieldset>
</form>
<?php endif; ?>










