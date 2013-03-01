<h2>Viewing #<?php echo $admin_task->id; ?></h2>

<p>
	<strong>Creator:</strong>
	<?php echo $admin_task->creator; ?></p>
<p>
	<strong>Type:</strong>
	<?php echo $admin_task->type; ?></p>
<p>
	<strong>Parameters:</strong>
	<?php echo $admin_task->parameters; ?></p>
<p>
	<strong>Whentodo:</strong>
	<?php echo $admin_task->whentodo; ?></p>
<p>
	<strong>Done:</strong>
	<?php echo $admin_task->done; ?></p>
<p>
	<strong>Whendone:</strong>
	<?php echo $admin_task->whendone; ?></p>

<?php echo Html::anchor('admin/task/edit/'.$admin_task->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/task', 'Back'); ?>