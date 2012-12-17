<?php echo Form::open(); ?>

    <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>
    
    <?php 
        $appid = Str::random('unique');
        $appsecret = Str::random('alnum', 16);
        echo \Form::hidden('appid', $appid);
        echo \Form::hidden('appsecret', $appsecret);
     ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Appid', 'appid'); ?>

			<div class="input">
				<?php echo Form::label(Input::post('appid', isset($webservice_plateformapp) ? $webservice_plateformapp->appid : $appid), 'appid'); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Appsecret', 'appsecret'); ?>

			<div class="input">
				<?php echo Form::label(Input::post('appsecret', isset($webservice_plateformapp) ? $webservice_plateformapp->appsecret : $appsecret), 'appsecret'); ?>

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
				<?php echo Form::checkbox('active', 'Active', Input::post('active', isset($webservice_plateformapp) && $webservice_plateformapp->active == 0 ? false : true)); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>