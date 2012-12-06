<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Appid', 'appid'); ?>

			<div class="input">
				<?php echo Form::input('appid', Input::post('appid', isset($webservice_appermission) ? $webservice_appermission->appid : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Action', 'action'); ?>

			<div class="input">
				<?php echo Form::input('action', Input::post('action', isset($webservice_appermission) ? $webservice_appermission->action : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Can get', 'can_get'); ?>

			<div class="input">
				<?php echo Form::input('can_get', Input::post('can_get', isset($webservice_appermission) ? $webservice_appermission->can_get : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Can post', 'can_post'); ?>

			<div class="input">
				<?php echo Form::input('can_post', Input::post('can_post', isset($webservice_appermission) ? $webservice_appermission->can_post : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Can put', 'can_put'); ?>

			<div class="input">
				<?php echo Form::input('can_put', Input::post('can_put', isset($webservice_appermission) ? $webservice_appermission->can_put : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Can delete', 'can_delete'); ?>

			<div class="input">
				<?php echo Form::input('can_delete', Input::post('can_delete', isset($webservice_appermission) ? $webservice_appermission->can_delete : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>