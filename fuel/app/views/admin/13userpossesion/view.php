<h2>Viewing #<?php echo $admin_13userpossesion->id; ?></h2>

<p>
	<strong>User id:</strong>
	<?php echo $admin_13userpossesion->user_mail; ?></p>
<p>
	<strong>Episode id:</strong>
	<?php echo $admin_13userpossesion->episode_id; ?></p>
<p>
	<strong>Source:</strong>
	<?php echo $admin_13userpossesion->source; ?></p>
<p>
	<strong>Source reference:</strong>
	<?php echo $admin_13userpossesion->source_ref; ?></p>

<?php echo Html::anchor('admin/13userpossesion/edit/'.$admin_13userpossesion->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/13userpossesion', 'Back'); ?>