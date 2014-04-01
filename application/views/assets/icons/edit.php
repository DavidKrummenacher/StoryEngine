<h1>Edit icon</h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open_multipart(uri_string(), 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="name" class="col-sm-2 control-label">File</label>
		<div class="col-sm-10">
			<?php if ($icon['mobile_uri']) { ?>
			<img src="<?php echo $icon['mobile_uri']; ?>" class="img-responsive" />
			<?php } ?>
			<input type="file" name="userfile" size="10"/>
			<p class="help-block">Select different file to change it. Max 2MB.</p>
		</div>
	</div>
	<div class="form-group">
		<label for="name" class="col-sm-2 control-label">Name</label>
		<div class="col-sm-10">
			<?php echo form_input($name, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="description" class="col-sm-2 control-label">Description</label>
		<div class="col-sm-10">
			<?php echo form_input($description, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
			<?php echo form_submit('submit', 'Apply', 'class="btn btn-default"');?>
		</div>
	</div>
<?php echo form_close();?>