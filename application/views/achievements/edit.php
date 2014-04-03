<h1><?php echo lang('achievement_edit'); ?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open_multipart(uri_string(), 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="name" class="col-sm-2 control-label"><?php echo lang('achievement_file'); ?></label>
		<div class="col-sm-10">
			<?php if ($achievement['mobile_uri']) { ?>
			<img src="<?php echo base_url('assets/achievements/mobile/'.$achievement['mobile_uri']); ?>" class="img-responsive" />
			<?php } ?>
			<input type="file" name="userfile" size="10"/>
			<p class="help-block"><?php echo lang('achievement_different_file'); ?>. Max 2MB.</p>
		</div>
	</div>
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label"><?php echo lang('achievement_name'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($name, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="description" class="col-sm-2 control-label"><?php echo lang('achievement_desc'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($description, '', 'class="form-control"');?>
		</div>
	</div>
		<div class="form-group">
		<label for="attribute" class="col-sm-2 control-label"><?php echo lang('achievement_attribute'); ?></label>
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
		<label for="comparison" class="col-sm-2 control-label"><?php echo lang('achievement_comparison'); ?></label>
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
		<label for="value" class="col-sm-2 control-label"><?php echo lang('achievement_value'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($value, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
			<?php echo form_submit('submit', lang('achievement_add'), 'class="btn btn-default"');?>
		</div>
	</div>
<?php echo form_close();?>