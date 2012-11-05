<div class="main_container">
<div>

    <h1>Contact</h1>
    <h5>
        Pour tout renseignement ou question, n'hésite pas à nous contacter.
        <br/>
        Season13<br/>
        99A, boulevard Descat<br/>
        59 200 TOURCOING<br/>
        Tel : +33 (0)3 20 24 79 56<br/>
        Mail : <a href="mailto: contact@encrenomade.com">contact@encrenomade.com</a><br/>
        <br/>
        
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
        
        <?php echo Form::open('admin/13contactmsgs/send'); ?>
        
        	<fieldset>
        	    <?php if($current_user): ?>
                    <div class="clearfix">
            			<?php echo Form::label('Pseudo', 'nom'); ?>
            
            			<div class="input">
            				<?php echo Form::input('nom', Input::post('nom', $current_user->pseudo), array('class' => 'span4')); ?>
            
            			</div>
            		</div>
        		<?php else: ?>
            		<div class="clearfix">
            			<?php echo Form::label('Ton Prenom', 'nom'); ?>
            
            			<div class="input">
            				<?php echo Form::input('nom', Input::post('nom', isset($admin_13contactmsg) ? $admin_13contactmsg->nom : ''), array('class' => 'span4')); ?>
            
            			</div>
            		</div>
        		<?php endif; ?>
        	    
        		<div class="clearfix">
        			<?php echo Form::label('Ton Email', 'email'); ?>
        
        			<div class="input">
        				<?php echo Form::input('email', Input::post('email', isset($current_user) ? $current_user->email : ''), array('class' => 'span4')); ?>
        
        			</div>
        		</div>
        		
        		<div class="clearfix">
        			<?php echo Form::label('Objet', 'title'); ?>
        
        			<div class="input">
        				<?php echo Form::input('title', Input::post('title', isset($admin_13contactmsg) ? $admin_13contactmsg->title : ''), array('class' => 'span4', 'placeholder' => 'Facultatif')); ?>
        
        			</div>
        		</div>
        		<div class="clearfix">
        			<?php echo Form::label('Ton Message', 'message'); ?>
        
        			<div class="input">
        				<?php echo Form::textarea('message', Input::post('message', isset($admin_13contactmsg) ? $admin_13contactmsg->message : ''), array('class' => 'span8', 'rows' => 8)); ?>
        
        			</div>
        		</div>
        		<div class="actions">
        			<?php echo Form::submit('submit', 'Envoyer', array('class' => 'btn btn-primary')); ?>
        
        		</div>
        	</fieldset>
        <?php echo Form::close(); ?>
        
        <br/>
    </h5>
    
    <h5 class="gris">Vous disposez d'un droit d'accès, de modification, de rectification et de suppression des données qui vous concernent (article 34 de la loi "Informatique et Libertés" du 6 janvier 1978).</h5>
    
</div>
</div>