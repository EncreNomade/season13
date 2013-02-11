<?php echo Form::open(array('action' => $root_path.'accessaction/liked', 'method' => 'POST', 'id' => 'like_form')); ?>
    <div class="section">
        <h5>
            Nous t'offrons cet épisode si tu aimes Season13.com sur Facebook.<br/><br/>
        </h5>
    </div>

	<div class="section" id="like_section">
	    <fb:like href="http://season13.com/" id="fb_like_form_btn" send="true" width="400" show_faces="true" font="lucida grande">
	    </fb:like>
	</div>

    <div class="section">
        <div class="sep_line">
        </div>
        <p>
            <span>Sinon,</span>
        </p>
        <p>
        	<a href="javascript:cart.add('9791092330021');" id="access_buy_btn4" class="right"><?php echo 'J\'achète l\'épisode 4: '.$price.'€'; ?></a>
        </p>
    </div>
<?php echo Form::close(); ?>