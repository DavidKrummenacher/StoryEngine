<h1><?php echo lang('menu_edit_page'); ?>: #<?php echo $page['id']; ?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open('page/edit/'.$page['id'], 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label"><?php echo lang('page_title'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($title, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="description" class="col-sm-2 control-label"><?php echo lang('page_desc'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($description, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="content" class="col-sm-2 control-label"><?php echo lang('page_content'); ?></label>
		<div class="col-sm-10">
			<?php echo form_textarea($content, '', 'rows="12" class="form-control"');?>
		</div>
	</div>
    <!-- Select Image -->
    <div class="form-group">
		<label for="icon" class="col-sm-2 control-label"><?php echo lang('page_options_icon'); ?></label>
		<div class="col-sm-10">
			<select name="page_image" id="page_image" class="form-control">
				<option value="null" <?php if ($page['image'] == null) { ?> selected="selected"<?php } ?>><?php echo lang('page_options_noimage'); ?></option>
				<?php foreach ($page_images as $i) { ?>
				<option value="<?php echo $i['id']; ?>" data-img-src="<?php echo base_url();?>/assets/page_images/mobile/<?php echo $i['desktop_uri']; ?>" <?php if ($i['id'] == $page['image']) { ?> selected="selected"<?php } ?>>
					<?php echo $i['name']; ?>
				</option>
				<?php } ?>
			</select>
		</div>
	</div>
    
    <!-- //END Select Image -->
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
			<button type="submit" class="btn btn-default"><?php echo lang('menu_system_save'); ?></button>
		</div>
	</div>  
<?php echo form_close();?>

<ul class="nav nav-tabs">
	<li class="active"><a href="#options" data-toggle="tab"><?php echo lang('page_options'); ?></a></li>
	<li><a href="#consequences" data-toggle="tab"><?php echo lang('page_consequences'); ?></a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="options">
		<table class="table table-condensed">
			<tr>
				<th><?php echo lang('page_options_order'); ?></th>
				<th><?php echo lang('page_options_icon'); ?></th>
				<th><?php echo lang('page_options_text'); ?></th>
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
		<p><?php echo anchor('option/add/'.$page['id'], '<span class="glyphicon glyphicon-plus"></span> '.lang('form_label_page_add_option'), 'class="btn btn-default"'); ?></p>
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
								echo anchor("page/edit_consequence/".$consequence['id'], '<span class="glyphicon glyphicon-pencil"></span>', 'class="btn btn-default btn-xs" title="Bearbeiten"');
								echo '<a class="btn btn-default btn-xs" title="Löschen" data-toggle="modal" href="#deleteConsequenceModal'.$consequence['id'].'"><span class="glyphicon glyphicon-trash"></span></a>';
							?>
						</div>
					</td>
				</tr>
			<?php endforeach;?>
		</table>
		<p><?php echo anchor('page/add_consequence/'.$page['id'], '<span class="glyphicon glyphicon-plus"></span> '.lang('page_options_add_consequence'), 'class="btn btn-default"'); ?></p>
	</div>
</div>
		
<?php foreach ($options as $option):?>
<div class="modal fade" id="deleteModal<?php echo $option['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModal<?php echo $option['id']; ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteModal<?php echo $option['id']; ?>Label"><?php echo lang('modal_optiondelete'); ?>: (<?php echo $option['text']; ?>)</h4>
			</div>
			<div class="modal-body">
				<p>
					<?php echo lang('modal_optiondelete_confirm'); ?>
				</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal"><?php echo lang('form_cancel'); ?></a>
				<?php echo anchor('option/delete/'.$option['id'], lang('form_delete'), 'class="btn btn-primary"'); ?>
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
				<?php echo anchor('page/delete_consequence/'.$consequence['id'], lang('form_delete'), 'class="btn btn-primary"'); ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach;?>