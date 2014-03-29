<h1>List of all pages</h1>
<form action ="<?= base_url()?>index.php/page/search" method="post" id="searchform">
<div class="input-group">
	<input type="search" class="form-control" placeholder="Search" name="searchterm">
	<span class="input-group-btn">
		<button class="btn btn-default" type="submit" data-target=""><span class="glyphicon glyphicon-search"></span></button>
	</span>
</div><!-- /input-group -->
</form>

<table class="table table-condensed">
	<tr>
		<th>Id</th>
		<th>Title</th>
		<th>Content</th>
		<th>Options</th>
		<th width="80px">Actions</th>
	</tr>
	<?php foreach ($pages as $page) { ?>
		<tr>
			<td><?php echo $page['id']; ?></td>
			<td><?php echo $page['title']; ?></td>
			<td><?php echo character_limiter($page['content'], 60); ?></td>
			<td></td>
			<td>
				<div class="btn-group">
					<?php
						echo anchor("page/show/".$page['id'], '<span class="glyphicon glyphicon-eye-open"></span>', 'class="btn btn-default btn-xs" title="Show"');
						echo anchor("page/edit_page/".$page['id'], '<span class="glyphicon glyphicon-pencil"></span>', 'class="btn btn-default btn-xs" title="Edit"');
						if ($page['id'] != $this->settings_model->get_value('start_page')) {
							echo '<a class="btn btn-default btn-xs" title="Delete" data-toggle="modal" href="#deleteModal'.$page['id'].'"><span class="glyphicon glyphicon-trash"></span></a>';
						}
					?>
				</div>
			</td>
		</tr>
	<?php } ?>
</table>

<?php if($pagination) { ?>  <ul class="pagination pagination-lg"><?php echo $pagination; } ?> </ul>

<?php foreach ($pages as $page) { ?>
<?php if ($page['id'] == $this->settings_model->get_value('start_page')) { continue; } ?>
<div class="modal fade" id="deleteModal<?php echo $page['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModal<?php echo $page['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteModal<?php echo $page['id']; ?>Label">Seite löschen: (<?php echo $page['id'].' - '.$page['title']; ?>)</h4>
			</div>
			<div class="modal-body">
				<p>
					Seite wirklich löschen?
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Abbrechen</a>
				<?php echo anchor('page/delete_page/'.$page['id'], 'Löschen', 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php };?>