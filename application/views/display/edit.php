<h1>Edit page design</h1>

<?php if ($message != "") { ?>
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo $message;?>
</div>
<?php } ?>

<?php echo form_open('display/edit', 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="content" class="col-sm-2 control-label">CSS</label>
		<div class="col-sm-10">
			<?php echo form_textarea($css, '', 'rows="12" class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<div class="btn-group">
				<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
				<!--<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-eye-open"></span> Preview</button>-->
			</div>
		</div>
	</div>
<?php echo form_close();?>