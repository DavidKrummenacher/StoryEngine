
			<?php if ($page['title'] || $page['content']) { ?>
			<h1><?php echo $page['title']; ?></h1>
			<p>
				<?php echo $page['content']; ?>
			</p>
			<?php if ($options) { ?>
			<ul>
				<?php foreach($options as $option) { ?>
				<li><a href="<?php echo base_url().'index.php/page/show/'.$option['target']; ?>"><?php echo $option['text']; ?></a></li>
				<?php } ?>
			</ul>
			<?php } ?>
			<?php } else { ?>
			<h1>Sorry :(</h1>
			<p>There are no pages available or the start page isn't set correctly.</p>
			<?php } ?>
			