<h1>Edit consequence for option</h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(uri_string(), 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="attribute" class="col-sm-2 control-label">Attribute</label>
		<div class="col-sm-10">
			<select name="attribute" id="attribute" class="form-control">
				<?php foreach ($attributes as $a) { ?>
				<option value="<?php echo $a['id']; ?>"<?php if ($a['id'] == $attribute['value']) { ?> selected="selected"<?php } ?>>
					<?php echo $a['name']; ?>
				</option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="operator" class="col-sm-2 control-label">Comparison</label>
		<div class="col-sm-10">
			<select name="operator" id="operator" class="form-control">
				<?php foreach ($operators as $o) { ?>
				<option value="<?php echo $o['id']; ?>"<?php if ($o['id'] == $operator['value']) { ?> selected="selected"<?php } ?>>
					<?php echo $o['name']; ?>
				</option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="value" class="col-sm-2 control-label">Value</label>
		<div class="col-sm-10">
			<?php echo form_input($value, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
			<?php echo form_submit('submit', 'Change', 'class="btn btn-default"');?>
		</div>
	</div>
<?php echo form_close();?>