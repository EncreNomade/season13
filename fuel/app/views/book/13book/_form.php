<?php echo Form::open(); ?>

    <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Reference', 'reference'); ?>

			<div class="input">
				<?php echo Form::input('reference', Input::post('reference', isset($book_13book) ? $book_13book->reference : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($book_13book) ? $book_13book->title : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Sub title', 'sub_title'); ?>

			<div class="input">
				<?php echo Form::input('sub_title', Input::post('sub_title', isset($book_13book) ? $book_13book->sub_title : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Cover', 'cover'); ?>

			<div class="input">
				<?php echo Form::input('cover', Input::post('cover', isset($book_13book) ? $book_13book->cover : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Author', 'author_id'); ?>

			<div class="input">
				<?php 
				
				$authors = Model_Book_13author::find('all');
				$arr = array();
				foreach ($authors as $author) {
				    $arr[$author->id] = $author->firstname." ".Str::upper($author->lastname);
				}
				
				echo Form::select(
				    'author_id', 
				    Input::post('author_id', isset($book_13book) ? $book_13book->author_id : ''), 
				    $arr
				); 
				
				?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Brief', 'brief'); ?>

			<div class="input">
				<?php echo Form::textarea('brief', Input::post('brief', isset($book_13book) ? $book_13book->brief : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Tags', 'tags'); ?>

			<div class="input">
				<?php echo Form::input('tags', Input::post('tags', isset($book_13book) ? $book_13book->tags : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Categories', 'categories'); ?>

			<div class="input">
				<?php echo Form::input('categories', Input::post('categories', isset($book_13book) ? $book_13book->categories : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>