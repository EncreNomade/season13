<h2>Listing all comments not reviewed</h2>
<br>
<?php if ($comments): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>User</th>
			<th>Content</th>
			<th>Image</th>
			<th>Verified</th>
			<th>Episode</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($comments as $comment): ?>		<tr>

			<td><?php
			    $user_profile = Model_13user::find($comment->user);
			    if($user_profile) 
			        echo $user_profile->pseudo; 
			?></td>
			<td><?php echo $comment->content; ?></td>
			<td><img src="<?php echo $comment->image; ?>"/></td>
			<td><?php echo $comment->verified; ?></td>
			<td><?php echo $comment->episode->story." S".$comment->episode->season."E".$comment->episode->episode; ?></td>
			<td>
				<?php echo Html::anchor('admin/13comments/moderatorfail?id='.$comment->id, 'refuse'); ?> |
				<?php echo Html::anchor('admin/13comments/delete/'.$comment->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>
			</td>
		</tr>
<?php endforeach; ?>
    </tbody>
</table>

<p>
<form method="post" action="<?php echo $remote_path; ?>admin/13comments/moderatorapproveall">    <input type="submit" value="Approve all" class='btn btn-primary'/>
</form>
</p>

<?php else: ?>
<p>No un reviewed comments.</p>

<?php endif; ?>