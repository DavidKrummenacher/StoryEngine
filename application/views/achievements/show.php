<h1><?php echo lang('user_achievements'); ?></h1>

<div class="row">
	<?php foreach ($achievements as $achievement) { ?>
	<div class="col-xs-2">
		<?php $unlocked = false; // TODO: Check if its unlocked ?>
		<img src="<?php echo base_url('assets/achievements/mobile/'.$achievement['mobile_uri']); ?>" class="img-responsive"<?php if (!$unlocked) { ?> style="opacity:0.4;"<?php } ?> />
		<h4><?php echo ($unlocked) ? $achievement['name'] : '???';?></h4>
		<p><?php echo ($unlocked) ? $achievement['description'] : '???';?></p>
	</div>
	<?php } ?>
</div>