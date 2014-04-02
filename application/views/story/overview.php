<h1><?php echo lang('story_overview');  ?></h1>

<div id="graph-data" class="hidden">
<ul>
<?php foreach ($pages as $page) { ?>
<li title="<?php echo $page['description']; ?>"><?php echo $page['id'] ?></li>
<?php } ?>
</ul>


</div>


<!-- Option Nodes -->
<div id="graph-data-options" class="hidden">
    <ul>
		<?php foreach ($options as $option) { ?>
      	  <li name="<?php echo $option['source_page'] ?>" title="<?php echo $option['id']; ?>.<?php echo $option['text']; ?>"><?php echo $option['id']; ?></li>
        <?php } ?>
    </ul>
</div>

<!-- Optiontargets Nodes -->
<div id="graph-data-optiontargets" class="hidden">
    <ul>
		<?php 
		foreach ($optiontargets as $odata) { ?>
      	  <li name="<?php echo $odata['option'] ?>"><?php echo $odata['target_page']; ?></li>
        <?php }  ?>
		</ul>
</div>

<!-- Optionchecks Nodes -->
<div id="graph-data-optionchecks" class="hidden">
    <ul>
		<?php 
		foreach ($optionchecks as $ocdata) { ?>
      	  <li name="<?php echo $ocdata['option'] ?>" title="<?php echo $ocdata['attribute'] ?>"><?php echo $ocdata['id'] ?></li>
        <?php }  ?>
		</ul>
</div>

<!-- Optionconditions Nodes -->
<div id="graph-data-optionconditions" class="hidden">
    <ul>
		<?php 
		foreach ($optionconditions as $ocodata) { ?>
      	  <li name="<?php echo $ocodata['option'] ?>" title="<?php echo $ocodata['attribute'] ?>"><?php echo $ocodata['id'] ?></li>
        <?php }  ?>
		</ul>
</div>

<!-- Optionconsequence Nodes -->
<div id="graph-data-optionconsequences" class="hidden">
    <ul>
		<?php 
		foreach ($optionconsequences as $ocondata) { ?>
      	  <li name="<?php echo $ocondata['option'] ?>" title="<?php echo $ocondata['attribute'] ?>"><?php echo $ocondata['id'] ?></li>
        <?php }  ?>
		</ul>
</div>

<div class="container">
  <canvas id="viewport" width="2000" height="3000" class="img-responsive"></canvas>
  </div>
 
