<h2>Viewing #<?php echo $webservice_plateformapp->id; ?></h2>

<p>
	<strong>Appid:</strong>
	<?php echo $webservice_plateformapp->appid; ?></p>
<p>
	<strong>Appsecret:</strong>
	<?php echo $webservice_plateformapp->appsecret; ?></p>
<p>
	<strong>Appname:</strong>
	<?php echo $webservice_plateformapp->appname; ?></p>
<p>
	<strong>Description:</strong>
	<?php echo $webservice_plateformapp->description; ?></p>
<p>
	<strong>Active:</strong>
	<?php echo $webservice_plateformapp->active; ?></p>
<p>
	<strong>Ip:</strong>
	<?php echo $webservice_plateformapp->ip; ?></p>
<p>
	<strong>Host:</strong>
	<?php echo $webservice_plateformapp->host; ?></p>
<p>
	<strong>Extra:</strong>
	<?php echo $webservice_plateformapp->extra; ?></p>

<?php echo Html::anchor('webservice/plateformapp/edit/'.$webservice_plateformapp->id, 'Edit'); ?> |
<?php echo Html::anchor('webservice/plateformapp', 'Back'); ?>