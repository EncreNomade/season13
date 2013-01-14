<?php if(empty($products)): ?>
	<p><strong>Votre panier est vide.</strong></p>
<?php else: ?>
	<?php foreach ($products as $p): ?>
		<p><strong><?php echo $p->title ?></strong></p>
		<p>prix : <?php echo $p->taxed_price ?></p>
	<?php endforeach; ?>
<?php endif; ?>


