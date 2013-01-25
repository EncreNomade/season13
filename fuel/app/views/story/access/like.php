<?php echo Form::open(array('action' => $root_path.'accessaction/liked', 'method' => 'POST', 'id' => 'like_form')); ?>
    <div class="section">
        <h5>
            Nous t'offrons cet épisode si tu aimes Season13.com sur Facebook.<br/><br/>
        </h5>
    </div>

	<div class="section" id="like_section">
	    
	</div>

    <div class="section">
        <div class="sep_line">
        </div>
        <p>
            <span>Sinon,</span>
        </p>
        <p>
        	<!--<a href="javascript:cart.add('9782717765334');" id="access_buy_btn4" class="right"><?php echo 'J\'achète l\'épisode 4: '.$price.'€'; ?></a>-->
        	<?php echo Form::button('buy', 'J\'achète l\'épisode 4: '.$price.'€', array('id' => 'access_buy_btn4')); ?>
        </p>
    </div>
<?php echo Form::close(); ?>