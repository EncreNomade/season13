<?php echo Asset::js('lib/jquery.form.js'); ?>

<div class="main_container">
<div>

    <h1>Envoyer des messages</h1>
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
        
        <form id="imageuploadform" method="POST" enctype="multipart/form-data" action='<?php echo $remote_path; ?>upload'>
            <input type="file" name="upload_pic" id="upload_pic" />
            <input type="button" value="Télécharge" id="upload_btn" />
        </form>
        
        <?php echo Form::open(array('action' => 'admin/mails/send', 'method' => 'POST', 'enctype' => "multipart/data")); ?>
        
            <div class="input">
                <?php echo Form::hidden('mail_template', "newsletter", array('id' => 'mail_template')); ?>
            </div>
        
        	<fieldset>
                <div class="clearfix">
        			<?php echo Form::label('Envoyer par', 'from'); ?>
        
        			<div class="input">
        				<?php echo Form::input('from', 'contact@encrenomade.com', array('class' => 'span4')); ?>
        			</div>
        		</div>
        	    
        		<div class="clearfix">
        			<?php echo Form::label('Envoyer à', 'to'); ?>
        
        			<div class="input">
        				<?php echo Form::input('to', Input::post('to', 'everyone'), array('class' => 'span4')); ?>
        			</div>
        		</div>
        		
        		<div class="clearfix">
					<?php echo Form::label('CC', 'cc'); ?>
		
					<div class="input">
						<?php echo Form::input('cc', Input::post('cc', ''), array('class' => 'span4')); ?>
					</div>
				</div>
				
				<div class="clearfix">
    				<?php echo Form::label('Alternatif', 'alternatif'); ?>
    	
    				<div class="input">
    					<?php echo Form::input('alternatif', '', array('class' => 'span4')); ?>
    				</div>
    			</div>
        		
        		<div class="clearfix">
        			<?php echo Form::label('Objet', 'title'); ?>
        
        			<div class="input">
        				<?php echo Form::input('title', Input::post('title', ''), array('class' => 'span4')); ?>
        			</div>
        		</div>
        		
        		<div class="clearfix">
        		    <?php echo Form::label('Image attachée', 'image_attach'); ?>
        		    
        		    <div class="input">
					    <?php echo Form::hidden('image_attach', "", array('id' => 'image_attach')); ?>
					</div>
				</div>
        		
        		<div class="clearfix">
        			<?php echo Form::label('Ton message', 'message'); ?>
        
        			<div class="input">
        				<?php echo Form::textarea('message', Input::post('message', ''), array('class' => 'span8', 'rows' => 8)); ?>
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