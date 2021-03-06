<!DOCTYPE HTML>
<html lang="de-CH">
<head>
	<title><?php echo $header_story_title; ?><?php if ($this->ion_auth->is_author() || $this->router->class == "admin") { ?> (StoryAdmin)<?php } ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="img/ico/favicon.ico" rel="icon" type="image/x-icon" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>img/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>img/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>img/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>img/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>img/ico/favicon.png">
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css">
	<?php
		if (
			($this->router->class == "page" && $this->router->method == "show") ||
			($this->router->class == "story" && $this->router->method == "login") ||
			($this->router->class == "story" && $this->router->method == "register") ||
			($this->router->class == "achievement" && $this->router->method == "show")
		) {
	?>
	<link rel="stylesheet" href="<?php echo site_url('display'); ?>">
	<?php } ?>
    
    <?php if($this->router->class == "option" || $this->router->class == "page" || $this->router->class == "story") { ?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/image-picker.css">
    
    <!-- Select2 stuff -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/select2.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/select2-bootstrap.css">
    
    <?php } ?>
    
    <?php if($this->router->class == "page" && $this->router->method == "edit") { ?>
    <!-- Iconpicker stuff -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/iconselect.css">
    <?php } ?>
   

	</head>
	<body>
	
	<?php if ($this->ion_auth->is_author() || $this->router->class == "admin") { ?>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<?php if ($this->ion_auth->is_author()) { ?>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php } ?>
				<a href="<?php echo base_url(); ?>" class="navbar-brand"><span class="glyphicon glyphicon-book"></span> StoryAdmin</a>
			</div>
			
			<?php if ($this->ion_auth->is_author()) { ?>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-left">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-book"></span> <?php echo lang('menu_story');?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo anchor('story/overview', '<span class="glyphicon glyphicon-map-marker"></span> '.lang('menu_story_overview')); ?></li>
							<li><?php echo anchor('story/list_pages/0', '<span class="glyphicon glyphicon-list"></span> '.lang('menu_story_list_pages')); ?></li>
							<li class="divider"></li>
							<li><?php echo anchor('page/add', '<span class="glyphicon glyphicon-plus"></span> '.lang('menu_story_add_page')); ?></a></li>
							<li class="divider"></li>
							<li><?php echo anchor('attribute', '<span class="glyphicon glyphicon-tasks"></span> '.lang('page_options_attribute_manage')); ?></a></li>
							<li><?php echo anchor('asset', '<span class="glyphicon glyphicon-picture"></span> '. lang('assets_manage')); ?></a></li>
							<li><?php echo anchor('achievement', '<span class="glyphicon glyphicon-bookmark"></span> '.lang('achievement_manage')); ?></a></li>
							<li class="divider"></li>
							<li><?php echo anchor('display/edit', '<span class="glyphicon glyphicon-th-large"></span> Design'); ?></li>
							<li><?php echo anchor('story/settings', '<span class="glyphicon glyphicon-cog"></span> '.lang('menu_story_settings')); ?></li>
						</ul>
                        
					</li>
                    <li class="dropdown">	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-flash"></span> Debugging <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><?php echo anchor('story/debug', '<span class="glyphicon glyphicon-tasks"></span> Attributes'); ?></li>
                                    <li><?php echo anchor('story/debugoptions', '<span class="glyphicon glyphicon-link"></span> Options'); ?></li>
                                 </ul>
                    </li>
					<?php if($this->router->class == "page" && $this->router->method == "show" && $page) { ?>
					<li><?php echo anchor('page/edit/'.$page['id'], '<span class="glyphicon glyphicon-pencil"></span> '.lang('menu_edit_page')); ?></li>
					<?php if($page['id'] != $this->settings_model->get_value('start_page')) { ?>
					<li><a data-toggle="modal" data-target="#deletePageModal"><span class="glyphicon glyphicon-trash"></span> <?php echo lang('menu_delete_page'); ?></a></li>
					<?php } ?>
					<?php } ?>
                    <?php if($this->router->class == "page" && $this->router->method == "edit" && $page) { ?> 
					<li><?php echo anchor('page/show/'.$page['id'], '<span class="glyphicon glyphicon-eye-open"></span> Show page'); ?></li>
					<?php } ?>
					<?php if($this->router->class == "option" && $this->router->method == "edit" && $option) { ?>
					<li><?php echo anchor('page/edit/'.$option['source_page'], '<span class="glyphicon glyphicon-chevron-left"></span> Back to page'); ?></li>
					<li><?php echo anchor('option/add/'.$option['source_page'], '<span class="glyphicon glyphicon-plus"></span> Add option'); ?></li>
					<?php } ?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php if ($this->ion_auth->is_admin()) { ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> <?php echo lang('menu_system');?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo anchor('admin/', '<span class="glyphicon glyphicon-list"></span> '.lang('menu_system_user_management')); ?></li>
							<li class="divider"></li>
							<li><?php echo anchor('#', '<span class="glyphicon glyphicon-cog"></span> '.lang('menu_system_settings')); ?></li>
						</ul>
					</li>
					<?php } ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo lang('menu_account');?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo anchor('admin/edit/'.$this->ion_auth->user()->row()->id, '<span class="glyphicon glyphicon-pencil"></span> '.lang('menu_account_profile')); ?></li>
							<li class="divider"></li>
							<li><?php echo anchor('admin/logout', '<span class="glyphicon glyphicon-log-out"></span> '.lang('menu_account_logout')); ?></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
			<?php } ?>
		</div><!-- /.container-fluid -->
	</nav>
	<?php } ?>
	
	<?php if ($this->ion_auth->is_author()) { ?>
	<?php if($this->router->class == "page" && $this->router->method == "show" && $page) { ?>
	<?php if($page['id'] != $this->settings_model->get_value('start_page')) { ?>
	<div class="modal fade" id="deletePageModal" tabindex="-1" role="dialog" aria-labelledby="deletePageModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="deletePageModalLabel">Seite löschen: (<?php echo $page['id'].' - '.$page['title']; ?>)</h4>
				</div>
				<div class="modal-body">
					<p>
						Seite wirklich löschen?
					</p>
				</div>
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Abbrechen</a>
					<?php echo anchor('page/delete/'.$page['id'], 'Löschen', 'class="btn btn-primary"'); ?>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php } ?>
	<?php } ?>
	
	<section class="container">
		<?php if ($this->ion_auth->logged_in()) { ?>
		<?php if(($this->router->class == "page" && $this->router->method == "show" && $page) || ($this->router->class == "achievement" && $this->router->method == "show")) { ?>
		<nav class="navbar user-nav" role="navigation">
			<div class="container-fluid">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog control-icon-settings">
                       </span></a>
						<ul class="dropdown-menu">
							<li>
								<?php echo anchor('menu/new_game', '<span class="glyphicon glyphicon-repeat"></span> '.lang('user_new_game')); ?>
							</li>
							<li>
								<?php echo anchor('menu/continue_game', '<span class="glyphicon glyphicon-refresh"></span> '.lang('user_continue_game')); ?>
							</li>
							<li>
								<?php echo anchor('story/logout', '<span class="glyphicon glyphicon-log-out"></span> '.lang('menu_account_logout')); ?>
							</li>
						</ul>
					</li>
					<li>
						<?php  echo anchor('achievement/show', '<span class="glyphicon glyphicon-bookmark control-icon-achievements"></span>'); ?>
					</li>
				</ul>
			</div><!-- /.container-fluid -->
		</nav>
		<?php } ?>
		<?php } ?>
