<h1><?php echo lang('page_options_add'); ?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(uri_string(), 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="order" class="col-sm-2 control-label"><?php echo lang('page_options_order'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($order, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="icon" class="col-sm-2 control-label"><?php echo lang('page_options_icon'); ?></label>
		<div class="col-sm-10">
			<select name="icon" id="icon" class="form-control">
				<option value="null" <?php if ($icon['value'] == null) { ?> selected="selected"<?php } ?>><?php echo lang('page_options_noicon'); ?></option>
				<?php foreach ($icons as $i) { ?>
				<option value="<?php echo $i['id']; ?>" data-img-src="<?php echo base_url();?>/assets/icons/desktop/<?php echo $i['desktop_uri']; ?>" <?php if ($i['id'] == $icon['value']) { ?> selected="selected"<?php } ?>>
					<?php echo $i['name']; ?>
				</option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="text" class="col-sm-2 control-label"><?php echo lang('page_options_text'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($text, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
			<?php echo form_submit('submit', lang('form_add'), 'class="btn btn-default"');?>
		</div>
	</div>
<?php echo form_close();?>
