<h2>Viewing #<?php echo $achat_currency->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $achat_currency->name; ?></p>
<p>
	<strong>Iso code:</strong>
	<?php echo $achat_currency->iso_code; ?></p>
<p>
	<strong>Iso code num:</strong>
	<?php echo $achat_currency->iso_code_num; ?></p>
<p>
	<strong>Sign:</strong>
	<?php echo $achat_currency->sign; ?></p>
<p>
	<strong>Active:</strong>
	<?php echo $achat_currency->active; ?></p>
<p>
	<strong>Conversion rate:</strong>
	<?php echo $achat_currency->conversion_rate; ?></p>
<p>
	<strong>Supp:</strong>
	<?php echo $achat_currency->supp; ?></p>

<?php echo Html::anchor('achat/currency/edit/'.$achat_currency->id, 'Edit'); ?> |
<?php echo Html::anchor('achat/currency', 'Back'); ?>