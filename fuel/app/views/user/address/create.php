<?php  
	$errors = Session::get_flash('error');
	$errors and Session::delete_flash('error');
?>
<h2>Création adresse</h2>
<?php if($errors): ?>
	<div class="flash-alert">
		<?php if(is_array($errors)): ?>
			<?php foreach ($errors as $e): ?>
				<p><?php echo $e->get_message(); ?></p>			
			<?php endforeach; ?>
		<?php else: ?>
			<p><?php echo $errors ?></p>
		<?php endif; ?>
	</div>
<?php endif; ?>

<?php echo render('user/address/_form', array('requestType' => 'create')); ?>
