<?php 
	$url = isset($user_address) ? 'user/address/edit/'.$user_address->id : 'user/address/create';
	echo Form::open($url); 
?>
	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Prénom', 'firstname'); ?>

			<div class="input">
				<?php echo Form::input('firstname', Input::post('firstname', isset($user_address) ? $user_address->firstname : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Nom', 'lastname'); ?>

			<div class="input">
				<?php echo Form::input('lastname', Input::post('lastname', isset($user_address) ? $user_address->lastname : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('E-mail', 'email'); ?>
			<?php $defaultMail = isset($current_user) ? $current_user->email : '' ;?>
			<div class="input">
				<?php echo Form::input('email', Input::post('email', isset($user_address) ? $user_address->email : $defaultMail), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Adresse', 'address'); ?>

			<div class="input">
				<?php echo Form::textarea('address', Input::post('address', isset($user_address) ? $user_address->address : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Code Postal', 'postcode'); ?>

			<div class="input">
				<?php echo Form::input('postcode', Input::post('postcode', isset($user_address) ? $user_address->postcode : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Ville', 'city'); ?>

			<div class="input">
				<?php echo Form::input('city', Input::post('city', isset($user_address) ? $user_address->city : ''), array('class' => 'span4')); ?>

			</div>
		</div>

		<?php 
			// select list of countries
			$data = array();
			$countries = Config::get('currencies');
			$selectedItem = Input::post('country_code', isset($user_address) ? $user_address->country_code : 'FR');
			foreach ($countries as $country_code => $country) {
				$data[$country_code] = $country['name'];
			}
		?>
		<div class="clearfix">
			<?php echo Form::label('Pays', 'country_code'); ?>

			<div class="input">
				<?php echo Form::select('country_code', $selectedItem, $data);  ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Téléphone', 'tel'); ?>

			<div class="input">
				<?php echo Form::input('tel', Input::post('tel', isset($user_address) ? $user_address->tel : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php 
				if (isset($requestType)) {
					if($requestType == "create")
						echo Form::submit('submit', 'Envoyer', array('id' => 'sendCreateAddress',
																	 'class' => 'btn btn-primary'));
				}
				else
					echo Form::submit('submit', 'Valider', array('id' => 'sendModifyAddress',
																 'class' => 'btn btn-primary')); 

			?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>