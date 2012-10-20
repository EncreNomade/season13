<h2>Listing Admin_13comments</h2>
<br>
<?php if ($admin_13comments): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>User</th>
			<th>Content</th>
			<th>Image</th>
			<th>Fbpostid</th>
			<th>Position</th>
			<th>Verified</th>
			<th>Epid</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($admin_13comments as $admin_13comment): ?>		<tr>

			<td><?php echo $admin_13comment->user; ?></td>
			<td><?php echo $admin_13comment->content; ?></td>
			<td><?php echo $admin_13comment->image; ?></td>
			<td><?php echo $admin_13comment->fbpostid; ?></td>
			<td><?php echo $admin_13comment->position; ?></td>
			<td><?php echo $admin_13comment->verified; ?></td>
			<td><?php echo $admin_13comment->epid; ?></td>
			<td>
				<?php echo Html::anchor('admin/13comments/view/'.$admin_13comment->id, 'View'); ?> |
				<?php echo Html::anchor('admin/13comments/edit/'.$admin_13comment->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/13comments/delete/'.$admin_13comment->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Admin_13comments.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/13comments/create', 'Add new Admin 13comment', array('class' => 'btn btn-success')); ?>

</p>
