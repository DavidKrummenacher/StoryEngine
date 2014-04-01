<h1><?php echo lang('pages_checks_editya'); ?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(uri_string(), 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="order" class="col-sm-2 control-label"><?php echo lang('page_options_attribute'); ?></label>
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
		<label for="icon" class="col-sm-2 control-label"><?php echo lang('page_options_comparison'); ?></label>
		<div class="col-sm-10">
			<select name="comparison" id="comparison" class="form-control">
				<?php foreach ($comparisons as $c) { ?>
				<option value="<?php echo $c['id']; ?>"<?php if ($c['id'] == $comparison['value']) { ?> selected="selected"<?php } ?>>
					<?php echo $c['name']; ?>
				</option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="text" class="col-sm-2 control-label"><?php echo lang('page_options_value'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($value, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="random" class="col-sm-2 control-label"><?php echo lang('page_options_random'); ?></label>
		<div class="col-sm-10">
			<div class="checkbox">
				<?php echo form_checkbox($random);?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
			<?php echo form_submit('submit',lang('form_change'), 'class="btn btn-default"');?>
		</div>
	</div>
<?php echo form_close();?>