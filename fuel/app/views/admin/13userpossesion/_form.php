<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('User mail', 'user_mail'); ?>

			<div class="input">
				<?php echo Form::input('user_mail', Input::post('user_mail', isset($admin_13userpossesion) ? $admin_13userpossesion->user_mail : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Episode id', 'episode_id'); ?>

			<div class="input">
				<?php echo Form::input('episode_id', Input::post('episode_id', isset($admin_13userpossesion) ? $admin_13userpossesion->episode_id : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Source', 'source'); ?>

			<div class="input">
				<?php echo Form::input('source', Input::post('source', isset($admin_13userpossesion) ? $admin_13userpossesion->source : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>