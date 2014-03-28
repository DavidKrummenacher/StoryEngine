<h1>Edit Page: #<?php echo $page['id']; ?></h1>

			<?php if ($page['title'] || $page['content']) { ?>
			<?php if ($this->ion_auth->logged_in()) { ?>
            <?php } ?>
            <form action ="<?php echo base_url()?>index.php/page/edit_page/<?php echo $page['id']; ?>" method="post" id="edit_page" role="form" class="form-horizontal">

            <div class="form-group">
                <div class="form-group">
                        <label for="page_title" class="col-sm-2 control-label">Page Title</label>
                             <div class="col-sm-10">
                             	<input type="text" class="form-control" name="page_title" value="<?php echo $page['title']; ?>
"/>
                                </div>
                </div>
                <div class="form-group">
                        <label for="page_desc" class="col-sm-2 control-label">Description</label>
                             <div class="col-sm-10">
                             	<input type="text" class="form-control" name="page_desc" value="<?php echo $page['description']; ?>
"/>
                                </div>
                </div>
                <div class="form-group">
                        <label for="page_content" class="col-sm-2 control-label">Content</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="12" name="page_content"><?php echo $page['content']; ?></textarea>
                        </div>
                </div>
                
              
            </div>
		            <fieldset id="options-fields">

    		<?php
			$optioncount = 0;
			 if ($options) { 
			?>
				
				<?php //Iterate through Options
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
                        
				<?php $optioncount++; } 
				
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
				
				<div class="form-group">
                    <div class="col-sm-offset-2 col-sm-2">
                      <button type="submit" class="btn btn-default"><?php echo lang('menu_system_save'); ?></button>
                    </div>
                    <div class="col-sm-2">
                      <button type="button" id="addRow" class="btn btn-default"><?php echo lang('form_label_page_add_option'); ?></button>
                    </div>
                  </div>   
            </form>
            
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
	
function iniIconSelect()
{
	
for(var i = 0; i < <?php echo $optioncount; ?>;i++)
	{
	selectedText = $('#selectedText_'+i);
		$('#my-icon-select_'+i).change(function() {
		  selectedText.value = iconSelect.getSelectedValue();
			}); //end on.Change()
			
		iconSelect = new IconSelect("my-icon-select_"+i, 
                {'selectedIconWidth':20,
                'selectedIconHeight':20,
                'selectedBoxPadding':2,
                'iconsWidth':48,
                'iconsHeight':48,
                'boxIconSpace':1,
                'vectoralIconNumber':2,
                'horizontalIconNumber':6});
				
		IconSelect.COMPONENT_ICON_FILE_PATH = "../../../img/controls/arrow.png";
		var icons = [];
		icons = fetchIcons();
		iconSelect.refresh(icons);	
	}
}

</script>
			<?php } else { ?>
			<h1>Sorry :(</h1>
			<p>There are no pages available or the start page isn't set correctly.</p>
			<?php } ?>
<script type="text/javascript">

	


function fetchIcons() {
   
   var icons = [];

<?php foreach($icons as $icon) { ?>
	
	 icons.push({'iconFilePath':'<?php echo base_url().$icon['desktop_uri']; ?>', 'iconValue':'<?php echo $icon['id']; ?>'});
	
<?php } ?>
	return icons;
}
</script>			