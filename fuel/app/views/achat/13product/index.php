<h2>Listing Achat_13products</h2>
<br>
<?php if ($achat_13products): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Reference</th>
			<th>Type</th>
			<th>Pack</th>
			<th>Content</th>
			<th>Presentation</th>
			<th>Tags</th>
			<th>Title</th>
			<th>Category</th>
			<th>Metas</th>
			<th>On sale</th>
			<th>Price</th>
			<th>Discount</th>
			<th>Sales</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($achat_13products as $achat_13product): ?>		<tr>

			<td><?php echo $achat_13product->reference; ?></td>
			<td><?php echo $achat_13product->type; ?></td>
			<td><?php echo $achat_13product->pack; ?></td>
			<td><?php echo $achat_13product->content; ?></td>
			<td><?php echo $achat_13product->presentation; ?></td>
			<td><?php echo $achat_13product->tags; ?></td>
			<td><?php echo $achat_13product->title; ?></td>
			<td><?php echo $achat_13product->category; ?></td>
			<td><?php echo $achat_13product->metas; ?></td>
			<td><?php echo $achat_13product->on_sale; ?></td>
			<td><?php echo $achat_13product->price; ?></td>
			<td><?php echo $achat_13product->discount; ?></td>
			<td><?php echo $achat_13product->sales; ?></td>
			<td>
				<?php echo Html::anchor('achat/13product/view/'.$achat_13product->id, 'View'); ?> |
				<?php echo Html::anchor('achat/13product/edit/'.$achat_13product->id, 'Edit'); ?> |
				<?php echo Html::anchor('achat/13product/delete/'.$achat_13product->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Achat_13products.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('achat/13product/create', 'Add new Achat 13product', array('class' => 'btn btn-success')); ?>

</p>
