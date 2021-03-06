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

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>

<div id="imc-wrapper" class="imc <?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading', 0)) : ?>			
	<h1 class="title">
		<?php if ($this->escape($this->params->get('page_heading'))) :?>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		<?php else : ?>
			<?php echo $this->escape($this->params->get('page_title')); ?>
		<?php endif; ?>				
	</h1>
	<?php endif; ?>	

	<?php /*
	<div id="imc-header">
		<div id="imc-menu" class="issueslist">
			<!-- Filters -->
			<form action="<?php echo htmlspecialchars(JFactory::getURI()->toString()); ?>" method="post" name="adminForm" id="adminForm">
				<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
				<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
				<input type="hidden" name="status[0]" value="0" />
				<input type="hidden" name="cat[0]" value="0" />
				<input type="hidden" name="limitstart" value="" />
				<input type="hidden" name="limit" value="<?php echo  $this->state->get('list.limit');?>" />
				<input type="hidden" name="task" value="" />
				
				<!-- Mega Menu -->
				<ul id="mega-menu">
					<li id="drop-1"><a id="btn-1" href="javascript:void(0);" class="btn"><i class="icon-list-alt"></i> <?php echo JText::_('COM_SENSETHECITY_FILTER_SELECTION')?></a>
						<div class="megadrop dropdown_6columns">
							<div class="col_3">
								<h2><?php echo JText::_('COM_SENSETHECITY_CATEGORIES')?></h2>
								<?php foreach($this->arCat as $c){?>		

										<?php echo $c; ?>
					
								<?php }?>
							</div>
						
							<div class="col_3">
								<h2><?php echo JText::_('COM_SENSETHECITY_DATES')?></h2>
							
								<label for="datepicker_from"><?php echo JText::_('COM_SENSETHECITY_FROM')?></label><input type="text" id="datepicker_from" />
								<label for="datepicker_to"><?php echo JText::_('COM_SENSETHECITY_TO')?></label><input type="text" id="datepicker_to" />
							</div>
							
							<div class="col_6">
							<br /><br />
							</div>
							
							
							<div class="col_6" style="text-align: center;">
								<button type="submit" class="btn btn-success" name="Submit" value="<?php echo JText::_('COM_SENSETHECITY_APPLY_FILTERS')?>"><i class="icon-ok icon-white"></i> <?php echo JText::_('COM_SENSETHECITY_APPLY_FILTERS')?></button>
							</div>
						</div>
					</li>
				</ul>
			</form>	
		</div>
	</div>
	*/?>
	
	<div id="loading"><img src="<?php echo JURI::base().'components/com_sensethecity/images/ajax-loader.gif';?>" /></div>
	
	<div id="imc-content">
		
		<?php /*<a href="javascript:void(0);" onclick="alert(GeoMarker.getAccuracy());">test: get accuracy in meters</a>*/?>
		
		<div class="row-fluid">
			<div class="span12">
				<div id="stationInfo"></div>
			</div>
		</div>
		
		<div class="row-fluid">
			<div class="span12">
				<div id="mapCanvas"><?php echo JText::_('COM_SENSETHECITY');?></div>
				<?php if($this->credits == 1) : ?>
					<div style="margin-top: 30px;" class="alert alert-info"><?php echo JText::_('COM_SENSETHECITY_INFOALERT');?></div>
				<?php endif; ?>
			</div>
		</div>
		
		<div class="row-fluid">
			<div class="span12">
				<div id="graphTabs"></div>
			</div>
		</div>
		
		<div class="row-fluid">
			<div class="span6">
				<?php if(empty($this->items)) : ?>
					<div class="alert alert-error width75">
					<?php echo JText::_('COM_SENSETHECITY_FILTER_REVISION'); ?>
					</div>
				<?php endif; ?>
				<div id="wrapper-info">	
					<div id="waitingIndicator"></div>
					<div id="stationLatestMeasures">&nbsp;</div>
				</div>				
			</div>
			<div class="span6">
				<div class="stcStatistics">
					<div id="waitingIndicatorStatistics"></div>
					<div id="measureStatistics"></div>
				</div>
			</div>
		</div>
		
	</div>
</div>

