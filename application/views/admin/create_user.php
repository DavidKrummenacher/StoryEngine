<h1><?php echo lang('create_user_heading');?></h1>
<p><?php echo lang('create_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("admin/create_user", 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="first_name" class="col-sm-2 control-label"><?php echo lang('create_user_fname_label');?></label>
        <div class="col-sm-10">
        	<?php echo form_input($first_name, '', 'class="form-control"');?>
        </div>
	</div>
	<div class="form-group">
		<label for="last_name" class="col-sm-2 control-label"><?php echo lang('create_user_lname_label');?></label>
        <div class="col-sm-10">
        	<?php echo form_input($last_name, '', 'class="form-control"');?>
        </div>
	</div>
	<div class="form-group">
		<label for="company" class="col-sm-2 control-label"><?php echo lang('create_user_company_label');?></label>
        <div class="col-sm-10">
        	<?php echo form_input($company, '', 'class="form-control"');?>
        </div>
	</div>
	<div class="form-group">
		<label for="email" class="col-sm-2 control-label"><?php echo lang('create_user_email_label');?></label>
        <div class="col-sm-10">
        	<?php echo form_input($email, '', 'class="form-control"');?>
        </div>
	</div>
	<div class="form-group">
		<label for="phone" class="col-sm-2 control-label"><?php echo lang('create_user_phone_label');?></label>
        <div class="col-sm-10">
        	<?php echo form_input($phone, '', 'class="form-control"');?>
        </div>
	</div>
	<div class="form-group">
		<label for="password" class="col-sm-2 control-label"><?php echo lang('create_user_password_label');?></label>
        <div class="col-sm-10">
        	<?php echo form_input($password, '', 'class="form-control"');?>
        </div>
	</div>
	<div class="form-group">
		<label for="password_confirm" class="col-sm-2 control-label"><?php echo lang('create_user_password_confirm_label');?></label>
        <div class="col-sm-10">
        	<?php echo form_input($password_confirm, '', 'class="form-control"');?>
        </div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo form_submit('submit', lang('create_user_submit_btn'), 'class="btn btn-default"');?>
		</div>
	</div>

<?php echo form_close();?>
