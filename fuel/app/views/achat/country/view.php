<h2>Viewing #<?php echo $achat_country->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $achat_country->name; ?></p>
<p>
	<strong>Iso code:</strong>
	<?php echo $achat_country->iso_code; ?></p>
<p>
	<strong>Language:</strong>
	<?php echo $achat_country->language; ?></p>
<p>
	<strong>Tax rate:</strong>
	<?php echo $achat_country->tax_rate; ?></p>
<p>
	<strong>Currency code:</strong>
	<?php echo $achat_country->currency_code; ?></p>
<p>
	<strong>Active:</strong>
	<?php echo $achat_country->active; ?></p>

<?php echo Html::anchor('achat/country/edit/'.$achat_country->id, 'Edit'); ?> |
<?php echo Html::anchor('achat/country', 'Back'); ?>