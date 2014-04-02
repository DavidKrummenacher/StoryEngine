<h1><?php echo lang('assets_manage'); ?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<ul class="nav nav-tabs">
	<li class="active"><a href="#page_images" data-toggle="tab"><?php echo lang('page_options_page_images'); ?></a></li>
	<li><a href="#icons" data-toggle="tab"><?php echo lang('page_options_icons'); ?></a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="page_images">
		<table class="table table-condensed">
			<tr>
				<th>Id</th>
				<th><?php echo lang('assets_name'); ?></th>
				<th><?php echo lang('assets_desc'); ?></th>
				<th><?php echo lang('assets_preview'); ?></th>
				<th width="80px"><?php echo lang('assets_actions'); ?></th>
			</tr>
			<?php foreach ($page_images as $page_image) { ?>
				<tr>
					<td><?php echo $page_image['id']; ?></td>
					<td><?php echo $page_image['name']; ?></td>
					<td><?php echo $page_image['description']; ?></td>
					<td><img src="<?php echo base_url('assets/page_images/mobile/'.$page_image['mobile_uri']); ?>" class="img-responsive" /></td>
					<td>
						<div class="btn-group">
							<?php
								echo anchor("asset/edit_page_image/".$page_image['id'], '<span class="glyphicon glyphicon-pencil"></span>', 'class="btn btn-default btn-xs" title="Edit"');
								echo '<a class="btn btn-default btn-xs" title="Delete" data-toggle="modal" href="#deletePageImageModal'.$page_image['id'].'"><span class="glyphicon glyphicon-trash"></span></a>';
							?>
						</div>
					</td>
				</tr>
			<?php } ?>
		</table>
		<p>
			<div class="btn-group">
				<?php echo anchor('asset/add_page_image', '<span class="glyphicon glyphicon-plus"></span> '.lang('assets_image_add'), 'class="btn btn-default"'); ?>
				<?php echo anchor('asset/batch_upload_page_images', '<span class="glyphicon glyphicon-upload"></span> '.lang('assets_batch_upload'), 'class="btn btn-default"'); ?>
			</div>
		</p>
	</div>
	
	<div class="tab-pane" id="icons">
		<table class="table table-condensed">
			<tr>
				<th>Id</th>
				<th><?php lang('assets_name'); ?></th>
				<th><?php lang('assets_desc'); ?></th>
				<th><?php lang('assets_preview'); ?></th>
				<th width="80px"><?php lang('assets_actions'); ?></th>
			</tr>
			<?php foreach ($icons as $icon) { ?>
				<tr>
					<td><?php echo $icon['id']; ?></td>
					<td><?php echo $icon['name']; ?></td>
					<td><?php echo $icon['description']; ?></td>
					<td><img src="<?php echo base_url('assets/icons/mobile/'.$icon['mobile_uri']); ?>" class="img-responsive" /></td>
					<td>
						<div class="btn-group">
							<?php
								echo anchor("asset/edit_icon/".$icon['id'], '<span class="glyphicon glyphicon-pencil"></span>', 'class="btn btn-default btn-xs" title="Edit"');
								echo '<a class="btn btn-default btn-xs" title="Delete" data-toggle="modal" href="#deleteIconModal'.$icon['id'].'"><span class="glyphicon glyphicon-trash"></span></a>';
							?>
						</div>
					</td>
				</tr>
			<?php } ?>
		</table>
		<p>
			<div class="btn-group">
				<?php echo anchor('asset/add_icon', '<span class="glyphicon glyphicon-plus"></span> Add icon', 'class="btn btn-default"'); ?>
				<?php echo anchor('asset/batch_upload_icons', '<span class="glyphicon glyphicon-upload"></span> '.lang('assets_batch_upload'), 'class="btn btn-default"'); ?>
			</div>
		</p>
	</div>
</div>

<?php foreach ($page_images as $page_image) { ?>
<div class="modal fade" id="deletePageImageModal<?php echo $page_image['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deletePageImageModal<?php echo $page_image['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deletePageImageModal<?php echo $page_image['id']; ?>Label"><?php echo lang('assets_image_delete'); ?>: (<?php echo $page_image['name']; ?>)</h4>
			</div>
			<div class="modal-body">
				<p>
					<?php echo lang('assets_image_delete_confirm'); ?>
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal"><?php echo lang('form_cancel'); ?></a>
				<?php echo anchor('asset/delete_page_image/'.$page_image['id'], lang('form_delete'), 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<?php foreach ($icons as $icon) { ?>
<div class="modal fade" id="deleteIconModal<?php echo $icon['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteIconModal<?php echo $icon['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteIconModal<?php echo $icon['id']; ?>Label"><?php lang('assets_icon_delete'); ?>: (<?php echo $icon['name']; ?>)</h4>
			</div>
			<div class="modal-body">
				<p>
					<?php lang('assets_icon_delete_confirm'); ?>
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal"><?php echo lang('form_cancel'); ?></a>
				<?php echo anchor('asset/delete_icon/'.$icon['id'], lang('form_delete'), 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>