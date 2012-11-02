<h2>Listing Admin_13contactmsgs</h2>
<br>
<?php if ($admin_13contactmsgs): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Nom</th>
			<th>User</th>
			<th>Email</th>
			<th>Destination</th>
			<th>Title</th>
			<th>Message</th>
			<th>Response</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($admin_13contactmsgs as $admin_13contactmsg): ?>		<tr>

			<td><?php echo $admin_13contactmsg->nom; ?></td>
			<td><?php echo $admin_13contactmsg->user; ?></td>
			<td><?php echo $admin_13contactmsg->email; ?></td>
			<td><?php echo $admin_13contactmsg->destination; ?></td>
			<td><?php echo $admin_13contactmsg->title; ?></td>
			<td><?php echo $admin_13contactmsg->message; ?></td>
			<td><?php echo $admin_13contactmsg->response; ?></td>
			<td>
				<?php echo Html::anchor('admin/13contactmsgs/view/'.$admin_13contactmsg->id, 'View'); ?> |
				<?php echo Html::anchor('admin/13contactmsgs/edit/'.$admin_13contactmsg->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/13contactmsgs/delete/'.$admin_13contactmsg->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Admin_13contactmsgs.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/13contactmsgs/create', 'Add new Admin 13contactmsg', array('class' => 'btn btn-success')); ?>

</p>
