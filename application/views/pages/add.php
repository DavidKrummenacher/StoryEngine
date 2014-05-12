<h1><?php echo lang('page_add_new'); ?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("page/add", 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label"><?php echo lang('page_title'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($title, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="description" class="col-sm-2 control-label"><?php echo lang('page_desc'); ?></label>
		<div class="col-sm-10">
			<?php echo form_input($description, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="content" class="col-sm-2 control-label"><?php echo lang('page_content'); ?></label>
		<div class="col-sm-10">
			<?php echo form_textarea($content, '', 'rows="12" class="form-control"');?>
		</div>
	</div>
     <!-- Select Image -->
    <div class="form-group">
		<label for="icon" class="col-sm-2 control-label"><?php echo lang('page_options_icon'); ?></label>
		<div class="col-sm-10">
			<select name="page_image" id="page_image" class="form-control">
				<option value="null" <?php if ($page['image'] == null) { ?> selected="selected"<?php } ?>><?php echo lang('page_options_noimage'); ?></option>
				<?php foreach ($page_images as $i) { ?>
				<option value="<?php echo $i['id']; ?>" data-img-src="<?php echo base_url();?>/assets/page_images/mobile/<?php echo $i['desktop_uri']; ?>" <?php if ($i['id'] == $page['image']) { ?> selected="selected"<?php } ?>>
					<?php echo $i['name']; ?>
				</option>
				<?php } ?>
			</select>
		</div>
	</div>
    
    <!-- //END Select Image -->
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
			<?php echo form_submit('submit', lang('page_add'), 'class="btn btn-default"');?>
		</div>
	</div>
<?php echo form_close();?>