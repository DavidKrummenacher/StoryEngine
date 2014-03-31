<h1>Overview of all pages</h1>

<div id="graph-data" class="hidden">
<ul>
<?php foreach ($relations as $relation) { 
	
?>
<li name="<?php echo $relation['source_page'] ?>" title="<?php if($relation['description']) { echo $relation['description']; } else { echo "Non-existent"; } ?>"><?php echo $relation['target_page'] ?></li>
<?php } ?>
</ul>
</div>

<div class="container">
  <canvas id="viewport" width="2000" height="1600" class="img-responsive"></canvas>
  </div>
 
