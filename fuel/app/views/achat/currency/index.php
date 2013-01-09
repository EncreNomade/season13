<h2>Listing Achat_currencies</h2>
<br>
<?php if ($achat_currencies): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Iso code</th>
			<th>Iso code num</th>
			<th>Sign</th>
			<th>Active</th>
			<th>Conversion rate</th>
			<th>Supp</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($achat_currencies as $achat_currency): ?>		<tr>

			<td><?php echo $achat_currency->name; ?></td>
			<td><?php echo $achat_currency->iso_code; ?></td>
			<td><?php echo $achat_currency->iso_code_num; ?></td>
			<td><?php echo $achat_currency->sign; ?></td>
			<td><?php echo $achat_currency->active; ?></td>
			<td><?php echo $achat_currency->conversion_rate; ?></td>
			<td><?php echo $achat_currency->supp; ?></td>
			<td>
				<?php echo Html::anchor('achat/currency/view/'.$achat_currency->id, 'View'); ?> |
				<?php echo Html::anchor('achat/currency/edit/'.$achat_currency->id, 'Edit'); ?> |
				<?php echo Html::anchor('achat/currency/delete/'.$achat_currency->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Achat_currencies.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('achat/currency/create', 'Add new Achat currency', array('class' => 'btn btn-success')); ?>

</p>
