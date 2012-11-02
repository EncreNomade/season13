<h2>Viewing #<?php echo $admin_13contactmsg->id; ?></h2>

<p>
	<strong>Nom:</strong>
	<?php echo $admin_13contactmsg->nom; ?></p>
<p>
	<strong>User:</strong>
	<?php echo $admin_13contactmsg->user; ?></p>
<p>
	<strong>Email:</strong>
	<?php echo $admin_13contactmsg->email; ?></p>
<p>
	<strong>Destination:</strong>
	<?php echo $admin_13contactmsg->destination; ?></p>
<p>
	<strong>Title:</strong>
	<?php echo $admin_13contactmsg->title; ?></p>
<p>
	<strong>Message:</strong>
	<?php echo $admin_13contactmsg->message; ?></p>
<p>
	<strong>Response:</strong>
	<?php echo $admin_13contactmsg->response; ?></p>

<?php echo Html::anchor('admin/13contactmsgs/edit/'.$admin_13contactmsg->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/13contactmsgs', 'Back'); ?>