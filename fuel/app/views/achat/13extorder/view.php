<h2>Viewing #<?php echo $achat_13extorder->id; ?></h2>

<p>
	<strong>Reference:</strong>
	<?php echo $achat_13extorder->reference; ?></p>
<p>
	<strong>Owner:</strong>
	<?php echo $achat_13extorder->owner; ?></p>
<p>
	<strong>Order source:</strong>
	<?php echo $achat_13extorder->order_source; ?></p>
<p>
	<strong>Appid:</strong>
	<?php echo $achat_13extorder->appid; ?></p>
<p>
	<strong>Price:</strong>
	<?php echo $achat_13extorder->price; ?></p>
<p>
	<strong>App name:</strong>
	<?php echo $achat_13extorder->app_name; ?></p>

<?php echo Html::anchor('achat/13extorder/edit/'.$achat_13extorder->id, 'Edit'); ?> |
<?php echo Html::anchor('achat/13extorder', 'Back'); ?>