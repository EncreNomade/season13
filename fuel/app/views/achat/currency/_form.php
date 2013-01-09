<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Name', 'name'); ?>

			<div class="input">
				<?php echo Form::input('name', Input::post('name', isset($achat_currency) ? $achat_currency->name : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Iso code', 'iso_code'); ?>

			<div class="input">
				<?php echo Form::input('iso_code', Input::post('iso_code', isset($achat_currency) ? $achat_currency->iso_code : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Iso code num', 'iso_code_num'); ?>

			<div class="input">
				<?php echo Form::input('iso_code_num', Input::post('iso_code_num', isset($achat_currency) ? $achat_currency->iso_code_num : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Sign', 'sign'); ?>

			<div class="input">
				<?php echo Form::input('sign', Input::post('sign', isset($achat_currency) ? $achat_currency->sign : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Active', 'active'); ?>

			<div class="input">
				<?php echo Form::input('active', Input::post('active', isset($achat_currency) ? $achat_currency->active : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Conversion rate', 'conversion_rate'); ?>

			<div class="input">
				<?php echo Form::input('conversion_rate', Input::post('conversion_rate', isset($achat_currency) ? $achat_currency->conversion_rate : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Supp', 'supp'); ?>

			<div class="input">
				<?php echo Form::input('supp', Input::post('supp', isset($achat_currency) ? $achat_currency->supp : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>