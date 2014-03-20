<h1><?php echo lang('index_heading');?></h1>
<p><?php echo lang('index_subheading');?></p>

						<?php if ($message != "") { ?>
						<div class="alert alert-info">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?php echo $message;?>
						</div>
						<?php } ?>

<table class="table table-condensed">
	<tr>
		<th>Username</th>
		<th><?php echo lang('index_fname_th');?></th>
		<th><?php echo lang('index_lname_th');?></th>
		<th><?php echo lang('index_email_th');?></th>
		<th><?php echo lang('index_groups_th');?></th>
		<th width="80px"><?php echo lang('index_action_th');?></th>
	</tr>
	<?php foreach ($users as $user):?>
		<tr<?php if(!$user->active) { echo ' class="error"'; };?>>
			<td><?php echo $user->username;?></td>
			<td><?php echo $user->first_name;?></td>
			<td><?php echo $user->last_name;?></td>
			<td><?php echo $user->email;?></td>
			<td>
				<?php foreach ($user->groups as $group):?>
					<?php echo anchor("admin/edit_group/".$group->id, $group->description) ;?><br />
                <?php endforeach?>
			</td>
			<td>
				<div class="btn-group">
					<?php
						if ($this->ion_auth->user()->row()->id != $user->id) {
							if ($user->active) { echo anchor('admin/deactivate/'.$user->id, '<span class="glyphicon glyphicon-thumbs-down"></span>', 'class="btn btn-default btn-xs" title="Deaktivieren"'); }
							else { echo anchor('admin/activate/'. $user->id, '<span class="glyphicon glyphicon-thumbs-up"></span>', 'class="btn btn-default btn-xs" title="Aktivieren"'); }
						}
						echo anchor("admin/edit_user/".$user->id, '<span class="glyphicon glyphicon-pencil"></span>', 'class="btn btn-default btn-xs" title="Bearbeiten"');
						if ($this->ion_auth->user()->row()->id != $user->id) { echo '<a class="btn btn-default btn-xs" title="Löschen" data-toggle="modal" href="#deleteModal'.$user->id.'"><span class="glyphicon glyphicon-trash"></span></a>'; }
					?>
				</div>
			</td>
			
			
			
		</tr>
	<?php endforeach;?>
</table>

<p><?php echo anchor('admin/create_user', lang('index_create_user_link'))?> | <?php echo anchor('admin/create_group', lang('index_create_group_link'))?></p>