<h1>Batch upload page images</h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open_multipart(uri_string(), 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="name" class="col-sm-2 control-label">Files</label>
		<div class="col-sm-10">
			<input type="file" name="userfiles[]" size="10" multiple="" />
			<p class="help-block">Select files to upload. Max 2MB per file.</p>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
			<?php echo form_submit('submit', 'Start batch', 'class="btn btn-default"');?>
		</div>
	</div>
<?php echo form_close();?>