<div class="main_container">
    <h2>Editing Admin_13post</h2>
    <br>
    
    <?php echo render('admin/13posts/_form'); ?>
    <p>
    	<?php echo Html::anchor('admin/13posts/view/'.$admin_13post->id, 'View'); ?> |
    	<?php echo Html::anchor('admin/13posts', 'Back'); ?></p>

</div>