<h1><?php echo lang('edit_user_heading').' ('.$user->username.')';?></h1>
<p><?php echo lang('edit_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(uri_string(), 'class="form-horizontal" role="form"');?>
	<div class="form-group">
		<label for="first_name" class="col-sm-2 control-label"><?php echo lang('edit_user_fname_label');?></label>
		<div class="col-sm-10">
			<?php echo form_input($first_name, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
      	<label for="last_name" class="col-sm-2 control-label"><?php echo lang('edit_user_lname_label');?></label>
		<div class="col-sm-10">
			<?php echo form_input($last_name, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="email" class="col-sm-2 control-label"><?php echo lang('create_user_email_label');?></label>
        <div class="col-sm-10">
        	<?php echo form_input($email, '', 'class="form-control"');?>
        </div>
	</div>
	<div class="form-group">
		<label for="password" class="col-sm-2 control-label"><?php echo lang('edit_user_password_label');?></label>
		<div class="col-sm-10">
			<?php echo form_password($password, '', 'class="form-control"');?>
		</div>
	</div>
	<div class="form-group">
		<label for="password_confirm" class="col-sm-2 control-label"><?php echo lang('edit_user_password_confirm_label');?></label>
		<div class="col-sm-10">
			<?php echo form_password($password_confirm, '', 'class="form-control"');?>
		</div>
	</div>

	<?php if ($this->ion_auth->is_admin()):  ?>
	
	<!--<h3><?php echo lang('edit_user_groups_heading');?></h3>-->
	<div class="form-group">
		<label class="col-sm-2 control-label"><?php echo lang('edit_user_groups_heading');?></label>
		<div class="col-sm-10">
		<?php
			$first = TRUE;
			foreach ($groups as $group):
		?>
			<div class="checkbox">
				<label>
					<?php
						$gID=$group['id'];
						$checked = null;
						$item = null;
						foreach($currentGroups as $grp) {
							if ($gID == $grp->id) {
								$checked= ' checked="checked"';
								break;
							}
						}
						
						//don't allow making yourself not an admin
						$disabled = '';
						if ($user->id == $this->ion_auth->user()->row()->id && $group['name'] == $this->config->item('admin_group', 'ion_auth')) {
							$disabled = ' hidden';
						}
					?>
					<input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked.$disabled;?>>
					<?php echo $group['description'];?>
				</label>
			</div>
		<?php if ($first == TRUE) { ?>
		</div>
		<div class="col-sm-offset-2 col-sm-10">
		<?php $first = FALSE; } ?>
		<?php endforeach?>
		</div>
	</div>
	<?php endif ?>

	<?php echo form_hidden('id', $user->id);?>
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo form_submit('submit', lang('edit_user_submit_btn'), 'class="btn btn-default"');?>
		</div>
	</div>

<?php echo form_close();?>
