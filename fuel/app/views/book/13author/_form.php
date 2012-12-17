<?php echo Form::open(); ?>

    <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Firstname', 'firstname'); ?>

			<div class="input">
				<?php echo Form::input('firstname', Input::post('firstname', isset($book_13author) ? $book_13author->firstname : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Lastname', 'lastname'); ?>

			<div class="input">
				<?php echo Form::input('lastname', Input::post('lastname', isset($book_13author) ? $book_13author->lastname : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Nickname', 'nickname'); ?>

			<div class="input">
				<?php echo Form::input('nickname', Input::post('nickname', isset($book_13author) ? $book_13author->nickname : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Biographie', 'biographie'); ?>

			<div class="input">
				<?php echo Form::textarea('biographie', Input::post('biographie', isset($book_13author) ? $book_13author->biographie : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Photo', 'photo'); ?>

			<div class="input">
				<?php echo Form::input('photo', Input::post('photo', isset($book_13author) ? $book_13author->photo : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Author slogan', 'author_slogan'); ?>

			<div class="input">
				<?php echo Form::textarea('author_slogan', Input::post('author_slogan', isset($book_13author) ? $book_13author->author_slogan : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>