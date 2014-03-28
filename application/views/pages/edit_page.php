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
                            <textarea class="form-control" name="page_content">
                                <?php echo $page['content']; ?>
                            </textarea>
                        </div>
                </div>
                
              
            </div>
			<?php if ($options) { 
			$optioncount = 0;
			?>
	            <fieldset>
				
				<?php //Iterate through Options
				foreach($options as $option) { 
				$optioncount++;?>
 
                
                    <div class="form-group">

                        <label for="page_desc" class="col-sm-2 control-label">
                            <em><?php echo $option['id']; ?></em> | <?php echo lang('form_label_page_display_text'); ?>
                         </label>
                         
                        
                         <div class="col-sm-2">
                           	<input type="text" class="form-control" name="page_desc" value="<?php echo $option['text']; ?>"/>                                
                         </div>
                         <div class="col-sm-2">
                          <div id="my-icon-select_<?php echo $optioncount; ?>" ></div>
           				<input type="text" id="selected-text_<?php echo $optioncount; ?>" name="selected-text_<?php echo $optioncount; ?>" style="display:none;">
                    </div>
                     </div>
                        
				<?php } ?>
                            </fieldset>

				<div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-default"><?php echo lang('menu_system_save'); ?></button>
                    </div>
                  </div>   
            </form>
			<?php } ?>
			<?php } else { ?>
			<h1>Sorry :(</h1>
			<p>There are no pages available or the start page isn't set correctly.</p>
			<?php } ?>
			
<script type="text/javascript"> 
	var iconSelect;
    var selectedText;
	
function iniIconSelect()
{
	
for(var i = 1; i <= <?php echo $optioncount; ?>;i++)
	{
	selectedText = $('#selectedText_'+i);
		$('#my-icon-select_'+i).change(function() {
		  selectedText.value = iconSelect.getSelectedValue();
			}); //end on.Change()
			
		iconSelect = new IconSelect("my-icon-select_"+i, 
                {'selectedIconWidth':23,
                'selectedIconHeight':23,
                'selectedBoxPadding':1,
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


function fetchIcons() {
   
   var icons = [];

<?php foreach($icons as $icon) { ?>
	
	 icons.push({'iconFilePath':'<?php echo base_url().$icon['desktop_uri']; ?>', 'iconValue':'1'});
	
<?php } ?>
	return icons;
}
</script>