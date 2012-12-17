<?php echo Form::open(); ?>

    <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Reference', 'reference'); ?>

			<div class="input">
				<?php echo Form::input('reference', Input::post('reference', isset($book_13season) ? $book_13season->reference : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Book id', 'book_id'); ?>

			<div class="input">
			    <?php 
			    
			    $books = Model_Book_13book::find('all');
			    $arr = array();
			    foreach ($books as $book) {
			        $arr[$book->id] = $book->title;
			    }
			    
			    echo Form::select(
			        'book_id', 
			        Input::post('book_id', isset($book_13season) ? $book_13season->book_id : ''), 
			        $arr
			    );
			    ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Season id', 'season_id'); ?>

			<div class="input">
				<?php echo Form::input('season_id', Input::post('season_id', isset($book_13season) ? $book_13season->season_id : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($book_13season) ? $book_13season->title : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Cover', 'cover'); ?>

			<div class="input">
				<?php echo Form::input('cover', Input::post('cover', isset($book_13season) ? $book_13season->cover : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>