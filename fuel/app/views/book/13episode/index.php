<h2>Listing 13episodes</h2>
<br>
<?php if ($admin_13episodes): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Title</th>
			<th>Story</th>
			<th>Season</th>
			<th>Episode</th>
			<th>Path</th>
			<th>Bref</th>
			<th>Image</th>
			<th>Dday</th>
			<th>Price</th>
			<th>Info supp</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($admin_13episodes as $admin_13episode): ?>		<tr>

			<td><?php echo $admin_13episode->title; ?></td>
			<td><?php echo $admin_13episode->story; ?></td>
			<td><?php echo $admin_13episode->season; ?></td>
			<td><?php echo $admin_13episode->episode; ?></td>
			<td><?php echo $admin_13episode->path; ?></td>
			<td><?php echo $admin_13episode->bref; ?></td>
			<td><?php echo $admin_13episode->image; ?></td>
			<td><?php echo $admin_13episode->dday; ?></td>
			<td><?php echo $admin_13episode->price; ?></td>
			<td><?php echo $admin_13episode->info_supp; ?></td>
			<td>
				<?php echo Html::anchor('book/13episode/view/'.$admin_13episode->id, 'View'); ?> |
				<?php echo Html::anchor('book/13episode/edit/'.$admin_13episode->id, 'Edit'); ?> |
				<?php echo Html::anchor('book/13episode/delete/'.$admin_13episode->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No 13episodes.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('book/13episode/create', 'Add new 13episode', array('class' => 'btn btn-success')); ?>

</p>
