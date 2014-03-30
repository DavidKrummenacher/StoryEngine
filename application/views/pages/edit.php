<h1>Edit Page: #<?php echo $page['id']; ?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open('page/edit/'.$page['id'], 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Page Title</label>
		<div class="col-sm-10">
			<?php echo form_input($title, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="description" class="col-sm-2 control-label">Description</label>
		<div class="col-sm-10">
			<?php echo form_input($description, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="content" class="col-sm-2 control-label">Content</label>
		<div class="col-sm-10">
			<?php echo form_textarea($content, '', 'rows="12" class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<fieldset id="options-fields">
    	<?php
			$optioncount = 0;
			if ($options) {
				foreach($targets as $option) { 
		?>
			<div class="form-group extraOption">
				<label for="page_desc<?php echo $optioncount; ?>" class="col-sm-2 control-label">
					<em><?php echo $option['id']; ?></em> | <?php echo lang('form_label_page_display_text'); ?>
				</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" name="page_desc<?php echo $optioncount; ?>" value="<?php echo $option['text']; ?>"/>                                
				</div>
				<div class="col-sm-1">
					<div id="my-icon-select_<?php echo $optioncount; ?>" ></div>
					<input type="text" id="selected-text_<?php echo $optioncount; ?>" name="selected-text_<?php echo $optioncount; ?>" style="display:none;" value="<?php echo $option['icon'];?>">
				</div>
				<div class="input-group col-sm-2">                            
					<span class="input-group-addon"><?php echo lang('form_label_page_target_page'); ?></span>
					<input type="text" class="form-control" name="option_target<?php echo $optioncount; ?>" value="<?php echo $option['target_page']; ?>"/>
				</div>
			</div>

		<?php
					$optioncount++;
				}
			} else {
				$optioncount=1;
		?>
			<div class="form-group extraOption">
				<label for="page_desc0" class="col-sm-2 control-label">
					<em>&nbsp;</em> | <?php echo lang('form_label_page_display_text'); ?>
				</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" name="page_desc0" placeholder="<?php echo lang('form_label_page_display_text'); ?>"/>                                
				</div>
				<div class="col-sm-1">
					<div id="my-icon-select_0"></div>
					<input type="text" id="selected-text_0" name="selected-text_0" style="display:none;">
				</div>
				<div class="input-group col-sm-2">                            
					<span class="input-group-addon"><?php echo lang('form_label_page_target_page'); ?></span>
					<input type="text" class="form-control" name="option_target0" placeholder="#Page ID"/>
				</div>
			</div>
                     <?php
				}?>
		</fieldset>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
			<button type="submit" class="btn btn-default"><?php echo lang('menu_system_save'); ?></button>
		</div>
		<div class="col-sm-2">
			<button type="button" id="addRow" class="btn btn-default"><?php echo lang('form_label_page_add_option'); ?></button>
		</div>
	</div>   
<?php echo form_close();?>
            
<!-- Option Template -->
<div class="hidden">
	<div class="extraOptionTemplate">
		<div class="form-group">
			<label for="page_desc" class="col-sm-2 control-label">
				<em>&nbsp;</em> | <?php echo lang('form_label_page_display_text'); ?>
			</label>
			<div class="col-sm-2">
				<input type="text" class="form-control" name="page_desc" placeholder="<?php echo lang('form_label_page_display_text'); ?>"/>                                
			</div>
			<div class="col-sm-1">
				<div id="my-icon-select_" ></div>
				<input type="text" name="selected-text_" id="selected-text_" style="display:none;">
			</div>
			<div class="input-group col-sm-2">
				<span class="input-group-addon"><?php echo lang('form_label_page_target_page'); ?></span>
				<input type="text" class="form-control" name="option_target" placeholder="#Page ID"/>
			</div>
		</div>
	</div>
</div>
            
<script type="text/javascript"> 
var iconSelect;
var selectedText;

function iniIconSelect() {
	for(var i = 0; i < <?php echo $optioncount; ?>;i++) {
		selectedText = $('#selectedText_'+i);
		$('#my-icon-select_'+i).change(function() {
			selectedText.value = iconSelect.getSelectedValue();
		}); //end on.Change()
	
		iconSelect = new IconSelect("my-icon-select_"+i, {
			'selectedIconWidth':20,
			'selectedIconHeight':20,
			'selectedBoxPadding':2,
			'iconsWidth':48,
			'iconsHeight':48,
			'boxIconSpace':1,
			'vectoralIconNumber':2,
			'horizontalIconNumber':6
		});

		IconSelect.COMPONENT_ICON_FILE_PATH = "../../../img/controls/arrow.png";
		var icons = [];
		icons = fetchIcons();
		iconSelect.refresh(icons);
	}
}

</script>

<script type="text/javascript">
function fetchIcons() {
	var icons = [];
	
	<?php foreach($icons as $icon) { ?>
	icons.push({'iconFilePath':'<?php echo base_url().$icon['desktop_uri']; ?>', 'iconValue':'<?php echo $icon['id']; ?>'});
	<?php } ?>
	
	return icons;
}
</script>			