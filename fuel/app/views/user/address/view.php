<h2>Viewing #<?php echo $user_address->id; ?></h2>

<p>
	<strong>Firstname:</strong>
	<?php echo $user_address->firstname; ?></p>
<p>
	<strong>Lastname:</strong>
	<?php echo $user_address->lastname; ?></p>
<p>
	<strong>Address:</strong>
	<?php echo $user_address->address; ?></p>
<p>
	<strong>Postcode:</strong>
	<?php echo $user_address->postcode; ?></p>
<p>
	<strong>City:</strong>
	<?php echo $user_address->city; ?></p>
<p>
	<strong>Country code:</strong>
	<?php echo $user_address->country_code; ?></p>
<p>
	<strong>Tel:</strong>
	<?php echo $user_address->tel; ?></p>
<p>
	<strong>Title:</strong>
	<?php echo $user_address->title; ?></p>
<p>
	<strong>Supp:</strong>
	<?php echo $user_address->supp; ?></p>

<?php echo Html::anchor('user/address/edit/'.$user_address->id, 'Edit'); ?> |
<?php echo Html::anchor('user/address', 'Back'); ?>