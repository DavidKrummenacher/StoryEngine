<h1><?php echo lang('story_settings'); ?></h1>
<?php
if(isset($flash)) {?> 
<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> <?php echo $flash ?></div>
<?php }
?>
<form action ="<?php echo base_url()?>index.php/story/settings" method="post" id="story_set">
	<div class="form-group">
        <div class="input-group">
        	<span class="input-group-addon">Story title</span>
        	<input type="text" class="form-control" name="<?php echo $story_title['key']; ?>" value="<?php echo $story_title['value']; ?>"/>
		</div><!-- /input-group -->
	</div>
    
 <!-- Select Image -->
    <div class="form-group">
                         <span class="input-group-addon" style="float:left;width:120px;">Cover Image</span>

		<div class="input-group">                     
			<select name="<?php echo $story_cover['key']; ?>" id="default_icon" class="form-control">
				<option value="null" <?php if ($story_cover['value'] == null) { ?> selected="selected"<?php } ?>><?php echo lang('page_options_noimage'); ?></option>
				<?php foreach ($page_images as $i) { ?>
				<option value="<?php echo $i['id']; ?>" data-img-src="<?php echo base_url();?>assets/page_images/mobile/<?php echo $i['mobile_uri']; ?>" <?php if ($i['id'] == $story_cover['value']) { ?> selected="selected"<?php } ?>>
					<?php echo $i['name']; ?>
				</option>
				<?php } ?>
			</select>
		</div>
	</div>
    
    <!-- //END Select Image -->
<?php foreach($settings as $set) {?>



<?php if($set['key'] == 'default_icon') { ?>
<!-- Select Image -->
    <div class="form-group">
                         <span class="input-group-addon" style="float:left;width:120px;"><?php echo ucfirst(str_replace('_', ' ',$set['key'])); ?></span>

		<div class="input-group">                     
			<select name="default_icon" id="default_icon" class="form-control">
				<option value="null" <?php if ($set['value'] == null) { ?> selected="selected"<?php } ?>><?php echo lang('page_options_noimage'); ?></option>
				<?php foreach ($icons as $i) { ?>
				<option value="<?php echo $i['id']; ?>" data-img-src="<?php echo base_url();?>assets/icons/mobile/<?php echo $i['mobile_uri']; ?>" <?php if ($i['id'] == $set['value']) { ?> selected="selected"<?php } ?>>
					<?php echo $i['name']; ?>
				</option>
				<?php } ?>
			</select>
		</div>
	</div>
    
    <!-- //END Select Image -->
	
<?php	} else { ?>

<div class="form-group">

        <div class="input-group">
        <!-- <label for="<?php echo $set['key']; ?>"><?php echo ucfirst(str_replace('_', ' ',$set['key'])); ?></label> -->
        
             <span class="input-group-addon"><?php echo ucfirst(str_replace('_', ' ',$set['key'])); ?></span>
            <input type="text" class="form-control" name="<?php echo $set['key']; ?>" value="<?php echo $set['value']; ?>"/>
          
        </div><!-- /input-group -->
    </div>
    <?php } ?>

<?php } ?>  

 

<span class="input-group-btn">
		<button class="btn btn-default" type="submit" ><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('form_save'); ?></button>
	</span>	
    </div>
</form>
