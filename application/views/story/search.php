<h1><?php echo lang('story_search'); ?></h1>
<form action ="<?php base_url(); ?>search" method="post" id="searchform">
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
		<th><?php echo lang('story_list_title'); ?></th>
		<th><?php echo lang('story_list_content'); ?></th>
		<th><?php echo lang('story_list_options'); ?></th>
		<th width="80px"><?php echo lang('story_list_actions'); ?></th>
	</tr>
	<?php foreach ($results as $page) { ?>
		<tr>
			<td><?php echo $page['id']; ?></td>
			<td><?php echo $page['title']; ?></td>
			<td><?php echo character_limiter($page['content'], 60); ?></td>
			<td></td>
			<td>
				<div class="btn-group">
					<?php
						echo anchor("page/show/".$page['id'], '<span class="glyphicon glyphicon-eye-open"></span>', 'class="btn btn-default btn-xs" title="Show"');
						echo anchor("page/edit/".$page['id'], '<span class="glyphicon glyphicon-pencil"></span>', 'class="btn btn-default btn-xs" title="Edit"');
						if ($page['id'] != $this->settings_model->get_value('start_page')) {
							echo '<a class="btn btn-default btn-xs" title="Delete" data-toggle="modal" href="#deleteModal'.$page['id'].'"><span class="glyphicon glyphicon-trash"></span></a>';
						}
					?>
				</div>
			</td>
		</tr>
	<?php } ?>
</table>

<?php foreach ($results as $page) { ?>
<?php if ($page['id'] == $this->settings_model->get_value('start_page')) { continue; } ?>
<div class="modal fade" id="deleteModal<?php echo $page['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModal<?php echo $page['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteModal<?php echo $page['id']; ?>Label"><?php echo lang('page_delete'); ?>: (<?php echo $page['id'].' - '.$page['title']; ?>)</h4>
			</div>
			<div class="modal-body">
				<p>
					<?php echo lang('page_delete_confirm'); ?>
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal"><?php echo lang('form_cancel'); ?></a>
				<?php echo anchor('page/delete/'.$page['id'], lang('form_delete'), 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php };?>