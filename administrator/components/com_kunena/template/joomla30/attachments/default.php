<?php
/**
 * Kunena Component
 * @package Kunena.Administrator.Template
 * @subpackage Attachments
 *
 * @copyright (C) 2008 - 2013 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
//JHtml::_('formbehavior.chosen', 'select');

$this->document->addStyleSheet ( JUri::base(true).'/components/com_kunena/media/css/layout.css' );
?>

<script type="text/javascript">
	Joomla.orderTable = function() {
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $this->listOrdering; ?>') {
			dirn = 'asc';
		} else {
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>

<div id="j-sidebar-container" class="span2">
	<div id="sidebar">
		<div class="sidebar-nav"><?php include KPATH_ADMIN.'/template/joomla30/common/menu.php'; ?></div>
	</div>
</div>
<div id="j-main-container" class="span10">
	<form action="<?php echo KunenaRoute::_('administrator/index.php?option=com_kunena&view=attachments') ?>" method="post" id="adminForm" name="adminForm">
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="limitstart" value="<?php echo intval($this->pagination->limitstart); ?>" />
		<input type="hidden" name="filter_order" value="<?php echo $this->listOrdering; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->listDirection; ?>" />
		<?php echo JHtml::_( 'form.token' ); ?>

		<div id="filter-bar" class="btn-toolbar">
			<div class="filter-search btn-group pull-left">
				<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_KUNENA_FIELD_LABEL_SEARCHIN');?></label>
				<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_KUNENA_ATTACHMENTS_FIELD_INPUT_SEARCHFILE'); ?>" value="<?php echo $this->filterSearch; ?>" title="<?php echo JText::_('COM_KUNENA_ATTACHMENTS_FIELD_INPUT_SEARCHFILE'); ?>" />
			</div>
			<div class="btn-group pull-left">
				<button class="btn tip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i> <?php echo JText::_('JSEARCH_FILTER_LABEL') ?></button>
				<button class="btn tip" type="button" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="jQuery('.filter').val('');jQuery('#adminForm').submit();"><i class="icon-remove"></i> <?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
			</div>
			<div class="btn-group pull-right hidden-phone">
				<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
				<?php echo $this->pagination->getLimitBox (); ?>
			</div>
			<div class="btn-group pull-right hidden-phone">
				<label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC');?></label>
				<select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
					<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC');?></option>
					<?php echo JHtml::_('select.options', $this->sortDirectionFields, 'value', 'text', $this->listDirection);?>
					</select>
			</div>
			<div class="btn-group pull-right">
				<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY');?></label>
				<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
					<option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?></option>
					<?php echo JHtml::_('select.options', $this->sortFields, 'value', 'text', $this->listOrdering);?>
				</select>
			</div>
			<div class="clearfix"></div>
		</div>

		<table class="table table-striped adminlist" id="attachmentsList">
			<thead>
				<tr>
					<th width="1%"><input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)" /></th>
					<th><?php echo JHtml::_('grid.sort', 'COM_KUNENA_ATTACHMENTS_FIELD_LABEL_TITLE', 'filename', $this->listDirection, $this->listOrdering ); ?></th>
					<th><?php echo JHtml::_('grid.sort', 'COM_KUNENA_ATTACHMENTS_FIELD_LABEL_TYPE', 'filetype', $this->listDirection, $this->listOrdering ); ?></th>
					<th><?php echo JHtml::_('grid.sort', 'COM_KUNENA_ATTACHMENTS_FIELD_LABEL_SIZE', 'size', $this->listDirection, $this->listOrdering ); ?>
					<th><?php echo JText::_('COM_KUNENA_ATTACHMENTS_FIELD_LABEL_IMAGEDIMENSIONS'); ?></th>
					<th><?php echo JHtml::_('grid.sort', 'COM_KUNENA_ATTACHMENTS_USERNAME', 'username', $this->listDirection, $this->listOrdering ); ?></th>
					<th><?php echo JHtml::_('grid.sort', 'COM_KUNENA_ATTACHMENTS_FIELD_LABEL_MESSAGE', 'post', $this->listDirection, $this->listOrdering ); ?></th>
					<th><?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'id', $this->listDirection, $this->listOrdering ); ?></th>
				</tr>
				<tr>
					<td class="hidden-phone">
					</td>
					<td class="nowrap">
						<label for="filter_title" class="element-invisible"><?php echo JText::_('COM_KUNENA_FIELD_LABEL_SEARCHIN') ?></label>
						<input class="input-block-level input-filter filter" type="text" name="filter_title" id="filter_title" placeholder="<?php echo JText::_('COM_KUNENA_FIELD_LABEL_FILTER') ?>" value="<?php echo $this->filterTitle; ?>" title="<?php echo JText::_('COM_KUNENA_FIELD_LABEL_FILTER') ?>" />
					</td>
					<td class="nowrap">
						<label for="filter_type" class="element-invisible"><?php echo JText::_('COM_KUNENA_FIELD_LABEL_SEARCHIN') ?></label>
						<input class="input-block-level input-filter filter" type="text" name="filter_type" id="filter_type" placeholder="<?php echo JText::_('COM_KUNENA_FIELD_LABEL_FILTER') ?>" value="<?php echo $this->filterType; ?>" title="<?php echo JText::_('COM_KUNENA_FIELD_LABEL_FILTER') ?>" />
					</td>
					<td class="nowrap">
						<label for="filter_size" class="element-invisible"><?php echo JText::_('COM_KUNENA_FIELD_LABEL_SEARCHIN') ?></label>
						<input class="input-block-level input-filter filter" type="text" name="filter_size" id="filter_size" placeholder="<?php echo JText::_('COM_KUNENA_FIELD_LABEL_FILTER') ?>" value="<?php echo $this->filterSize; ?>" title="<?php echo JText::_('COM_KUNENA_FIELD_LABEL_FILTER') ?>" />
					</td>
					<td class="nowrap">
					<?php /*
						<label for="filter_dims" class="element-invisible"><?php echo JText::_('COM_KUNENA_FIELD_LABEL_SEARCHIN') ?></label>
						<input class="input-block-level input-filter filter" type="text" name="filter_dims" id="filter_dims" placeholder="<?php echo JText::_('COM_KUNENA_FIELD_LABEL_FILTER') ?>" value="<?php echo $this->filterDimensions; ?>" title="<?php echo JText::_('COM_KUNENA_FIELD_LABEL_FILTER') ?>" />
					*/ ?>
					</td>
					<td class="nowrap">
						<label for="filter_username" class="element-invisible"><?php echo JText::_('COM_KUNENA_FIELD_LABEL_SEARCHIN') ?></label>
						<input class="input-block-level input-filter filter" type="text" name="filter_username" id="filter_username" placeholder="<?php echo JText::_('COM_KUNENA_FIELD_LABEL_FILTER') ?>" value="<?php echo $this->filterUsername; ?>" title="<?php echo JText::_('COM_KUNENA_FIELD_LABEL_FILTER') ?>" />
					</td>
					<td class="nowrap">
						<label for="filter_post" class="element-invisible"><?php echo JText::_('COM_KUNENA_FIELD_LABEL_SEARCHIN') ?></label>
						<input class="input-block-level input-filter filter" type="text" name="filter_post" id="filter_post" placeholder="<?php echo JText::_('COM_KUNENA_FIELD_LABEL_FILTER') ?>" value="<?php echo $this->filterPost; ?>" title="<?php echo JText::_('COM_KUNENA_FIELD_LABEL_FILTER') ?>" />
					</td>
					<td class="nowrap center hidden-phone">
					</td>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="8">
						<div class="pagination">
							<?php echo $this->pagination->getListFooter(); ?>
						</div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php
					$i = 0;
					foreach($this->items as $id=>$row) :
						$instance = KunenaForumMessageAttachmentHelper::get($row->id);
						$message = $instance->getMessage();
						$path = JPATH_ROOT.'/'.$row->folder.'/'.$row->filename;
						if ( $instance->isImage($row->filetype) && is_file($path)) list($width, $height) = getimagesize( $path );
				?>
					<tr>
						<td><?php echo JHtml::_('grid.id', $i, intval($row->id)) ?></td>
						<td><?php echo $instance->getThumbnailLink() . ' ' . KunenaForumMessageAttachmentHelper::shortenFileName($row->filename, 10, 15) ?></td>
						<td><?php echo $this->escape($row->filetype); ?></td>
						<td><?php echo number_format ( intval ( $row->size ) / 1024, 0, '', ',' ) . ' '.JText::_('COM_KUNENA_ATTACHMENTS_KILOBYTE'); ?></td>
						<td><?php echo isset($width) && isset($height) ? $width . ' x ' . $height  : '' ?></td>
						<td><?php echo $this->escape($row->user_title); ?></td>
						<td><?php echo $this->escape($row->post_title); ?></td>
						<td><?php echo intval($row->id); ?></td>
					</tr>
				<?php $i++; endforeach; ?>
			</tbody>
		</table>

	</form>
</div>

<div class="pull-right small">
	<?php echo KunenaVersion::getLongVersionHTML(); ?>
</div>