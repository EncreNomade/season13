<h2>Listing Admin_13userpossesions</h2>
<br>
<?php if ($admin_13userpossesions): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>User mail</th>
			<th>Episode</th>
			<th>Source</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($admin_13userpossesions as $admin_13userpossesion): ?>		<tr>

			<td><?php echo $admin_13userpossesion->user_mail; ?></td>
			<td><?php 
			
			    $ep = Model_Admin_13episode::find($admin_13userpossesion->episode_id);
			    if(is_null($ep)) 
			        echo "Not found";
			    else 
    			    echo $ep->story." s".$ep->season."e".$ep->episode;
			    
			?></td>
			<td><?php 
			    
			    Config::load('custom', true);
			    $codes = (array) Config::get('custom.possesion_src', array ());
			    
			    echo $codes[$admin_13userpossesion->source]; 
			    
			?></td>
			<td><?php echo $admin_13userpossesion->source_ref; ?></td>
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
