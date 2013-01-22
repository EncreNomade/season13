<?php  
	$errors = Session::get_flash('error');
	$errors and Session::delete_flash('error');
?>
<h2>Modification adresse</h2>
<?php if($errors): ?>
	<div class="flash-alert">
		<?php foreach ($errors as $e): ?>
			<p><?php echo $e->get_message(); ?></p>			
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<?php echo render('user/address/_form'); ?>

