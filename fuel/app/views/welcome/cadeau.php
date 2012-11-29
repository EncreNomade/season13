<style>
	.main_container div {
		font: normal 14px/25px 'DroidSansRegular', Arial, Helvetica;
		margin: 30px 100px 30px 100px;
	}
	.main_container h1 {
	    font: normal 30px/45px 'DroidSansBold';
	}
	.main_container strong {
	    font: normal 20px/32px 'DroidSansBold';
	}
	.main_container h5.gris {
	    color: #686868;
	}
</style>

<div class="main_container">
<div>
    <h1>Obtenir ton cadeau de SEASON13</h1>
    
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
    
    <h5>
        <?php echo Form::open(array('action' => $base_url.'cadeau', 'method' => 'POST')); ?>
            <?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token()); ?>
            Ton code de cadeau: <?php echo Form::input('code', Input::get('code', $code)); ?>
            <?php echo Form::submit('envoyer', 'Ouvrir', array('class' => 'btn btn-primary')); ?>
        <?php echo Form::close(); ?>
    </h5>
</div>
</div>