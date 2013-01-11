<h2>Listing Achat_countries</h2>
<br>
<?php if ($achat_countries): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Iso code</th>
			<th>Language</th>
			<th>Tax rate</th>
			<th>Currency code</th>
			<th>Active</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($achat_countries as $achat_country): ?>		<tr>

			<td><?php echo $achat_country->name; ?></td>
			<td><?php echo $achat_country->iso_code; ?></td>
			<td><?php echo $achat_country->language; ?></td>
			<td><?php echo $achat_country->tax_rate; ?></td>
			<td><?php echo $achat_country->currency_code; ?></td>
			<td><?php echo $achat_country->active; ?></td>
			<td>
				<?php echo Html::anchor('achat/country/view/'.$achat_country->id, 'View'); ?> |
				<?php echo Html::anchor('achat/country/edit/'.$achat_country->id, 'Edit'); ?> |
				<?php echo Html::anchor('achat/country/delete/'.$achat_country->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Achat_countries.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('achat/country/create', 'Add new Achat country', array('class' => 'btn btn-success')); ?>

</p>
