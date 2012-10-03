<div class="main_container">

    <h2>Viewing #<?php echo $admin_13post->id; ?></h2>
    
    <p>
    	<strong>Title:</strong>
    	<?php echo $admin_13post->title; ?></p>
    <p>
    	<strong>Slug:</strong>
    	<?php echo $admin_13post->slug; ?></p>
    <p>
    	<strong>User id:</strong>
    	<?php echo $admin_13post->user_id; ?></p>
    <p>
    	<strong>Summary:</strong>
    	<?php echo $admin_13post->summary; ?></p>
    <p>
    	<strong>Body:</strong>
    	<?php echo $admin_13post->body; ?></p>
    <p>
    	<strong>Categories:</strong>
    	<?php echo $admin_13post->categories; ?></p>
    
    <?php echo Html::anchor('admin/13posts/edit/'.$admin_13post->id, 'Edit'); ?> |
    <?php echo Html::anchor('admin/13posts', 'Back'); ?>

</div>