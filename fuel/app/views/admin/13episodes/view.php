<h2>Viewing #<?php echo $admin_13episode->id; ?></h2>

<p>
	<strong>Title:</strong>
	<?php echo $admin_13episode->title; ?></p>
<p>
	<strong>Story:</strong>
	<?php echo $admin_13episode->story; ?></p>
<p>
	<strong>Season:</strong>
	<?php echo $admin_13episode->season; ?></p>
<p>
	<strong>Episode:</strong>
	<?php echo $admin_13episode->episode; ?></p>
<p>
	<strong>Path:</strong>
	<?php echo $admin_13episode->path; ?></p>
<p>
	<strong>Bref:</strong>
	<?php echo $admin_13episode->bref; ?></p>
<p>
	<strong>Image:</strong>
	<?php echo $admin_13episode->image; ?></p>
<p>
	<strong>Dday:</strong>
	<?php echo $admin_13episode->dday; ?></p>
<p>
	<strong>Price:</strong>
	<?php echo $admin_13episode->price; ?></p>
<p>
	<strong>Info supp:</strong>
	<?php echo $admin_13episode->info_supp; ?></p>

<?php echo Html::anchor('admin/13episodes/edit/'.$admin_13episode->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/13episodes', 'Back'); ?>