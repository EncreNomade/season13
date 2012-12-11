<?php 
	
	echo Asset::js('achat/product.js');

	echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Reference', 'reference'); ?>

			<div class="input">
				<?php echo Form::input('reference', Input::post('reference', isset($achat_13product) ? $achat_13product->reference : ''), array('class' => 'span4')); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Type', 'type'); ?>

			<div class="input">
			
				<?php 
				echo Form::select(
				    'type', 
				    Input::post('type', isset($achat_13product) ? $achat_13product->type : 'episode'), 
				    array('episode'=>'Episodes'/*, 'book'=>'Histoires', 'season'=>'Saisons'*/)
				); ?>
				
			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Pack', 'pack'); ?>

			<div class="input">
				<?php 
				echo Form::select(
				    'pack', 
				    Input::post('pack', isset($achat_13product) ? $achat_13product->pack : '00'), 
				    array('00'=>'Ce n\'est pas un pack', '1'=>'C\'est un pack')
				); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Content', 'content'); ?>

			<div class="input">
		    	<?php 
		    	
		    	$eps = Model_Admin_13episode::find('all');
		    	$arr = array();
		    	foreach ($eps as $ep) {
		    	    $arr[$ep->id] = $ep->story." s".$ep->season."e".$ep->episode;
		    	}
		    	
		    	echo Form::select(
		    	    'content', 
		    	    Input::post('content', isset($achat_13product) ? $achat_13product->content : ''), 
		    	    $arr,
		    	    array(
		    	        'multiple' => 'multiple'
		    	    ),
		    	    array('style'=>'width:300px;')
		    	); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Presentation', 'presentation'); ?>

			<div class="input">
				<?php echo Form::textarea('presentation', Input::post('presentation', isset($achat_13product) ? $achat_13product->presentation : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Tags', 'tags'); ?>

			<div class="input">
				<?php echo Form::input('tags', Input::post('tags', isset($achat_13product) ? $achat_13product->tags : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($achat_13product) ? $achat_13product->title : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Category', 'category'); ?>

			<div class="input">
				<?php echo Form::input('category', Input::post('category', isset($achat_13product) ? $achat_13product->category : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Metas', 'metas'); ?>
			
			<div class="input">
				<?php 
				    /*
				    Preset all metas existing when $achat_13product exist or when post meta exist
				    */
				    $metas = array();
				    Input::post('category', isset($achat_13product) ? $achat_13product->category : '');
				    if (Input::post('meta_type_content') && Input::post('meta_value_content')) {
				    	$types = Input::post('meta_type_content');
				    	$values = Input::post('meta_value_content');
				    	if(is_array($types) && is_array($values) && sizeof($types) == sizeof($values)) {
				    		foreach ($types as $i => $type) {
				    			$metas[] = [ "type" => $type, "value" => $values[$i] ];
				    		}
				    	}				    	
				    }
				    else if(isset($achat_13product)) {
				    	$metas = Format::forge($achat_13product->metas, "json")->to_array();
				    }


				    echo Form::select(
				        'meta_type', 
				        'image', 
				        array('image'=>'Image', 'extrait'=>'Lien d\'extrait', 'author'=>'Auteur')
				    );
				    
				    echo Form::input('meta_value', '', array('class' => 'span4'));
				    
				    echo Form::button('meta_add', 'Add meta', array('id' => 'meta_add', 'class' => 'btn'));


				    foreach ($metas as $meta) {
				    	echo "<div>";
				    	echo Form::select(
					        'meta_type', 
					        'image', 
					        array('image'=>'Image', 'extrait'=>'Lien d\'extrait', 'author'=>'Auteur'),
					        array('disabled'=>'true')
					    );

					    echo Form::Input('meta_type_content[]', $meta["type"], ["type"=>"hidden"]);

					    echo Form::Input('meta_value_content[]', $meta['value'], ['class'=>'span4', 'readonly' => "true"]);

				    	echo Form::button('meta_add', 'Delete', array('id' => 'meta_add', 'class' => 'btn btn-danger remove-meta'));

				    	echo "</div>";
				    }
				 ?>


			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('En vente', 'on_sale'); ?>

			<div class="input">
			    <?php 
			    echo Form::select(
			        'on_sale', 
			        Input::post('on_sale', isset($achat_13product) ? $achat_13product->on_sale : '1'), 
			        array('00'=>'Plus en vente', '1'=>'En vente')
			    );
			    ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Price', 'price'); ?>

			<div class="input">
				<?php echo Form::input('price', Input::post('price', isset($achat_13product) ? $achat_13product->price : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Discount', 'discount'); ?>

			<div class="input">
				<?php echo Form::input('discount', Input::post('discount', isset($achat_13product) ? $achat_13product->discount : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Sales', 'sales'); ?>

			<div class="input">
				<?php echo Form::input('sales', Input::post('sales', isset($achat_13product) ? $achat_13product->sales : "0"), array('class' => 'span4')); ?>
			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>