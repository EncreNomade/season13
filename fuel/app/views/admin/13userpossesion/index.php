<h2>Listing Admin_13userpossesions</h2>
<br>
<?php if ($admin_13userpossesions): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>User id</th>
			<th>Episode id</th>
			<th>Source</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($admin_13userpossesions as $admin_13userpossesion): ?>		<tr>

			<td><?php echo Model_13user::find( $admin_13userpossesion->user_id )->pseudo; ?></td>
			<td><?php echo $admin_13userpossesion->episode_id; ?></td>
			<td><?php echo $admin_13userpossesion->source; ?></td>
			<td>
				<?php echo Html::anchor('admin/13userpossesion/view/'.$admin_13userpossesion->id, 'View'); ?> |
				<?php echo Html::anchor('admin/13userpossesion/edit/'.$admin_13userpossesion->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/13userpossesion/delete/'.$admin_13userpossesion->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Admin_13userpossesions.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/13userpossesion/create', 'Add new Admin 13userpossesion', array('class' => 'btn btn-success')); ?>

</p>
