<h1>Edit target for option</h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(uri_string(), 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="target_page" class="col-sm-2 control-label">Target</label>
		<div class="col-sm-10">
			<select name="target_page" id="target_page" class="form-control">
				<?php foreach ($pages as $p) { ?>
				<option value="<?php echo $p['id']; ?>"<?php if ($p['id'] == $target_page['value']) { ?> selected="selected"<?php } ?>>
					<?php echo $p['title']; ?>
				</option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="fail" class="col-sm-2 control-label">Is fail page?</label>
		<div class="col-sm-10">
			<div class="checkbox">
				<?php echo form_checkbox($fail);?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
			<?php echo form_submit('submit', 'Change', 'class="btn btn-default"');?>
		</div>
	</div>
<?php echo form_close();?>