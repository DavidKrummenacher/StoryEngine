<h1><?php echo lang('story_overview');  ?></h1>
<form role="form">
  <div class="form-group">
<button type="button" class="btn btn-primary btn-sm" id="show_pages">Pages Only</button>
<button type="button" class="btn btn-default btn-sm" id="show_options">Pages & Options</button>
<input type="hidden" value="<?php echo $start_page; ?>" id="start_page" />
</div>
</form>
<div class="container">
    <div id="graph-container" style="height:600px">
    
    </div>
  
  </div>
 
