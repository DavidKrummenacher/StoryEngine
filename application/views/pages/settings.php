<h1>Settings</h1>
<?php
if(isset($flash)) {?> 
<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> <?php echo $flash ?></div>
<?php }
?>
<form action ="<?php echo base_url()?>index.php/page/settings" method="post" id="story_set">

<?php foreach($settings as $set) {?>
<div class="form-group">

<div class="input-group">
<!-- <label for="<?php echo $set['key']; ?>"><?php echo ucfirst(str_replace('_', ' ',$set['key'])); ?></label> -->

	 <span class="input-group-addon"><?php echo ucfirst(str_replace('_', ' ',$set['key'])); ?></span>
    <input type="text" class="form-control" name="<?php echo $set['key']; ?>" value="<?php echo $set['value']; ?>"/>
  
</div><!-- /input-group -->
    </div>

<?php } ?>  

<span class="input-group-btn">
		<button class="btn btn-default" type="submit" ><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
	</span>	
    </div>
</form>
