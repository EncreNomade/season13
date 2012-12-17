<?php echo Form::open(); ?>
    
    <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Appid', 'appid'); ?>

			<div class="input">
			
				<?php 
				
				$apps = Model_Webservice_Plateformapp::find('all');
				$arr = array();
				foreach ($apps as $app) {
				    $arr[$app->appid] = $app->appname;
				}
				
				echo Form::select(
				    'appid', 
				    Input::post('appid', isset($webservice_appermission) ? $webservice_appermission->appid : ''), 
				    $arr
				); 
				
				?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Action', 'action'); ?>

			<div class="input">
				<?php 
				
				$actions = get_class_methods('Controller_Webservice_Wsbase');
				
				$actionreg = "/(get|post)\_(?P<name>\w+)/";
				$arr = array();
				foreach ($actions as $action) {
				    preg_match($actionreg, $action, $res);
				    if(array_key_exists('name', $res)) {
				        $name = $res['name'];
				        if(!array_key_exists($name, $arr)) $arr[$name] = $name;
				    }
				}
				
				echo Form::select(
				    'action', 
				    Input::post('action', isset($webservice_appermission) ? $webservice_appermission->action : ''), 
				    $arr
				);
				
				?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Can get', 'can_get'); ?>

			<div class="input">
				<?php 
				echo Form::checkbox('can_get', 'Can get', Input::post('can_get', isset($webservice_appermission) && $webservice_appermission->can_get == 1 ? true : false));
                 ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Can post', 'can_post'); ?>

			<div class="input">
				<?php 
				echo Form::checkbox('can_post', 'Can post', Input::post('can_post', isset($webservice_appermission) && $webservice_appermission->can_post == 1 ? true : false));
				?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Can put', 'can_put'); ?>

			<div class="input">
				<?php 
				echo Form::checkbox('can_put', 'Can put', Input::post('can_put', isset($webservice_appermission) && $webservice_appermission->can_put == 1 ? true : false));
				 ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Can delete', 'can_delete'); ?>

			<div class="input">
				<?php 
				echo Form::checkbox('can_delete', 'Can delete', Input::post('can_delete', isset($webservice_appermission) && $webservice_appermission->can_delete == 1 ? true : false));
				 ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>