<h2>Listing Users</h2>
<br>
<?php if ($users): ?>
<table class="table table-striped">
	<thead>
		<tr>
		    <th>Avatar</th>
			<th>Pseudo</th>
			<th>Group</th>
			<th>Email</th>
			<th>Portable</th>
			<th>Gender</th>
			<th>Birthday</th>
			<th>Pays</th>
			<th>Code Postal</th>
			<th>Facebook</th>
			<th>Extra</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($users as $user): ?>		<tr>

			<td><img src="<?php echo $user->avatar; ?>" style="width: 50px; height: 50px;"/></td>
			<td><?php echo $user->pseudo; ?></td>
			<td><?php echo $user->group; ?></td>
			<td><?php echo $user->email; ?></td>
			<td><?php echo $user->portable; ?></td>
			<td><?php echo $user->sex == "m" ? "Male" : "Female"; ?></td>
			<td><?php echo $user->birthday; ?></td>
			<td><?php echo $user->pays; ?></td>
			<td><?php echo $user->code_postal; ?></td>
			<td><a href="http://www.facebook.com/<?php echo $user->fbid; ?>"><?php echo $user->fbid; ?></a></td>
			<td><?php echo $user->profile_fields; ?></td>
			<td>
				<?php echo Html::anchor('admin/13users/view/'.$user->id, 'View'); ?> |
				<?php echo Html::anchor('admin/13users/edit/'.$user->id, 'Edit'); ?> |
				<?php //echo Html::anchor('webservice/plateformapp/delete/'.$webservice_plateformapp->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No User.</p>

<?php endif; ?><p>
	<?php //echo Html::anchor('admin/13users/create', 'Add new user', array('class' => 'btn btn-success')); ?>

</p>
