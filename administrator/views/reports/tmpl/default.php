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

?>


<?php echo 'Total: ' . count($this->items);?>
<table class="adminlist">
  <thead>
    <tr>
      <th>#</th>
      <th><?php echo JText::_('COM_SENSETHECITY_SENSETHECITY_FIELD_TITLE_LABEL');?></th>
      <th><?php echo JText::_('COM_SENSETHECITY_SENSETHECITY_FIELD_CATID_LABEL');?></th>
      <th><?php echo JText::_('COM_SENSETHECITY_SENSETHECITY_FIELD_LATITUDE_LABEL');?></th>
      <th><?php echo JText::_('COM_SENSETHECITY_SENSETHECITY_FIELD_LONGITUDE_LABEL');?></th>
      <th><?php echo JText::_('COM_SENSETHECITY_SENSETHECITY_FIELD_ADDRESS_LABEL');?></th>
    </tr>
  </thead>
  <tbody>
	<?php 
	$i=-1;
	foreach($this->items as $item){
		$i++;$a = $i%2;
		echo '<tr class="row'.$a.'">';
		echo '<td>'.$item->id . '</td>' . "\n";
		echo '<td>'.$item->title . '</td>' . "\n";
		echo '<td>'.$item->category . '</td>' . "\n";
		echo '<td>'.$item->latitude . '</td>' . "\n";
		echo '<td>'.$item->longitude . '</td>' . "\n";
		echo '<td>'.$item->address . '</td>' . "\n";
		echo '</tr>'; 
	}
	?>

  </tbody>
</table> 
