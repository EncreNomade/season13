<h2>Editing User_address</h2>
<br>

<?php echo render('user/address/_form'); ?>
<p>
	<?php echo Html::anchor('user/address/view/'.$user_address->id, 'View'); ?> |
	<?php echo Html::anchor('user/address', 'Back'); ?></p>
