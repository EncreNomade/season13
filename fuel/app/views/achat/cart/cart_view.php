<?php 
	$cartProducts = $cart->getProducts();
	$flash = Session::get_flash('cart_error');
	$sign = $cart->getCurrency()->sign;
	Session::delete_flash('cart_error');
?>


<?php if($flash): ?>
	<div class="flash-alert">
		<?php echo $flash; ?>
	</div>
<?php endif; ?>

<?php if(empty($cartProducts)): ?>
	<p><strong>Votre panier est vide.</strong></p>
<?php else: ?>
	<?php foreach ($cartProducts as $cartProd): ?>
		<?php  
			$product = $cartProd->product;
			if ($imgs = $product->getImages()) {
				$image = $imgs[0];
			}
		?>
		<div class="cart_product">
			<div class="imgContainer">
				<?php if(isset($image)) echo "<img src=\"$image\" />"; ?>
			</div>
			<div class="remove_product">
				<button data-productref="<?php echo $product->reference ;?>">Supprimer</button>
			</div>
			<div class="product_info">
				<h3><?php echo $cartProd->product_title ;?></h3>
				<?php 
					$price = '';
					if(floatval($cartProd->discount) < 1){
						$price .= '<del>' . $cartProd->taxed_price . '</del> &rarr; ';
						$newPrice = floatval($cartProd->discount) * floatval($cartProd->taxed_price);
						$price .=  round($newPrice, 2);
					}
					else {
						$price .= $cartProd->taxed_price;
					}
					$price .= $sign;
				?>
				<i><?php echo $price;?></i>
			</div>			
		</div>
	<?php endforeach; ?>
	<div class="total">Total : <strong><?php echo $cart->addition() . $sign; ?></strong></div>

	<div class="pay_button">
	    <a href="<?php echo $base_url; ?>achat/order/view"><?php echo Asset::img("season13/ui/btn_achat.png"); ?></a>
	</div>
<?php endif; ?>



