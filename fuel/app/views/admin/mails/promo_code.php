<div class="main_container">
<div>

    <h1>Envoyer des codes de promotion</h1>
    <h5>
        
        <?php if (Session::get_flash('success')): ?>
            <div class="flash-alert alert-success">
            	<span class="flash-close">×</span>
            	<p><?php echo implode('</p><p>', (array) Session::get_flash('success')); ?></p>
            </div>
        <?php endif; ?>
        <?php if (Session::get_flash('error')): ?>
            <div class="flash-alert alert-error">
            	<span class="flash-close">×</span>
            	<p><?php echo implode('</p><p>', (array) Session::get_flash('error')); ?></p>
            </div>
        <?php endif; ?>
        
        <?php echo Form::open(array('action' => 'admin/mails/send_promocode', 'method' => 'POST')); ?>
        
        	<fieldset>
                <div class="clearfix">
        			<?php echo Form::label('Envoyer par', 'from'); ?>
        
        			<div class="input">
        				<?php echo Form::input('from', Input::post('from', 'contact@encrenomade.com')); ?>
        			</div>
        		</div>
        	    
        		<div class="clearfix">
        			<?php echo Form::label('Envoyer à', 'to'); ?>
        
        			<div class="input">
        				<?php echo Form::textarea('to', Input::post('to', ''), array('rows' => 8)); ?>
        			</div>
        		</div>
        		
        		<div class="clearfix">
					<?php echo Form::label('Offre', 'offre'); ?>
		
					<div class="input">
						<?php 
						
						$eps = Model_Admin_13episode::find('all');
						$arr = array();
						foreach ($eps as $ep) {
						    $arr[$ep->id] = $ep->story." season".$ep->season." episode".$ep->episode;
						}
						
						echo Form::select(
						    'offre', 
						    '', 
						    $arr,
						    array(
						        'multiple' => 'multiple'
						    )
						); ?>
					</div>
				</div>
        		
        		<div class="clearfix">
        			<?php echo Form::label('Ton message', 'message'); ?>
        
        			<div class="input">
        				<?php echo Form::textarea('message', Input::post('message', ''), array('rows' => 8)); ?>
        			</div>
        		</div>
        		
        		<div class="actions">
        			<?php echo Form::submit('submit', 'Envoyer', array('class' => 'btn btn-primary')); ?>
        		</div>
        	</fieldset>
        <?php echo Form::close(); ?>
        
        <br/>
    </h5>
    
</div>
</div>