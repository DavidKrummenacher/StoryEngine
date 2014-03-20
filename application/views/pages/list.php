<h1>List of all pages</h1>

<div class="input-group">
	<input type="text" class="form-control" placeholder="Search">
	<span class="input-group-btn">
		<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
	</span>
</div><!-- /input-group -->

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
						echo '<a class="btn btn-default btn-xs" title="Delete" data-toggle="modal" href="#deleteModal'.$page['id'].'"><span class="glyphicon glyphicon-trash"></span></a>';
					?>
				</div>
			</td>
		</tr>
	<?php } ?>
</table>