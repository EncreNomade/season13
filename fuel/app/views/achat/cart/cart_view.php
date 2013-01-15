<?php 
	$products = $cart->getProducts();
	$flash = Session::get_flash('cart_error');
	$sign = $cart->getCurrency()->sign;
	Session::delete_flash('cart_error');
?>


<?php if($flash): ?>
	<div class="flash-alert">
		<?php echo $flash; ?>
	</div>
<?php endif; ?>

<?php if(empty($products)): ?>
	<p><strong>Votre panier est vide.</strong></p>
<?php else: ?>
	<?php foreach ($products as $p): ?>
		<div class="cart_product">
			<p><strong><?php echo $p->product_title ;?></strong></p>
			<p>prix : <?php echo $p->taxed_price . $sign ;?></p>
			<p><button class="remove_product" data-productref="<?php echo $p->product->reference ;?>">Supprimer</button></p>
			<?php // echo DB::last_query() ?>
		</div>
	<?php endforeach; ?>

	<div><?php echo Html::anchor('achat/order/view', '<button>Payer</button>'); ?></div>
<?php endif; ?>



