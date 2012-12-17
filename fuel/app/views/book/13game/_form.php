<?php echo Form::open(); ?>

    <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Name', 'name'); ?>

			<div class="input">
				<?php echo Form::input('name', Input::post('name', isset($book_13game) ? $book_13game->name : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Epid', 'epid'); ?>

			<div class="input">
				
				<?php 
				
				$eps = Model_Admin_13episode::find('all');
				$arr = array();
				foreach ($eps as $ep) {
				    $arr[$ep->id] = $ep->story." s".$ep->season."e".$ep->episode;
				}
				
				echo Form::select(
				    'epid', 
				    Input::post('epid', isset($book_13game) ? $book_13game->epid : ''), 
				    $arr
				); 
				?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Expo', 'expo'); ?>

			<div class="input">
				<?php echo Form::input('expo', Input::post('expo', isset($book_13game) ? $book_13game->expo : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Instruction', 'instruction'); ?>

			<div class="input">
				<?php echo Form::textarea('instruction', Input::post('instruction', isset($book_13game) ? $book_13game->instruction : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Presentation', 'presentation'); ?>

			<div class="input">
				<?php echo Form::textarea('presentation', Input::post('presentation', isset($book_13game) ? $book_13game->presentation : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Categories', 'categories'); ?>

			<div class="input">
				<?php echo Form::input('categories', Input::post('categories', isset($book_13game) ? $book_13game->categories : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>