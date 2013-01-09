<h2>Listing User_addresses</h2>
<br>
<?php if ($user_addresses): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Firstname</th>
			<th>Lastname</th>
			<th>Address</th>
			<th>Postcode</th>
			<th>City</th>
			<th>Country code</th>
			<th>Tel</th>
			<th>Title</th>
			<th>Supp</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($user_addresses as $user_address): ?>		<tr>

			<td><?php echo $user_address->firstname; ?></td>
			<td><?php echo $user_address->lastname; ?></td>
			<td><?php echo $user_address->address; ?></td>
			<td><?php echo $user_address->postcode; ?></td>
			<td><?php echo $user_address->city; ?></td>
			<td><?php echo $user_address->country_code; ?></td>
			<td><?php echo $user_address->tel; ?></td>
			<td><?php echo $user_address->title; ?></td>
			<td><?php echo $user_address->supp; ?></td>
			<td>
				<?php echo Html::anchor('user/address/view/'.$user_address->id, 'View'); ?> |
				<?php echo Html::anchor('user/address/edit/'.$user_address->id, 'Edit'); ?> |
				<?php echo Html::anchor('user/address/delete/'.$user_address->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No User_addresses.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('user/address/create', 'Add new User address', array('class' => 'btn btn-success')); ?>

</p>
