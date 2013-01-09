<h2>Listing Achat_productprices</h2>
<br>
<?php if ($achat_productprices): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Product id</th>
			<th>Country code</th>
			<th>Taxed price</th>
			<th>Discount</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($achat_productprices as $achat_productprice): ?>		<tr>

			<td><?php echo $achat_productprice->product_id; ?></td>
			<td><?php echo $achat_productprice->country_code; ?></td>
			<td><?php echo $achat_productprice->taxed_price; ?></td>
			<td><?php echo $achat_productprice->discount; ?></td>
			<td>
				<?php echo Html::anchor('achat/productprice/view/'.$achat_productprice->id, 'View'); ?> |
				<?php echo Html::anchor('achat/productprice/edit/'.$achat_productprice->id, 'Edit'); ?> |
				<?php echo Html::anchor('achat/productprice/delete/'.$achat_productprice->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Achat_productprices.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('achat/productprice/create', 'Add new Achat productprice', array('class' => 'btn btn-success')); ?>

</p>
