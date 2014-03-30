<h1>Edit option</h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open('option/edit', 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="order" class="col-sm-2 control-label">Order</label>
		<div class="col-sm-10">
			<?php echo form_input($order, '', 'class="form-control"');?>
		</div>
	</div>
	<!--
	TODO: Add icon chooser
	<div class="form-group">
		<label for="icon" class="col-sm-2 control-label">Icon</label>
		<div class="col-sm-10">
			<?php echo form_input($icon, '', 'class="form-control"');?>
		</div>
	</div>
	-->
	<div class="form-group">
		<label for="text" class="col-sm-2 control-label">Text</label>
		<div class="col-sm-10">
			<?php echo form_input($text, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
			<?php echo form_submit('submit', 'Apply', 'class="btn btn-default"');?>
		</div>
	</div>
<?php echo form_close();?>

<h2>Conditions</h2>
<table class="table table-condensed">
	<tr>
		<th>Condition</th>
		<th width="80px"><?php echo lang('index_action_th');?></th>
	</tr>
	<?php foreach ($conditions as $condition):?>
		<tr>
			<td><?php echo $condition['id'];?></td>
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

<p><?php echo anchor('option/add_condition/'.$option['id'], '<span class="glyphicon glyphicon-plus"></span> Add condition', 'class="btn btn-default"'); ?></p>

<?php foreach ($conditions as $condition):?>
<div class="modal fade" id="deleteConditionModal<?php echo $condition['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteConditionModal<?php echo $condition['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteConditionModal<?php echo $condition['id']; ?>Label">Bedingung löschen:</h4>
			</div>
			<div class="modal-body">
				<p>
					Bedingung wirklich löschen?
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Abbrechen</a>
				<?php echo anchor('option/delete_condition/'.$condition['id'], 'Löschen', 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach;?>

<h2>Targets</h2>
<table class="table table-condensed">
	<tr>
		<th>Target</th>
		<th width="80px"><?php echo lang('index_action_th');?></th>
	</tr>
	<?php foreach ($targets as $target):?>
		<tr>
			<td><?php echo $target['target_page'];?></td>
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

<p><?php echo anchor('option/add_target/'.$option['id'], '<span class="glyphicon glyphicon-plus"></span> Add target', 'class="btn btn-default"'); ?></p>

<?php foreach ($targets as $target):?>
<div class="modal fade" id="deleteTargetModal<?php echo $target['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteTargetModal<?php echo $target['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteTargetModal<?php echo $target['id']; ?>Label">Ziel löschen:</h4>
			</div>
			<div class="modal-body">
				<p>
					Ziel wirklich löschen?
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Abbrechen</a>
				<?php echo anchor('option/delete_target/'.$target['id'], 'Löschen', 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach;?>

<h2>Checks</h2>
<table class="table table-condensed">
	<tr>
		<th>Check</th>
		<th width="80px"><?php echo lang('index_action_th');?></th>
	</tr>
	<?php foreach ($checks as $check):?>
		<tr>
			<td><?php echo $check['id'];?></td>
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

<p><?php echo anchor('option/add_check/'.$option['id'], '<span class="glyphicon glyphicon-plus"></span> Add check', 'class="btn btn-default"'); ?></p>

<?php foreach ($checks as $check):?>
<div class="modal fade" id="deleteCheckModal<?php echo $check['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteCheckModal<?php echo $check['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteCheckModal<?php echo $check['id']; ?>Label">Überprüfung löschen:</h4>
			</div>
			<div class="modal-body">
				<p>
					Überprüfung wirklich löschen?
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Abbrechen</a>
				<?php echo anchor('option/delete_check/'.$check['id'], 'Löschen', 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach;?>

<h2>Consequences</h2>
<table class="table table-condensed">
	<tr>
		<th>Consequence</th>
		<th width="80px"><?php echo lang('index_action_th');?></th>
	</tr>
	<?php foreach ($consequences as $consequence):?>
		<tr>
			<td><?php echo $consequence['id'];?></td>
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

<p><?php echo anchor('option/add_consequence/'.$option['id'], '<span class="glyphicon glyphicon-plus"></span> Add consequence', 'class="btn btn-default"'); ?></p>

<?php foreach ($consequences as $consequence):?>
<div class="modal fade" id="deleteConsequenceModal<?php echo $consequence['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteConsequenceModal<?php echo $consequence['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteConsequenceModal<?php echo $consequence['id']; ?>Label">Konsequenz löschen:</h4>
			</div>
			<div class="modal-body">
				<p>
					Konsequenz wirklich löschen?
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Abbrechen</a>
				<?php echo anchor('option/delete_consequence/'.$consequence['id'], 'Löschen', 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach;?>