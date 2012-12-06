<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Appid', 'appid'); ?>

			<div class="input">
				<?php echo Form::input('appid', Input::post('appid', isset($webservice_plateformapp) ? $webservice_plateformapp->appid : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Appsecret', 'appsecret'); ?>

			<div class="input">
				<?php echo Form::input('appsecret', Input::post('appsecret', isset($webservice_plateformapp) ? $webservice_plateformapp->appsecret : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Appname', 'appname'); ?>

			<div class="input">
				<?php echo Form::input('appname', Input::post('appname', isset($webservice_plateformapp) ? $webservice_plateformapp->appname : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Description', 'description'); ?>

			<div class="input">
				<?php echo Form::input('description', Input::post('description', isset($webservice_plateformapp) ? $webservice_plateformapp->description : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Active', 'active'); ?>

			<div class="input">
				<?php echo Form::input('active', Input::post('active', isset($webservice_plateformapp) ? $webservice_plateformapp->active : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Ip', 'ip'); ?>

			<div class="input">
				<?php echo Form::input('ip', Input::post('ip', isset($webservice_plateformapp) ? $webservice_plateformapp->ip : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Host', 'host'); ?>

			<div class="input">
				<?php echo Form::input('host', Input::post('host', isset($webservice_plateformapp) ? $webservice_plateformapp->host : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Extra', 'extra'); ?>

			<div class="input">
				<?php echo Form::textarea('extra', Input::post('extra', isset($webservice_plateformapp) ? $webservice_plateformapp->extra : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>