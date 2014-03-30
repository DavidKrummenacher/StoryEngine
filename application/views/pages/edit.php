<h1>Edit Page: #<?php echo $page['id']; ?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open('page/edit/'.$page['id'], 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Page Title</label>
		<div class="col-sm-10">
			<?php echo form_input($title, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="description" class="col-sm-2 control-label">Description</label>
		<div class="col-sm-10">
			<?php echo form_input($description, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="content" class="col-sm-2 control-label">Content</label>
		<div class="col-sm-10">
			<?php echo form_textarea($content, '', 'rows="12" class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
			<button type="submit" class="btn btn-default"><?php echo lang('menu_system_save'); ?></button>
		</div>
	</div>   
<?php echo form_close();?>

<h2>Options</h2>
<table class="table table-condensed">
	<tr>
		<th>Order</th>
		<th>Icon</th>
		<th>Text</th>
		<th width="80px"><?php echo lang('index_action_th');?></th>
	</tr>
	<?php foreach ($options as $option):?>
		<tr>
			<td><?php echo $option['order'];?></td>
			<td><?php echo $option['icon'];?></td>
			<td><?php echo $option['text'];?></td>
			<td>
				<div class="btn-group">
					<?php
						echo anchor("option/edit/".$option['id'], '<span class="glyphicon glyphicon-pencil"></span>', 'class="btn btn-default btn-xs" title="Bearbeiten"');
						echo '<a class="btn btn-default btn-xs" title="Löschen" data-toggle="modal" href="#deleteModal'.$option['id'].'"><span class="glyphicon glyphicon-trash"></span></a>';
					?>
				</div>
			</td>
		</tr>
	<?php endforeach;?>
</table>

<p><?php echo anchor('option/add/'.$page['id'], '<span class="glyphicon glyphicon-plus"></span> Add option', 'class="btn btn-default"'); ?></p>

<?php foreach ($options as $option):?>
<div class="modal fade" id="deleteModal<?php echo $option['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModal<?php echo $option['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteModal<?php echo $option['id']; ?>Label">Option löschen: (<?php echo $option['text']; ?>)</h4>
			</div>
			<div class="modal-body">
				<p>
					Option wirklich löschen?
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Abbrechen</a>
				<?php echo anchor('option/delete/'.$option['id'], 'Löschen', 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach;?>