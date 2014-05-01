			<div class="container col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Register</div>
					
					<div class="panel-body">
						<?php if ($message != "") { ?>
						<div class="alert alert-success"><?php echo $message;?></div>
						<?php } ?>
						
						<?php echo form_open("story/register", 'class="form-horizontal" role="form"');?>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        							<?php echo form_input($username, '', 'class="form-control" placeholder="Username" required autofocus');?>
   				 				</div>
   				 			</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									<?php echo form_input($password, '', 'class="form-control" placeholder="Password" required');?>
        						</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        							<?php echo form_input($password_confirm, '', 'class="form-control" placeholder="Confirm password" required');?>
        						</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<?php echo form_submit('submit', 'Register', 'class="btn btn-default"');?>
								</div>
							</div>
						
						<?php echo form_close();?>
					</div>
				</div>
			</div>
			