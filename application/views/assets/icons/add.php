<h1><?php echo lang('page_options_addicon'); ?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open_multipart(uri_string(), 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="name" class="col-sm-2 control-label"><?php echo lang('page_options_file'); ?></label>
		<div class="col-sm-10">
			<input type="file" name="userfile" size="10"/>
			<p class="help-block"><?php echo lang('page_options_select_file'); ?> Max 2MB.</p>
		</div>
	</div>
	<div class="form-group">
		<label for="name" class="col-sm-2 control-label"><?php echo lang('form_input_name'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($name, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="description" class="col-sm-2 control-label"><?php echo lang('page_desc'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($description, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
			<?php echo form_submit('submit', lang('form_add'), 'class="btn btn-default"');?>
		</div>
	</div>
<?php echo form_close();?>