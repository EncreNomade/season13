<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Nom', 'nom'); ?>

			<div class="input">
				<?php echo Form::input('nom', Input::post('nom', isset($admin_13contactmsg) ? $admin_13contactmsg->nom : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('User', 'user'); ?>

			<div class="input">
				<?php echo Form::input('user', Input::post('user', isset($admin_13contactmsg) ? $admin_13contactmsg->user : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Email', 'email'); ?>

			<div class="input">
				<?php echo Form::input('email', Input::post('email', isset($admin_13contactmsg) ? $admin_13contactmsg->email : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Destination', 'destination'); ?>

			<div class="input">
				<?php echo Form::input('destination', Input::post('destination', isset($admin_13contactmsg) ? $admin_13contactmsg->destination : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($admin_13contactmsg) ? $admin_13contactmsg->title : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Message', 'message'); ?>

			<div class="input">
				<?php echo Form::textarea('message', Input::post('message', isset($admin_13contactmsg) ? $admin_13contactmsg->message : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Response', 'response'); ?>

			<div class="input">
				<?php echo Form::input('response', Input::post('response', isset($admin_13contactmsg) ? $admin_13contactmsg->response : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>