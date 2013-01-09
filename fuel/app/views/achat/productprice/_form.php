<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Product id', 'product_id'); ?>

			<div class="input">
				<?php echo Form::input('product_id', Input::post('product_id', isset($achat_productprice) ? $achat_productprice->product_id : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Country code', 'country_code'); ?>

			<div class="input">
				<?php echo Form::input('country_code', Input::post('country_code', isset($achat_productprice) ? $achat_productprice->country_code : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Taxed price', 'taxed_price'); ?>

			<div class="input">
				<?php echo Form::input('taxed_price', Input::post('taxed_price', isset($achat_productprice) ? $achat_productprice->taxed_price : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Discount', 'discount'); ?>

			<div class="input">
				<?php echo Form::input('discount', Input::post('discount', isset($achat_productprice) ? $achat_productprice->discount : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>