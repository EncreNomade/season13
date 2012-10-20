<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('User', 'user'); ?>

			<div class="input">
				<?php echo Form::input('user', Input::post('user', isset($admin_13comment) ? $admin_13comment->user : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Content', 'content'); ?>

			<div class="input">
				<?php echo Form::textarea('content', Input::post('content', isset($admin_13comment) ? $admin_13comment->content : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Image', 'image'); ?>

			<div class="input">
				<?php echo Form::input('image', Input::post('image', isset($admin_13comment) ? $admin_13comment->image : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Fbpostid', 'fbpostid'); ?>

			<div class="input">
				<?php echo Form::input('fbpostid', Input::post('fbpostid', isset($admin_13comment) ? $admin_13comment->fbpostid : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Position', 'position'); ?>

			<div class="input">
				<?php echo Form::input('position', Input::post('position', isset($admin_13comment) ? $admin_13comment->position : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Verified', 'verified'); ?>

			<div class="input">
				<?php echo Form::input('verified', Input::post('verified', isset($admin_13comment) ? $admin_13comment->verified : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Epid', 'epid'); ?>

			<div class="input">
				<?php echo Form::input('epid', Input::post('epid', isset($admin_13comment) ? $admin_13comment->epid : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>