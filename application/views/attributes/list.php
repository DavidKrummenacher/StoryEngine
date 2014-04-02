<h1><?php echo lang('page_options_attribute_manage'); ?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<table class="table table-condensed">
	<tr>
		<th>Id</th>
		<th><?php echo lang('assets_name'); ?></th>
		<th><?php echo lang('assets_desc'); ?></th>
		<th><?php echo lang('form_default_value'); ?></th>
		<th width="80px">Actions</th>
	</tr>
	<?php foreach ($attributes as $attribute) { ?>
		<tr>
			<td><?php echo $attribute['id']; ?></td>
			<td><?php echo $attribute['name']; ?></td>
			<td><?php echo $attribute['description']; ?></td>
			<td><?php echo $attribute['value']; ?></td>
			<td>
				<div class="btn-group">
					<?php
						echo anchor("attribute/edit/".$attribute['id'], '<span class="glyphicon glyphicon-pencil"></span>', 'class="btn btn-default btn-xs" title="Edit"');
						echo '<a class="btn btn-default btn-xs" title="Delete" data-toggle="modal" href="#deleteModal'.$attribute['id'].'"><span class="glyphicon glyphicon-trash"></span></a>';
					?>
				</div>
			</td>
		</tr>
	<?php } ?>
</table>

<p><?php echo anchor('attribute/add', '<span class="glyphicon glyphicon-plus"></span> Add attribute', 'class="btn btn-default"'); ?></p>

<?php foreach ($attributes as $attribute) { ?>
<div class="modal fade" id="deleteModal<?php echo $attribute['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModal<?php echo $attribute['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteModal<?php echo $attribute['id']; ?>Label"><?php echo lang('attribute_delete'); ?>: (<?php echo $attribute['name']; ?>)</h4>
			</div>
			<div class="modal-body">
				<p>
					<?php echo lang('attribute_delete_confirm'); ?>
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal"><?php echo lang('form_cancel'); ?></a>
				<?php echo anchor('attribute/delete/'.$attribute['id'], lang('form_delete'), 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>