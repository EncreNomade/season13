<?php $cart = $order->getCart(); ?>

<h2>Commande #<?php echo $order->reference; ?></h2>

<p>
	<strong>User:</strong>
	<?php echo $order->user->pseudo; ?></p>
<p>
	<strong>Cart:</strong>
	Price: <?php echo $cart->addition().'€'; ?><br/>
	Tax rate: <?php echo $cart->tax_rate.'%'; ?><br/>
	<?php foreach ($cart->cartproducts as $product): ?>
	    <?php echo $product->cart_product_id.": ".$product->product_title." - ".$product->taxed_price."€ * ".$product->discount.($product->offer ? " offer to ".$product->offer_target : ""); ?><br/>
	<?php endforeach; ?>
</p>
<p>
	<strong>Country:</strong>
	<?php echo $order->country_code; ?></p>
<p>
	<strong>Currency:</strong>
	<?php echo $order->currency_code; ?></p>
<p>
	<strong>State:</strong>
	<?php echo $order->state; ?></p>
<p>
	<strong>Payment:</strong>
	<?php echo $order->payment; ?></p>
<p>
	<strong>Transaction info:</strong>
	<?php echo $order->transaction_infos; ?></p>
<p>
	<strong>Total paid:</strong>
	<?php echo $order->total_paid_taxed.'€'; ?></p>
<p>
	<strong>Date:</strong>
	<?php echo Date::forge($order->updated_at)->format("%d/%m/%Y"); ?></p>

<?php echo Html::anchor('achat/orderadmin/paid/', 'Paid orders'); ?> |
<?php echo Html::anchor('achat/orderadmin/recent/', 'Recent orders'); ?> |
<?php echo Html::anchor('achat/orderadmin/failed/', 'Failed orders'); ?> |
<?php echo Html::anchor('achat/orderadmin/abandon/', 'Abandoned orders'); ?>