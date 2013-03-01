<h2>Listing Admin_tasks</h2>
<br>
<?php if ($admin_tasks): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Creator</th>
			<th>Type</th>
			<th>Parameters</th>
			<th>Whentodo</th>
			<th>Done</th>
			<th>Whendone</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($admin_tasks as $admin_task): ?>		<tr>

			<td><?php echo $admin_task->creator; ?></td>
			<td><?php echo $admin_task->type; ?></td>
			<td><?php echo $admin_task->parameters; ?></td>
			<td><?php echo $admin_task->whentodo; ?></td>
			<td><?php echo $admin_task->done; ?></td>
			<td><?php echo $admin_task->whendone; ?></td>
			<td>
				<?php echo Html::anchor('admin/task/view/'.$admin_task->id, 'View'); ?> |
				<?php echo Html::anchor('admin/task/edit/'.$admin_task->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/task/delete/'.$admin_task->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Admin_tasks.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/task/create', 'Add new Admin task', array('class' => 'btn btn-success')); ?>

</p>
