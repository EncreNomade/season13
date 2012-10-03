<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($admin_13post) ? $admin_13post->title : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Slug', 'slug'); ?>

			<div class="input">
				<?php echo Form::input('slug', Input::post('slug', isset($admin_13post) ? $admin_13post->slug : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('User id', 'user_id'); ?>

			<div class="input">
				<?php echo Form::input('user_id', Input::post('user_id', isset($admin_13post) ? $admin_13post->user_id : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Summary', 'summary'); ?>

			<div class="input">
				<?php echo Form::textarea('summary', Input::post('summary', isset($admin_13post) ? $admin_13post->summary : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Body', 'body'); ?>

			<div class="input">
				<?php echo Form::textarea('body', Input::post('body', isset($admin_13post) ? $admin_13post->body : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Categories', 'categories'); ?>

			<div class="input">
				<?php echo Form::input('categories', Input::post('categories', isset($admin_13post) ? $admin_13post->categories : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>