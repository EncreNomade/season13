<?php echo Form::open(array('action' => $root_path.'accessaction/invitation_mail', 'method' => 'POST', 'id' => 'invitation_form')); ?>
    <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token(), array('id' => 'invitation_csrf')); ?>
    <div class="section">
        <h5>
            Aide-nous à faire connaître Voodoo Connection.<br/>
            Nous t'offrons cet épisode si tu invites 5 amis par Facebook.<br/>
            <br/>
        </h5>
    </div>
    
    <div class="section" id="fbsend_section">
        <div class="fb-send" data-href="http://season13.com" data-font="lucida grande"></div>
    </div>
    
    <div class="section">
        <h5>
            <br/>Ou par mail:
        </h5>
        <br/>
    </div>
    
	<div class="section">
	    <p>
			<?php echo Form::label('Mail de ton 1 er Ami', 'to1'); ?>
			<?php echo Form::input('to1'); ?>
		</p>
		<p>
			<?php echo Form::label('Mail de ton 2 ème Ami', 'to2'); ?>
			<?php echo Form::input('to2'); ?>
		</p>
		<p>
			<?php echo Form::label('Mail de ton 3 ème Ami', 'to3'); ?>
			<?php echo Form::input('to3'); ?>
		</p>
		<p>
			<?php echo Form::label('Mail de ton 4 ème Ami', 'to4'); ?>
			<?php echo Form::input('to4'); ?>
		</p>
		<p>
			<?php echo Form::label('Mail de ton 5 ème Ami', 'to5'); ?>
			<?php echo Form::input('to5'); ?>
		</p>
		
		<p>
		    <?php echo Form::submit('submit', 'Envoyer', array('id' => 'send_mail_btn')); ?>
		</p>
	</div>
	
	<div class="section">
	    <div class="sep_line"></div>
		<p>
		    <label>Sinon,</label>
		    <!--<a href="javascript:cart.add('isbn12852934');" id="access_buy_btn3" class="right">J'achète l'épisode 3: <?php echo$price.'€'; ?></a>-->
		    <?php echo Form::button('buy', 'J\'achète l\'épisode 3: '.$price.'€', array('id' => 'access_buy_btn3')); ?>
		</p>
	</div>
<?php echo Form::close(); ?>