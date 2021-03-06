
			<?php if ($page) { ?>
			<?php if ($this->ion_auth->is_author()) { ?>
			<div class="row page-title">
				<div class="col-xs-12">
					<p><i>(<?php echo $page['title']; ?>)</i></p>
				</div>
			</div>
			<?php } ?>
			<?php
			if ($image) { ?>
			<div class="row page-image">
				<div class="col-xs-12">   
					<img src="<?php echo base_url('assets/page_images/')."/".$device."/".$image['desktop_uri']; ?>" class="img-responsive page-illustration" />
				</div>
			</div>
			<?php } ?>
			<div class="row page-content">
			<div class="col-xs-12 col-md-<?php if ($options) { echo '6'; } else { echo '12'; } ?> page-txt">
			<p>
				<span class="firstcharacter"><?php echo substr($page['content'],0,1); ?> </span> <?php  echo substr($page['content'],1); ?>
			</p>
			</div>
			<?php if ($options) { ?>
			<div class="col-xs-12 col-md-6 page-options">
			<div class="list-group">
            
				<?php foreach($options as $option) { ?>
                <div class="list-group-item col-xs-12">
				<a href="<?php echo base_url().'index.php/option/choose/'.$option['id']; ?>" class="option-icon-container col-md-2 col-sm-1 col-xs-2">
                    <img src="<?php echo base_url('assets/icons/')."/".$device."/".$option['icon']; ?>" alt="icon" class="option-icon"/>
				</a>
                <a href="<?php echo base_url().'index.php/option/choose/'.$option['id']; ?>" class="option-txt-container col-md-10 col-sm-11 col-xs-10">
                <?php if (!$option['has_targets']) { ?><span class="label label-danger"><span class="glyphicon glyphicon-link"></span></span><?php } ?>
                <?php echo $option['text']; ?>
                </a>
                </div>
				<?php } ?>
			</div>
			</div>
			<?php } ?>
			</div>
			<?php } else { ?>
			<h1>Sorry :(</h1>
			<p>There are no pages available or the start page isn't set correctly.</p>
			<?php } ?>
			