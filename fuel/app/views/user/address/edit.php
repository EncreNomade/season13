<?php  
	$errors = Session::get_flash('error');
	$errors and Session::delete_flash('error');
?>
<h2>Adresse de facturation</h2>
<p>Les données * sont indispensables pour la facturation</p>
<?php if($errors): ?>
	<div class="flash-alert">
		<?php foreach ($errors as $e): ?>
			<p><?php echo $e->get_message(); ?></p>			
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<?php echo render('user/address/_form'); ?>