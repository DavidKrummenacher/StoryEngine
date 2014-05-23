<h1><?php echo lang('user_achievements'); ?></h1>

<div class="row">
	<?php foreach ($achievements as $achievement) { ?>
	<div class="col-xs-2">
		<img src="<?php echo base_url('assets/achievements/mobile/'.$achievement['mobile_uri']); ?>" class="img-responsive"<?php if (!$achievement['unlocked']) { ?> style="opacity:0.4;"<?php } ?> />
		<h4><?php echo ($achievement['unlocked']) ? $achievement['name'] : '???';?></h4>
		<p><?php echo ($achievement['unlocked']) ? $achievement['description'] : '???';?></p>
	</div>
	<?php } ?>
</div>