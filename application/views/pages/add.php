<h1>Add new page</h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("page/add", 'class="form-horizontal" role="form"');?>
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
			<?php echo form_submit('submit', 'Add page', 'class="btn btn-default"');?>
		</div>
	</div>
<?php echo form_close();?>