<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Reference', 'reference'); ?>

			<div class="input">
				<?php echo Form::input('reference', Input::post('reference', isset($achat_13extorder) ? $achat_13extorder->reference : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Owner', 'owner'); ?>

			<div class="input">
				<?php echo Form::input('owner', Input::post('owner', isset($achat_13extorder) ? $achat_13extorder->owner : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Order source', 'order_source'); ?>

			<div class="input">
				<?php echo Form::input('order_source', Input::post('order_source', isset($achat_13extorder) ? $achat_13extorder->order_source : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Appid', 'appid'); ?>

			<div class="input">
				<?php echo Form::input('appid', Input::post('appid', isset($achat_13extorder) ? $achat_13extorder->appid : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Price', 'price'); ?>

			<div class="input">
				<?php echo Form::input('price', Input::post('price', isset($achat_13extorder) ? $achat_13extorder->price : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('App name', 'app_name'); ?>

			<div class="input">
				<?php echo Form::input('app_name', Input::post('app_name', isset($achat_13extorder) ? $achat_13extorder->app_name : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>