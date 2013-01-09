<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Firstname', 'firstname'); ?>

			<div class="input">
				<?php echo Form::input('firstname', Input::post('firstname', isset($user_address) ? $user_address->firstname : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Lastname', 'lastname'); ?>

			<div class="input">
				<?php echo Form::input('lastname', Input::post('lastname', isset($user_address) ? $user_address->lastname : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Address', 'address'); ?>

			<div class="input">
				<?php echo Form::input('address', Input::post('address', isset($user_address) ? $user_address->address : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Postcode', 'postcode'); ?>

			<div class="input">
				<?php echo Form::input('postcode', Input::post('postcode', isset($user_address) ? $user_address->postcode : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('City', 'city'); ?>

			<div class="input">
				<?php echo Form::input('city', Input::post('city', isset($user_address) ? $user_address->city : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Country code', 'country_code'); ?>

			<div class="input">
				<?php echo Form::input('country_code', Input::post('country_code', isset($user_address) ? $user_address->country_code : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Tel', 'tel'); ?>

			<div class="input">
				<?php echo Form::input('tel', Input::post('tel', isset($user_address) ? $user_address->tel : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($user_address) ? $user_address->title : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Supp', 'supp'); ?>

			<div class="input">
				<?php echo Form::input('supp', Input::post('supp', isset($user_address) ? $user_address->supp : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>