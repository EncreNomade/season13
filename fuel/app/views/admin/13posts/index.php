<div class="main_container">
    <div id="actu_header">
        <h1>L'actualité de SEASON13</h1>
        <?php if (Auth::member(100)): ?>
            <?php echo Html::anchor('admin/13posts/create', 'Add new Admin 13post', array('class' => 'btn btn-success')); ?>
        <?php endif; ?>
    </div>
    
    <div id="actu_banner">
<?php echo Asset::img("season13/cpt_banner.png"); ?>
    </div>
    
<?php if ($admin_13posts): ?>

    <?php 
    foreach ($admin_13posts as $admin_13post): 
        $date = Date::forge($admin_13post['created_at']);
    ?>
    <div class="actu_section">
        <div class="actu_title">
            <h2 class="actu_date"><?php echo $date->format("%d/%m/%Y"); ?></h2>
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
        <div class="actu_footer">
            <h5>Publié par <?php 
                $username = "inconnu";
                $user = Model_13user::find_by_id($admin_13post['user_id']);
                if(!is_null($user)) $username = $user->pseudo;
                echo $username." à ".$date->format("%d/%m/%Y %H:%M"); 
            ?></h5>
        </div>
    </div>
    <?php endforeach; ?>
    
<?php else: ?>
    <p>Pas de actualité récente.</p>
    
<?php endif; ?>

</div>
