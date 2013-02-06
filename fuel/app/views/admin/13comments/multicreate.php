<h5>
    Créer des commentaires en indiquant l'épisode et le contenu des commentaires. Le contenu peut être sous format suivant (':' pour séparer le pseudo et le commentaire, ';' pour séparer les commentaires.) : 
    <br/>
    <br/>
    Pseudo : Commentaire 1 ... ...;
    <br/>
    Theo:Commentaire 2 avec changement de 
    <br/>
    ligne... ;
    <br/>
    Adele: Il faut pas avoir les ';' ou ':' dans la texte du commentaire...
    <br/>
    <br/>
</h5>

<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Episode', 'episode'); ?>

			<div class="input">
		    	<?php 
		    	
		    	$eps = Model_Admin_13episode::find('all');
		    	$arr = array();
		    	foreach ($eps as $ep) {
		    	    $arr[$ep->id] = $ep->story." s".$ep->season."e".$ep->episode;
		    	}
		    	
		    	echo Form::select(
		    	    'episode', 
		    	    Input::post('episode', ''), 
		    	    $arr,
		    	    array(),
		    	    array('style'=>'width:300px;')
		    	); ?>
			</div>
		</div>
		
		<div class="clearfix">
			<?php echo Form::label('Commentaire', 'comments'); ?>

			<div class="input">
				<?php echo Form::textarea('comments', Input::post('comments', ''), array('class' => 'span8', 'rows' => 16, 'cols' => 50)); ?>

			</div>
		</div>
		
		<div class="actions">
			<?php echo Form::submit('submit', 'Create', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>