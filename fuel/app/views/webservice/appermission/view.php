<h2>Viewing #<?php echo $webservice_appermission->id; ?></h2>

<p>
	<strong>Appid:</strong>
	<?php echo $webservice_appermission->appid; ?></p>
<p>
	<strong>Action:</strong>
	<?php echo $webservice_appermission->action; ?></p>
<p>
	<strong>Can get:</strong>
	<?php echo $webservice_appermission->can_get; ?></p>
<p>
	<strong>Can post:</strong>
	<?php echo $webservice_appermission->can_post; ?></p>
<p>
	<strong>Can put:</strong>
	<?php echo $webservice_appermission->can_put; ?></p>
<p>
	<strong>Can delete:</strong>
	<?php echo $webservice_appermission->can_delete; ?></p>

<?php echo Html::anchor('webservice/appermission/edit/'.$webservice_appermission->id, 'Edit'); ?> |
<?php echo Html::anchor('webservice/appermission', 'Back'); ?>