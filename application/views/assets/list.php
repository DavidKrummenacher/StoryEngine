<h1>Manage assets</h1>

<div id="infoMessage"><?php echo $message;?></div>

<ul class="nav nav-tabs">
	<li class="active"><a href="#page_images" data-toggle="tab">Page images</a></li>
	<li><a href="#icons" data-toggle="tab">Icons</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="page_images">
		<table class="table table-condensed">
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Description</th>
				<th>Preview</th>
				<th width="80px">Actions</th>
			</tr>
			<?php foreach ($page_images as $page_image) { ?>
				<tr>
					<td><?php echo $page_image['id']; ?></td>
					<td><?php echo $page_image['name']; ?></td>
					<td><?php echo $page_image['description']; ?></td>
					<td><?php echo $page_image['mobile_uri']; // TODO: display image ?></td>
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
		<p><?php echo anchor('asset/add_page_image', '<span class="glyphicon glyphicon-plus"></span> Add page image', 'class="btn btn-default"'); ?></p>
	</div>
	
	<div class="tab-pane" id="icons">
		<table class="table table-condensed">
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Description</th>
				<th>Preview</th>
				<th width="80px">Actions</th>
			</tr>
			<?php foreach ($icons as $icon) { ?>
				<tr>
					<td><?php echo $icon['id']; ?></td>
					<td><?php echo $icon['name']; ?></td>
					<td><?php echo $icon['description']; ?></td>
					<td><?php echo $icon['mobile_uri']; // TODO: display image ?></td>
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
		<p><?php echo anchor('asset/add_icon', '<span class="glyphicon glyphicon-plus"></span> Add icon', 'class="btn btn-default"'); ?></p>
	</div>
</div>

<?php foreach ($page_images as $page_image) { ?>
<div class="modal fade" id="deletePageImageModal<?php echo $page_image['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deletePageImageModal<?php echo $page_image['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deletePageImageModal<?php echo $page_image['id']; ?>Label">Bild löschen: (<?php echo $page_image['name']; ?>)</h4>
			</div>
			<div class="modal-body">
				<p>
					Bild wirklich löschen?
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Abbrechen</a>
				<?php echo anchor('asset/delete_page_image/'.$page_image['id'], 'Löschen', 'class="btn btn-primary"'); ?>
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
				<h4 class="modal-title" id="deleteIconModal<?php echo $icon['id']; ?>Label">Symbol löschen: (<?php echo $icon['name']; ?>)</h4>
			</div>
			<div class="modal-body">
				<p>
					Symbol wirklich löschen?
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Abbrechen</a>
				<?php echo anchor('asset/delete_icon/'.$icon['id'], 'Löschen', 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>