<h1><?php echo lang('page_options_attribute_edit'); ?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open('attribute/edit/'.$attribute['id'], 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="name" class="col-sm-2 control-label"><?php echo lang('assets_name'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($name, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="description" class="col-sm-2 control-label"><?php echo lang('assets_desc'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($description, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="value" class="col-sm-2 control-label"><?php echo lang('form_default_value'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($value, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
			<?php echo form_submit('submit', lang('form_apply'), 'class="btn btn-default"');?>
		</div>
	</div>
<?php echo form_close();?>