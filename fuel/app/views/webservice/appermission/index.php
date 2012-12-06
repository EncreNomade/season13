<h2>Listing Webservice_appermissions</h2>
<br>
<?php if ($webservice_appermissions): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Appid</th>
			<th>Action</th>
			<th>Can get</th>
			<th>Can post</th>
			<th>Can put</th>
			<th>Can delete</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($webservice_appermissions as $webservice_appermission): ?>		<tr>

			<td><?php echo $webservice_appermission->appid; ?></td>
			<td><?php echo $webservice_appermission->action; ?></td>
			<td><?php echo $webservice_appermission->can_get; ?></td>
			<td><?php echo $webservice_appermission->can_post; ?></td>
			<td><?php echo $webservice_appermission->can_put; ?></td>
			<td><?php echo $webservice_appermission->can_delete; ?></td>
			<td>
				<?php echo Html::anchor('webservice/appermission/view/'.$webservice_appermission->id, 'View'); ?> |
				<?php echo Html::anchor('webservice/appermission/edit/'.$webservice_appermission->id, 'Edit'); ?> |
				<?php echo Html::anchor('webservice/appermission/delete/'.$webservice_appermission->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Webservice_appermissions.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('webservice/appermission/create', 'Add new Webservice appermission', array('class' => 'btn btn-success')); ?>

</p>
