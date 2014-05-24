<h1 class="achievements-title"><?php echo lang('user_achievements'); ?></h1>

<div class="row">
	<?php
		$xs_size = 6;
		$sm_size = 4;
		$md_size = 2;
		$lg_size = 2;
		$counter = 0;
	?>
	<?php foreach ($achievements as $achievement) { ?>
	<?php $counter++; ?>
	<div class="achievement-entity col-xs-<?php echo $xs_size ?> col-sm-<?php echo $sm_size ?> col-md-<?php echo $md_size ?> col-lg-<?php echo $lg_size ?>">
		<img src="<?php echo base_url('assets/achievements/mobile/'.$achievement['mobile_uri']); ?>" class="achievement-image img-responsive"<?php if (!$achievement['unlocked']) { ?> style="opacity:0.4;"<?php } ?> />
		<h4 class="achievement-title"><?php echo ($achievement['unlocked']) ? $achievement['name'] : '???';?></h4>
		<p class="achievement-content"><?php echo ($achievement['unlocked']) ? $achievement['description'] : '???';?></p>
	</div>
	<?php if ($counter % (12 / $xs_size) == 0) { ?>
	<div class="clearfix visible-xs"></div>
	<?php } ?>
	<?php if ($counter % (12 / $sm_size) == 0) { ?>
	<div class="clearfix visible-sm"></div>
	<?php } ?>
	<?php if ($counter % (12 / $md_size) == 0) { ?>
	<div class="clearfix visible-md"></div>
	<?php } ?>
	<?php if ($counter % (12 / $lg_size) == 0) { ?>
	<div class="clearfix visible-lg"></div>
	<?php } ?>
	<?php } ?>
</div>