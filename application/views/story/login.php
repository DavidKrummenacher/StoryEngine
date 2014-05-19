			<div class="container col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
           
<?php if($cover_image != null) { ?> <img src="<?php echo base_url()."assets/page_images/mobile/".$cover_image['mobile_uri'] ?>" alt="Story Logo" class="img-responsive"/> <?php  } ?>
				<div class="panel panel-default">
                
					<div class="panel-heading">Please login</div>
					
					<div class="panel-body">
						<?php if ($message != "") { ?>
						<div class="alert alert-success"><?php echo $message;?></div>
						<?php } ?>
					
						<?php echo form_open("story/login", 'class="form" role="form"');?>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<?php echo form_input('identity', '', 'id="identity" class="form-control" placeholder="Username" required autofocus');?>
   				 				</div>
   				 			</div>
   				 			<div class="form-group">
    							<div class="input-group">
    								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									<?php echo form_password('password', '', 'id="password" class="form-control" placeholder="Password" required');?>
								</div>
							</div>
							<p><?php echo form_submit('submit', 'Login', 'class="btn btn-lg btn-primary btn-block"');?></p>
						<?php echo form_close();?>
						<p>
							<?php echo anchor('story/register', 'No Account! Register here!', 'class="btn btn-default btn-block"'); ?>
						</p>
					</div>
				</div>
			</div>
