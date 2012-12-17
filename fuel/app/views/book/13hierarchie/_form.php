<?php echo Form::open(); ?>

    <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>

	<fieldset>
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
			        Input::post('epid', isset($book_13hierarchie) ? $book_13hierarchie->epid : ''), 
			        $arr
			    );
			    
			    ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Belongs to', 'belongto'); ?>

			<div class="input">
			    <?php 
			    
			    $seasons = Model_Book_13season::find('all');
			    $arr = array();
			    foreach ($seasons as $season) {
			        $book = Model_Book_13book::find_by_id($season->book_id);
			        if($book) {
        		        $arr[$season->id] = $book->title." season".$season->season_id;
			        }
			    }
			    
			    echo Form::select(
			        'belongto', 
			        Input::post('belongto', isset($book_13hierarchie) ? $book_13hierarchie->belongto : ''), 
			        $arr
			    );
			    
			    ?>
			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>