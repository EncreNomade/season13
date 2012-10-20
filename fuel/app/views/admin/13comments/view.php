<h2>Viewing #<?php echo $admin_13comment->id; ?></h2>

<p>
	<strong>User:</strong>
	<?php echo $admin_13comment->user; ?></p>
<p>
	<strong>Content:</strong>
	<?php echo $admin_13comment->content; ?></p>
<p>
	<strong>Image:</strong>
	<?php echo $admin_13comment->image; ?></p>
<p>
	<strong>Fbpostid:</strong>
	<?php echo $admin_13comment->fbpostid; ?></p>
<p>
	<strong>Position:</strong>
	<?php echo $admin_13comment->position; ?></p>
<p>
	<strong>Verified:</strong>
	<?php echo $admin_13comment->verified; ?></p>
<p>
	<strong>Epid:</strong>
	<?php echo $admin_13comment->epid; ?></p>

<?php echo Html::anchor('admin/13comments/edit/'.$admin_13comment->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/13comments', 'Back'); ?>