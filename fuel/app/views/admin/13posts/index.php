<div class="main_container">
    <div id="actu_header">
        <h1>L'actualités de SEASON13</h1>
        <?php if (Auth::member(100)): ?>
            <?php echo Html::anchor('admin/13posts/create', 'Add new Admin 13post', array('class' => 'btn btn-success')); ?>
        <?php endif; ?>
    </div>
    
    <div id="actu_banner">
<?php echo Asset::img("season13/cpt_banner.png"); ?>
    </div>
    
<?php if ($admin_13posts): ?>

    <?php foreach ($admin_13posts as $admin_13post): ?>
    <div class="actu_section">
        <div class="actu_title">
            <h2 class="actu_date"><?php echo date("d/m/Y", $admin_13post['created_at']); ?></h2>
            <h2>
                <?php echo $admin_13post['title']; ?>
                <?php if (Auth::member(100)): ?>
                     | 
                    <?php echo Html::anchor('admin/13posts/edit/'.$admin_13post['id'], 'Edit'); ?> |
                    <?php echo Html::anchor('admin/13posts/delete/'.$admin_13post['id'], 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>
                <?php endif; ?>
            </h2>
        </div>
        <div class="actu_content">
            <?php 
                echo html_entity_decode($admin_13post['body']);
            ?>
        </div>
    </div>
    <?php endforeach; ?>
    
<?php else: ?>
    <p>Pas de actualité récente.</p>
    
<?php endif; ?>

</div>
