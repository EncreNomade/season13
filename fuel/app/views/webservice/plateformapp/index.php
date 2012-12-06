<h2>Listing Webservice_plateformapps</h2>
<br>
<?php if ($webservice_plateformapps): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Appid</th>
			<th>Appsecret</th>
			<th>Appname</th>
			<th>Description</th>
			<th>Active</th>
			<th>Ip</th>
			<th>Host</th>
			<th>Extra</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($webservice_plateformapps as $webservice_plateformapp): ?>		<tr>

			<td><?php echo $webservice_plateformapp->appid; ?></td>
			<td><?php echo $webservice_plateformapp->appsecret; ?></td>
			<td><?php echo $webservice_plateformapp->appname; ?></td>
			<td><?php echo $webservice_plateformapp->description; ?></td>
			<td><?php echo $webservice_plateformapp->active; ?></td>
			<td><?php echo $webservice_plateformapp->ip; ?></td>
			<td><?php echo $webservice_plateformapp->host; ?></td>
			<td><?php echo $webservice_plateformapp->extra; ?></td>
			<td>
				<?php echo Html::anchor('webservice/plateformapp/view/'.$webservice_plateformapp->id, 'View'); ?> |
				<?php echo Html::anchor('webservice/plateformapp/edit/'.$webservice_plateformapp->id, 'Edit'); ?> |
				<?php echo Html::anchor('webservice/plateformapp/delete/'.$webservice_plateformapp->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Webservice_plateformapps.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('webservice/plateformapp/create', 'Add new Webservice plateformapp', array('class' => 'btn btn-success')); ?>

</p>
