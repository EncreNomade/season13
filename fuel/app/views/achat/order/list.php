<?php echo Html::anchor('achat/orderadmin/paid/', 'Paid orders'); ?> |
<?php echo Html::anchor('achat/orderadmin/recent/', 'Recent orders'); ?> |
<?php echo Html::anchor('achat/orderadmin/failed/', 'Failed orders'); ?> |
<?php echo Html::anchor('achat/orderadmin/abandon/', 'Abandoned orders'); ?>

<h2><?php echo $title; ?></h2>
<br>
<?php if ($orders): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Reference</th>
			<th>User</th>
			<th>Cart</th>
			<th>Country</th>
			<th>Currency</th>
			<th>State</th>
			<th>Payment</th>
			<th>Total paid</th>
			<th>Date</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($orders as $order): ?>		
        <tr>
        <?php $cart = $order->getCart(); ?>

			<td><?php echo $order->reference; ?></td>
			<td><?php echo $order->user->pseudo; ?></td>
			<td>
			    <?php echo Html::anchor('achat/cartadmin/view/'.$cart->id, $cart->addition().'€ / '.count($cart->cartproducts).' products'); ?>
			</td>
			<td><?php echo $order->country_code; ?></td>
			<td><?php echo $order->currency_code; ?></td>
			<td><?php echo $order->state; ?></td>
			<td><?php echo $order->payment; ?></td>
			<td><?php echo $order->total_paid_taxed.'€'; ?></td>
			<td><?php echo Date::forge($order->updated_at)->format("%d/%m/%Y"); ?></td>
			<td>
				<?php echo Html::anchor('achat/orderadmin/view/'.$order->id, 'View'); ?>
			</td>
		</tr>
<?php endforeach; ?>	
    </tbody>
</table>

<?php else: ?>
<p>Vide.</p>

<?php endif; ?>

</p>
