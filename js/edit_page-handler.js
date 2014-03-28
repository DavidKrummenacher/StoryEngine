//
//  iconselect-handler.js
//
//  
//
(function($){
	
	
  $(document).ready(function(){
   		//Ini IconSelect to fetch Icon Data
   		if($('.extraOption').length > 1) {
		iniIconSelect();
		}
		
		$(document).ready(function () {
     /*
	 $('<div/>', {
         'class' : 'extraOption', html: GetHtml()
     }).appendTo('#options-fields');
	 */
	 
     $('#addRow').click(function () {
           $('<div/>', {
               'class' : 'extraOption', html: GetHtml()
     }).hide().appendTo('#options-fields').slideDown('slow','swing',function() {
		 	//Ini single IconSelect
			var number = ($('.extraOption').length-1).toString();
			NewiconSelect = new IconSelect("my-icon-select_"+number, 
                {'selectedIconWidth':20,
                'selectedIconHeight':20,
                'selectedBoxPadding':2,
                'iconsWidth':48,
                'iconsHeight':48,
                'boxIconSpace':1,
                'vectoralIconNumber':2,
                'horizontalIconNumber':6});
				
			NewiconSelect.COMPONENT_ICON_FILE_PATH = "../../../img/controls/arrow.png";
			var icons = [];
			icons = fetchIcons();
			
			NewiconSelect.refresh(icons);	
			
			//End Ini
			});
         
     });
		 })
		 function GetHtml()
		{
			var len = $('.extraOption').length;
			var $html = $('.extraOptionTemplate').clone();
			$html.find('[name=page_desc]')[0].name="page_desc" + len;
			$html.find('[name=selected-text_]')[0].name="selected-text_" + len;
			$html.find('[id=selected-text_]')[0].id="selected-text_" + len;
			$html.find('[id=my-icon-select_]')[0].id = "my-icon-select_" + len;
			$html.find('[name=option_target]')[0].name="option_target" + len;
			return $html.html();    
			
			
		}

        }); //Doc ready
            
  

})(this.jQuery)

