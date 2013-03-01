<h2>Editing Admin_task</h2>
<br>

<?php echo render('admin/task/_form'); ?>
<p>
	<?php echo Html::anchor('admin/task/view/'.$admin_task->id, 'View'); ?> |
	<?php echo Html::anchor('admin/task', 'Back'); ?></p>
