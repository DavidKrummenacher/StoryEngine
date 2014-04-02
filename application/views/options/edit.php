<h1><?php echo lang('page_option_edit'); ?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open('option/edit/'.$option['id'], 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="order" class="col-sm-2 control-label"><?php echo lang('page_options_order'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($order, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="icon" class="col-sm-2 control-label"><?php echo lang('page_options_icon'); ?></label>
		<div class="col-sm-10">
			<select name="icon" id="icon" class="form-control">
				<option value="null"<?php if ($icon['value'] == null) { ?> selected="selected"<?php } ?>><?php echo lang('page_options_noicon'); ?></option>
				<?php foreach ($icons as $i) { ?>
				<option value="<?php echo $i['id']; ?>"<?php if ($i['id'] == $icon['value']) { ?> selected="selected"<?php } ?>>
					<?php echo $i['name']; ?>
				</option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="text" class="col-sm-2 control-label"><?php echo lang('page_options_text'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($text, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
			<?php echo form_submit('submit', lang('form_apply'), 'class="btn btn-default"');?>
		</div>
	</div>
<?php echo form_close();?>

<ul class="nav nav-tabs">
	<li class="active"><a href="#conditions" data-toggle="tab"><?php echo lang('page_conditions'); ?></a></li>
	<li><a href="#targets" data-toggle="tab"><?php echo lang('page_targets'); ?></a></li>
	<li><a href="#checks" data-toggle="tab"><?php echo lang('page_checks'); ?></a></li>
	<li><a href="#consequences" data-toggle="tab"><?php echo lang('page_consequences'); ?></a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="conditions">
		<table class="table table-condensed">
			<tr>
				<th>Id</th>
				<th><?php echo lang('page_options_attribute'); ?></th>
				<th><?php echo lang('page_options_comparison'); ?></th>
				<th><?php echo lang('page_options_value'); ?></th>
				<th width="80px"><?php echo lang('index_action_th');?></th>
			</tr>
			<?php foreach ($conditions as $condition):?>
				<tr>
					<td><?php echo $condition['id'];?></td>
					<td><?php echo $condition['attribute_name'];?></td>
					<td><?php echo $condition['comparison_name'];?></td>
					<td><?php echo $condition['value'];?></td>
					<td>
						<div class="btn-group">
							<?php
								echo anchor("option/edit_condition/".$condition['id'], '<span class="glyphicon glyphicon-pencil"></span>', 'class="btn btn-default btn-xs" title="Bearbeiten"');
								echo '<a class="btn btn-default btn-xs" title="Löschen" data-toggle="modal" href="#deleteConditionModal'.$condition['id'].'"><span class="glyphicon glyphicon-trash"></span></a>';
							?>
						</div>
					</td>
				</tr>
			<?php endforeach;?>
		</table>
		<p><?php echo anchor('option/add_condition/'.$option['id'], '<span class="glyphicon glyphicon-plus"></span> '.lang('page_options_add_condition'), 'class="btn btn-default"'); ?></p>
	</div>
	
	<div class="tab-pane" id="targets">
		<table class="table table-condensed">
			<tr>
				<th>Id</th>
				<th><?php echo lang('page_options_target'); ?></th>
				<th><?php echo lang('page_options_pagetype'); ?></th>
				<th width="80px"><?php echo lang('index_action_th');?></th>
			</tr>
			<?php foreach ($targets as $target):?>
				<tr>
					<td><?php echo $target['id'];?></td>
					<td><?php echo $target['target_page'].' - '.$target['title'];?></td>
					<td><?php echo ($target['fail']) ? '<span class="glyphicon glyphicon-thumbs-down"></span> Fail page' : '<span class="glyphicon glyphicon-thumbs-up"></span> Success page';?></td>
					<td>
						<div class="btn-group">
							<?php
								echo anchor("option/edit_target/".$target['id'], '<span class="glyphicon glyphicon-pencil"></span>', 'class="btn btn-default btn-xs" title="Bearbeiten"');
								echo '<a class="btn btn-default btn-xs" title="Löschen" data-toggle="modal" href="#deleteTargetModal'.$target['id'].'"><span class="glyphicon glyphicon-trash"></span></a>';
							?>
						</div>
					</td>
				</tr>
			<?php endforeach;?>
		</table>
		<p><?php echo anchor('option/add_target/'.$option['id'], '<span class="glyphicon glyphicon-plus"></span> '.lang('page_options_target_add'), 'class="btn btn-default"'); ?></p>
	</div>
	
	<div class="tab-pane" id="checks">
		<table class="table table-condensed">
			<tr>
				<th>Id</th>
				<th><?php echo lang('page_options_attribute'); ?></th>
				<th><?php echo lang('page_options_comparison'); ?></th>
				<th><?php echo lang('page_options_value'); ?></th>
				<th width="80px"><?php echo lang('index_action_th');?></th>
			</tr>
			<?php foreach ($checks as $check):?>
				<tr>
					<td><?php echo $check['id'];?></td>
					<td><?php echo $check['attribute_name'];?></td>
					<td><?php echo $check['comparison_name'];?></td>
					<td><?php echo ($check['random']) ? 'Random (0 - '.$check['value'].')' : $check['value'];?></td>
					<td>
						<div class="btn-group">
							<?php
								echo anchor("option/edit_check/".$check['id'], '<span class="glyphicon glyphicon-pencil"></span>', 'class="btn btn-default btn-xs" title="Bearbeiten"');
								echo '<a class="btn btn-default btn-xs" title="Löschen" data-toggle="modal" href="#deleteCheckModal'.$check['id'].'"><span class="glyphicon glyphicon-trash"></span></a>';
							?>
						</div>
					</td>
				</tr>
			<?php endforeach;?>
		</table>
		<p><?php echo anchor('option/add_check/'.$option['id'], '<span class="glyphicon glyphicon-plus"></span> '.lang('page_options_add_check'), 'class="btn btn-default"'); ?></p>
	</div>
	
	<div class="tab-pane" id="consequences">
		<table class="table table-condensed">
			<tr>
				<th>Id</th>
				<th><?php echo lang('page_options_attribute'); ?></th>
				<th><?php echo lang('page_options_operator'); ?></th>
				<th><?php echo lang('page_options_value'); ?></th>
				<th width="80px"><?php echo lang('index_action_th');?></th>
			</tr>
			<?php foreach ($consequences as $consequence):?>
				<tr>
					<td><?php echo $consequence['id'];?></td>
					<td><?php echo $consequence['attribute_name'];?></td>
					<td><?php echo $consequence['operator_name'];?></td>
					<td><?php echo $consequence['value'];?></td>
					<td>
						<div class="btn-group">
							<?php
								echo anchor("option/edit_consequence/".$consequence['id'], '<span class="glyphicon glyphicon-pencil"></span>', 'class="btn btn-default btn-xs" title="Bearbeiten"');
								echo '<a class="btn btn-default btn-xs" title="Löschen" data-toggle="modal" href="#deleteConsequenceModal'.$consequence['id'].'"><span class="glyphicon glyphicon-trash"></span></a>';
							?>
						</div>
					</td>
				</tr>
			<?php endforeach;?>
		</table>
		<p><?php echo anchor('option/add_consequence/'.$option['id'], '<span class="glyphicon glyphicon-plus"></span> '.lang('page_options_add_consequence'), 'class="btn btn-default"'); ?></p>
	</div>
</div>

<?php foreach ($conditions as $condition):?>
<div class="modal fade" id="deleteConditionModal<?php echo $condition['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteConditionModal<?php echo $condition['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteConditionModal<?php echo $condition['id']; ?>Label"><?php echo lang('condition_delete'); ?>:</h4>
			</div>
			<div class="modal-body">
				<p>
					<?php echo lang('condition_delete_confirm'); ?>
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal"><?php echo lang('form_cancel'); ?></a>
				<?php echo anchor('option/delete_condition/'.$condition['id'], lang('form_delete'), 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach;?>

<?php foreach ($targets as $target):?>
<div class="modal fade" id="deleteTargetModal<?php echo $target['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteTargetModal<?php echo $target['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteTargetModal<?php echo $target['id']; ?>Label"><?php echo lang('target_delete'); ?>:</h4>
			</div>
			<div class="modal-body">
				<p>
					<?php echo lang('target_delete_confirm'); ?>
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal"><?php echo lang('form_cancel'); ?></a>
				<?php echo anchor('option/delete_target/'.$target['id'], lang('form_delete'), 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach;?>

<?php foreach ($checks as $check):?>
<div class="modal fade" id="deleteCheckModal<?php echo $check['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteCheckModal<?php echo $check['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteCheckModal<?php echo $check['id']; ?>Label"><?php echo lang('check_delete'); ?>:</h4>
			</div>
			<div class="modal-body">
				<p>
					<?php echo lang('check_delete_confirm'); ?>
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal"><?php echo lang('form_cancel'); ?></a>
				<?php echo anchor('option/delete_check/'.$check['id'], lang('form_delete'), 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach;?>

<?php foreach ($consequences as $consequence):?>
<div class="modal fade" id="deleteConsequenceModal<?php echo $consequence['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteConsequenceModal<?php echo $consequence['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteConsequenceModal<?php echo $consequence['id']; ?>Label"><?php echo lang('consequence_delete'); ?>:</h4>
			</div>
			<div class="modal-body">
				<p>
					<?php echo lang('consequence_delete_confirm'); ?>
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal"><?php echo lang('form_cancel'); ?></a>
				<?php echo anchor('option/delete_consequence/'.$consequence['id'], lang('form_delete'), 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach;?>