<h1>Overview of all pages</h1>

<div id="graph-data" class="hidden">
<ul>
<?php foreach ($relations as $relation) { 
	
?>
<li name="<?= $relation['source_page'] ?>" title="<?= $relation['description'] ?>"><?= $relation['target_page'] ?></li>
<?php } ?>
</ul>
</div>

<div class="container">
  <canvas id="viewport" width="2000" height="1600" class="img-responsive"></canvas>
  </div>
 
