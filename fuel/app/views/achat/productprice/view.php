<h2>Viewing #<?php echo $achat_productprice->id; ?></h2>

<p>
	<strong>Product id:</strong>
	<?php echo $achat_productprice->product_id; ?></p>
<p>
	<strong>Country code:</strong>
	<?php echo $achat_productprice->country_code; ?></p>
<p>
	<strong>Taxed price:</strong>
	<?php echo $achat_productprice->taxed_price; ?></p>
<p>
	<strong>Discount:</strong>
	<?php echo $achat_productprice->discount; ?></p>

<?php echo Html::anchor('achat/productprice/edit/'.$achat_productprice->id, 'Edit'); ?> |
<?php echo Html::anchor('achat/productprice', 'Back'); ?>