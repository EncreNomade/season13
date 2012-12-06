<style>
	.main_container div {
		font: normal 14px/25px 'DroidSansRegular', Arial, Helvetica;
		margin: 30px 100px 30px 100px;
	}
	.main_container > div {
	    position: relative;
	    width: 650px;
	    margin: 20px auto;
	}
	.main_container h1 {
	    width: 220px; 
	    height: 50px; 
	    margin: 10px 215px 10px 215px;
	    font: normal 30px/45px 'DroidSansBold';
	}
	.main_container strong {
	    font: normal 20px/32px 'DroidSansBold';
	}
	.main_container h5.gris {
	    color: #686868;
	}
	.main_container p {
	    
	}
</style>

<div class="main_container">
<div>
    <h1>OFFRE CADEAU</h1>
    
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
            <p>
                <?php echo Form::submit('envoyer', 'VALIDE ICI TON CODE CADEAU', array('class' => 'btn btn-primary', 'style' => 'width: 220px; height: 50px; margin: 10px 215px 10px 215px; background: rgb(246, 168, 0); border-radius: 10px; text-decoration: none; text-align: center; color: #fff; font: bold 12px/50px sans-serif; text-align: center;')); ?>
            </p>
            <p style="padding: 0px 165px; width: 320px; text-align: center;">
                Ton code cadeau: <?php echo Form::input('code', Input::get('code', $code)); ?>
            </p>
        <?php echo Form::close(); ?>
    </h5>
</div>
</div>