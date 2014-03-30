<!DOCTYPE HTML>
<html lang="de-CH">
<head>
	<title>MLStorytelling<?php if ($this->ion_auth->logged_in() || $this->router->class == "admin") { ?> (StoryAdmin)<?php } ?></title>
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
	<?php if ($this->router->class == "page") { ?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/layout.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
	<?php } ?>
    
    <?php if($this->router->class == "page" && $this->router->method == "edit") { ?>
    <!-- Iconpicker stuff -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/iconselect.css">
    <?php } ?>

	</head>
	<body>
	
	<?php if ($this->ion_auth->logged_in() || $this->router->class == "admin") { ?>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<?php if ($this->ion_auth->logged_in()) { ?>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php } ?>
				<a href="<?php echo base_url(); ?>" class="navbar-brand"><span class="glyphicon glyphicon-book"></span> StoryAdmin</a>
			</div>
			
			<?php if ($this->ion_auth->logged_in()) { ?>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-left">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-book"></span> <?php echo lang('menu_story');?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo anchor('story/overview', '<span class="glyphicon glyphicon-map-marker"></span> '.lang('menu_story_overview')); ?></li>
							<li><?php echo anchor('story/list_pages', '<span class="glyphicon glyphicon-list"></span> '.lang('menu_story_list_pages')); ?></li>
							<li class="divider"></li>
							<li><?php echo anchor('page/add', '<span class="glyphicon glyphicon-plus"></span> '.lang('menu_story_add_page')); ?></a></li>
							<li><?php echo anchor('attribute', '<span class="glyphicon glyphicon-tasks"></span> Manage attributes'); ?></a></li>
							<li class="divider"></li>
							<li><?php echo anchor('story/settings', '<span class="glyphicon glyphicon-cog"></span> '.lang('menu_story_settings')); ?></li>
						</ul>
					</li>
					<?php if($this->router->class == "page" && $this->router->method == "show" && $page) { ?>
					<li><?php echo anchor('page/edit/'.$page['id'], '<span class="glyphicon glyphicon-pencil"></span> '.lang('menu_edit_page')); ?></li>
					<?php if($page['id'] != $this->settings_model->get_value('start_page')) { ?>
					<li><a data-toggle="modal" data-target="#deletePageModal"><span class="glyphicon glyphicon-trash"></span> <?php echo lang('menu_delete_page'); ?></a></li>
					<?php } ?>
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
	
	<?php if ($this->ion_auth->logged_in()) { ?>
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


