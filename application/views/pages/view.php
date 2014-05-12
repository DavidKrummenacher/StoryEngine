
			<?php if ($page) { ?>
			<?php if ($this->ion_auth->is_author()) { ?>
			<div class="row">
				<div class="col-xs-12">
					<p><i>(<?php echo $page['title']; ?>)</i></p>
				</div>
			</div>
			<?php } ?>
			<?php
			if ($image) { ?>
			<div class="row">
				<div class="col-xs-12">
                
					<img src="<?php echo base_url('assets/page_images/')."/".$device."/".$image['desktop_uri']; ?>" class="img-responsive" />
				</div>
			</div>
			<?php } ?>
			<div class="row">
			<div class="col-xs-12 col-md-<?php if ($options) { echo '6'; } else { echo '12'; } ?>">
			<p>
				<?php echo $page['content']; ?>
			</p>
			</div>
			<?php if ($options) { ?>
			<div class="col-xs-12 col-md-6">
			<div class="list-group">
				<?php foreach($options as $option) { ?>
				
				<a href="<?php echo base_url().'index.php/option/choose/'.$option['id']; ?>" class="list-group-item">
					<!--<span class="glyphicon glyphicon-chevron-right"></span>-->
                    <img src="<?php echo base_url('assets/icons/')."/".$device."/".$option['icon']; ?>" alt="icon" />
					<?php echo $option['text']; ?>
				</a>
				<?php } ?>
			</div>
			</div>
			<?php } ?>
			</div>
			<?php } else { ?>
			<h1>Sorry :(</h1>
			<p>There are no pages available or the start page isn't set correctly.</p>
			<?php } ?>
			