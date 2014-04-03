<h1><?php echo lang('achievement_manage'); ?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<table class="table table-condensed">
	<tr>
		<th>Id</th>
		<th><?php echo lang('achievement_name'); ?></th>
		<th><?php echo lang('achievement_description'); ?></th>
		<th><?php echo lang('achievement_attribute'); ?></th>
		<th><?php echo lang('achievement_comparison'); ?></th>
		<th><?php echo lang('achievement_value'); ?></th>
		<th><?php echo lang('achievement_preview'); ?></th>
		<th width="80px"><?php echo lang('achievement_actions');?></th>
	</tr>
	<?php foreach ($achievements as $achievement) { ?>
		<tr>
			<td><?php echo $achievement['id'];?></td>
			<td><?php echo $achievement['name'];?></td>
			<td><?php echo $achievement['description'];?></td>
			<td><?php echo $achievement['attribute_name'];?></td>
			<td><?php echo $achievement['comparison_name'];?></td>
			<td><?php echo $achievement['value'];?></td>
			<td><img src="<?php echo base_url('assets/achievements/mobile/'.$achievement['mobile_uri']); ?>" class="img-responsive" /></td>
			<td>
				<div class="btn-group">
					<?php
						echo anchor("achievement/edit/".$achievement['id'], '<span class="glyphicon glyphicon-pencil"></span>', 'class="btn btn-default btn-xs" title="Bearbeiten"');
						echo '<a class="btn btn-default btn-xs" title="Löschen" data-toggle="modal" href="#deleteAchievementModal'.$achievement['id'].'"><span class="glyphicon glyphicon-trash"></span></a>';
					?>
				</div>
			</td>
		</tr>
	<?php } ?>
</table>
<p><?php echo anchor('achievement/add', '<span class="glyphicon glyphicon-plus"></span> '.lang('achievement_add'), 'class="btn btn-default"'); ?></p>

<?php foreach ($achievements as $achievement) { ?>
<div class="modal fade" id="deleteAchievementModal<?php echo $achievement['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteAchievementModal<?php echo $achievement['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteAchievementModal<?php echo $achievement['id']; ?>Label"><?php lang('achievement_delete'); ?>: (<?php echo $achievement['name']; ?>)</h4>
			</div>
			<div class="modal-body">
				<p>
					<?php lang('achievement_delete_confirm'); ?>
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal"><?php echo lang('form_cancel'); ?></a>
				<?php echo anchor('asset/delete_icon/'.$achievement['id'], lang('form_delete'), 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>