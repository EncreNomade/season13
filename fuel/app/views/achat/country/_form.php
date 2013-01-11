<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Name', 'name'); ?>

			<div class="input">
				<?php echo Form::input('name', Input::post('name', isset($achat_country) ? $achat_country->name : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Iso code', 'iso_code'); ?>

			<div class="input">
				<?php echo Form::input('iso_code', Input::post('iso_code', isset($achat_country) ? $achat_country->iso_code : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Language', 'language'); ?>

			<div class="input">
				<?php echo Form::input('language', Input::post('language', isset($achat_country) ? $achat_country->language : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Tax rate', 'tax_rate'); ?>

			<div class="input">
				<?php echo Form::input('tax_rate', Input::post('tax_rate', isset($achat_country) ? $achat_country->tax_rate : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Currency code', 'currency_code'); ?>

			<div class="input">
				<?php echo Form::input('currency_code', Input::post('currency_code', isset($achat_country) ? $achat_country->currency_code : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Active', 'active'); ?>

			<div class="input">
				<?php echo Form::input('active', Input::post('active', isset($achat_country) ? $achat_country->active : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>