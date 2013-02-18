<?php 
    $flash = Session::get_flash('cart_error');
    Session::delete_flash('cart_error');
    
    if($cart) {
    	$cartProducts = $cart->getProducts();
    	$sign = $cart->getCurrency()->sign;
	}
?>


<?php if($flash): ?>
	<div class="flash-alert">
		<?php echo $flash; ?>
	</div>
<?php endif; ?>

<?php if(empty($cart) || empty($cartProducts) || count($cartProducts) == 0): ?>
	<p><strong>Votre panier est vide.</strong></p>
<?php else: ?>
    
	<?php foreach ($cartProducts as $cartProd): ?>
		<?php
			$product = $cartProd->product;
			if ($imgs = $product->getImages()) {
				$image = $imgs[0];
			}
		?>
		<div class="cart_product" 
		     data-productref="<?php echo $product->reference ;?>" 
		     data-cartpid="<?php echo $cartProd->cart_product_id; ?>">
			<div class="imgContainer">
				<?php if(isset($image)) echo "<img src=\"$image\" />"; ?>
			</div>
			<div class="remove_product">
				<button>Supprimer</button>
			</div>
			<div class="product_info">
				<h3><?php echo $cartProd->product_title ;?></h3>
				<?php 
					$price = '';
					if(floatval($cartProd->discount) < 1){
						$price .= '<del>' . $cartProd->taxed_price . '</del> &rarr; ' . $cartProd->getRealPrice();
					}
					else {
						$price .= $cartProd->taxed_price;
					}
					$price .= $sign;
				?>
				<i><?php echo $price;?></i>
				<p class="offer_product">
				    <?php echo Asset::img('season13/ui/cart_gift.png'); ?>
				
				<?php if($cartProd->offer): ?>
				    Cadeau pour <strong><?php echo $cartProd->offer_target; ?></strong>
				<?php else: ?>
				    <a class="click_to_offer">Envie de faire un cadeau ?</a>
				<?php endif; ?>
				    
				</p>
			</div>
		</div>
	<?php endforeach; ?>
	<div class="total">Total : <strong><?php echo $cart->addition() . $sign; ?></strong></div>

	<div class="pay_button">
		<?php echo Html::anchor('achat/order/view', Asset::img("season13/ui/btn_achat.png")) ?>
	</div>
<?php endif; ?>



