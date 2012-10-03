<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($admin_13episode) ? $admin_13episode->title : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Story', 'story'); ?>

			<div class="input">
				<?php echo Form::input('story', Input::post('story', isset($admin_13episode) ? $admin_13episode->story : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Season', 'season'); ?>

			<div class="input">
				<?php echo Form::input('season', Input::post('season', isset($admin_13episode) ? $admin_13episode->season : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Episode', 'episode'); ?>

			<div class="input">
				<?php echo Form::input('episode', Input::post('episode', isset($admin_13episode) ? $admin_13episode->episode : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Path', 'path'); ?>

			<div class="input">
				<?php echo Form::input('path', Input::post('path', isset($admin_13episode) ? $admin_13episode->path : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Bref', 'bref'); ?>

			<div class="input">
				<?php echo Form::textarea('bref', Input::post('bref', isset($admin_13episode) ? $admin_13episode->bref : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Image', 'image'); ?>

			<div class="input">
				<?php echo Form::input('image', Input::post('image', isset($admin_13episode) ? $admin_13episode->image : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Dday', 'dday'); ?>

			<div class="input">
				<?php echo Form::input('dday', Input::post('dday', isset($admin_13episode) ? $admin_13episode->dday : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Price', 'price'); ?>

			<div class="input">
				<?php echo Form::input('price', Input::post('price', isset($admin_13episode) ? $admin_13episode->price : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Info supp', 'info_supp'); ?>

			<div class="input">
				<?php echo Form::textarea('info_supp', Input::post('info_supp', isset($admin_13episode) ? $admin_13episode->info_supp : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>