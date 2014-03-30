<h1>Add option to page</h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open('option/add', 'class="form-horizontal" role="form"');?>
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
			<?php echo form_submit('submit', 'Add', 'class="btn btn-default"');?>
		</div>
	</div>
<?php echo form_close();?>