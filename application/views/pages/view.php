
			<?php if ($page['title'] || $page['content']) { ?>
			<?php if ($this->ion_auth->logged_in()) { ?><p><i>(<?php echo $page['title']; ?>)</i></p><?php } ?>
			<p>
				<?php echo $page['content']; ?>
			</p>
			<?php if ($options) { ?>
			<ul>
				<?php foreach($options as $option) { ?>
				<li><a href="<?php echo base_url().'index.php/page/option/'.$option['id']; ?>"><?php echo $option['text']; ?></a></li>
				<?php } ?>
			</ul>
			<?php } ?>
			<?php } else { ?>
			<h1>Sorry :(</h1>
			<p>There are no pages available or the start page isn't set correctly.</p>
			<?php } ?>
			