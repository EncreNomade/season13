<?php echo Form::open(array('action' => $root_path.'accessaction/invitation_mail', 'method' => 'POST', 'id' => 'invitation_form')); ?>
    <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token(), array('id' => 'invitation_csrf')); ?>
    <div class="section">
        <h5>Aide-nous à faire connaître Voodoo Connection.<br/>
        Invite 5 de tes amis à le découvrir</h5>
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
		<!--
		<p>
			<?php echo Form::label('Ton invitation sera envoyée sous le nom de: ', 'from'); ?>
			<?php echo Form::input('from', $pseudo); ?>
		</p>-->
		
		<p>
		    <?php echo Form::submit('submit', 'Envoyer', array('id' => 'access_submit_btn3')); ?>
		</p>
		<p>
		    <label>Je ne souhaite pas inviter 5 amis</label>
		    <?php echo Form::button('buy', 'J\'achète l\'épisode 3: '.$price.'€', array('id' => 'access_buy_btn3')); ?>
		</p>
	</div>
<?php echo Form::close(); ?>