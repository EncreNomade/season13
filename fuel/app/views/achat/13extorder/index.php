<h2>Listing Achat_13extorders</h2>
<br>
<?php if ($achat_13extorders): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Reference</th>
			<th>Owner</th>
			<th>Order source</th>
			<th>Appid</th>
			<th>Price</th>
			<th>App name</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($achat_13extorders as $achat_13extorder): ?>		<tr>

			<td><?php echo $achat_13extorder->reference; ?></td>
			<td><?php echo $achat_13extorder->owner; ?></td>
			<td><?php echo $achat_13extorder->order_source; ?></td>
			<td><?php echo $achat_13extorder->appid; ?></td>
			<td><?php echo $achat_13extorder->price; ?></td>
			<td><?php echo $achat_13extorder->app_name; ?></td>
			<td>
				<?php echo Html::anchor('achat/13extorder/view/'.$achat_13extorder->id, 'View'); ?> |
				<?php echo Html::anchor('achat/13extorder/edit/'.$achat_13extorder->id, 'Edit'); ?> |
				<?php echo Html::anchor('achat/13extorder/delete/'.$achat_13extorder->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Achat_13extorders.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('achat/13extorder/create', 'Add new Achat 13extorder', array('class' => 'btn btn-success')); ?>

</p>
