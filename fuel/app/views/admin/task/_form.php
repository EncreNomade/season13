<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Creator', 'creator'); ?>

			<div class="input">
				<?php echo Form::input('creator', Input::post('creator', isset($admin_task) ? $admin_task->creator : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Type', 'type'); ?>

			<div class="input">
				<?php echo Form::input('type', Input::post('type', isset($admin_task) ? $admin_task->type : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Parameters', 'parameters'); ?>

			<div class="input">
				<?php echo Form::textarea('parameters', Input::post('parameters', isset($admin_task) ? $admin_task->parameters : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Whentodo', 'whentodo'); ?>

			<div class="input">
				<?php echo Form::input('whentodo', Input::post('whentodo', isset($admin_task) ? $admin_task->whentodo : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Done', 'done'); ?>

			<div class="input">
				<?php echo Form::input('done', Input::post('done', isset($admin_task) ? $admin_task->done : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Whendone', 'whendone'); ?>

			<div class="input">
				<?php echo Form::input('whendone', Input::post('whendone', isset($admin_task) ? $admin_task->whendone : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>