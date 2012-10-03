<div class="main_container">

    <div class="center">
        <div id="back" class="layer">
<?php echo Asset::img('illus/petite_ceinture.jpg'); ?>
        </div>
    </div>
    <div id="booktitle" class="layer">
<?php echo Asset::img('illus/titre_2.png'); ?>
    </div>
    <div id="bookresume" class="layer">
        <p style="font-style: italic;">Auteur : Ecrite par <strong>Chris Debien</strong>, l’auteur de <strong>Black Rain</strong>.</p>
        <p>Simon est poursuivi par une bande, la nuit, dans Paris. Après une folle course poursuite, il réussit à semer ses poursuivants et  trouve refuge dans les catacombes. Un sorcier vaudou et un étrange commissaire  vont l’entraîner dans une aventure fantastique.</p>
    </div>
    <div id="btns" class="layer">
        <ul>
<?php if($current_user): ?>
            <li id="continue" section="episode"><a>REPRENDRE</a></li>
<?php else: ?>
            <!--<li id="open_login2"><a>SE CONNECTER</a></li>-->
            <li id="ep1"><a>DÉCOUVRIR GRATUITEMENT</a></li>
<?php endif; ?>
        </ul>
    </div>
    
    <div id="simon" class="layer"></div>
    <div id="bande4" class="layer"></div>
    
    
    
    <div id="episodes_section" class="layer">
        <div id="episodes">
            <div id="expos">
<?php foreach ($admin_13episodes as $admin_13episode): ?>
    <?php if(!isset($current_ep)) $current_ep = $admin_13episode; ?>
                <div class="expo" 
                     data-title="<?php echo stripslashes($admin_13episode->title); ?>"
                     data-episode="<?php echo $admin_13episode->episode; ?>"
                     data-bref="<?php echo stripslashes($admin_13episode->bref); ?>"
                     data-path="<?php echo $admin_13episode->path; ?>">
    <?php echo Asset::img($admin_13episode->image); ?>
                </div>
<?php endforeach; ?>
            </div>
            <div class="ep_title">
                <h2><?php echo '#'.$current_ep->episode.'  '.stripslashes($current_ep->title); ?></h2>
                <div class="ep_play">VOIR L'EPISODE</div>
            </div>
            <div class="ep_list">
                <div id="ep_prev_btn">
<?php echo Asset::img("ui/btn_left.jpg"); ?>
                </div>
                <ul>
<?php foreach ($admin_13episodes as $admin_13episode): ?>
    <?php if($current_ep == $admin_13episode): ?>
                    <li class="active"><?php echo '#'.$admin_13episode->episode; ?></li>
    <?php else: ?>
                    <li><?php echo '#'.$admin_13episode->episode; ?></li>
    <?php endif; ?>
<?php endforeach; ?>
                </ul>
                <div id="ep_next_btn">
<?php echo Asset::img("ui/btn_right.jpg"); ?>
                </div>
            </div>
        </div>
    </div>
    
    
    
    <div id="concept" class="layer">
        <div id="cpt_intro">
            <h1>LE CONCEPT</h1>
            <cite>« Season13, de nouvelles expériences à vivre sur le web. Immerge-toi dans une série et découvre un suspense haletant »</cite>
        </div>
        <div id="cpt_content">
            <div id="cpt1" class="cpt_section">
<?php echo Asset::img("expos/concept1.jpg"); ?>
                <h1>UNE NOUVELLE EXPERIENCE</h1>
                <h5>
                    <p><strong>Immerge-toi dans une série qui défile devant tes yeux</strong>, enrichie de sons, d’images, d’animations qui apparaissent au fur et à mesure.</p>
                    <p>Parfois, tout s’arrête : A toi de trouver la solution et d’agir pour faire redémarrer l’histoire.</p>
                </h5>
                <div class="list_deco"></div>
            </div>
            <div id="cpt2" class="cpt_section">
<?php echo Asset::img("expos/concept2.jpg"); ?>
                <h1>DU SUSPENS</h1>
                <h5>
                    <p><strong>Deux fois par semaine, le mercredi et le samedi</strong>, tu découvres un nouvel épisode de notre première série Voodoo Connection.</p>
                    <p>Season13 t’informe, par mail ou par SMS selon ce que tu as choisi dans le formulaire d’inscription, de la disponibilité d’un nouvel épisode.</p>
                </h5>
                <div class="list_deco"></div>
            </div>
            <div id="cpt3" class="cpt_section">
<?php echo Asset::img("expos/concept3.jpg"); ?>
                <h1>DES JEUX</h1>
                <h5>
                    <p><strong>Chaque épisode de nos séries comprend un jeu vidéo.</strong></p>
                    <p>Tu peux y jouer autant de fois que tu le désires pour obtenir un super score. Si tu l’affiches sur ton mur Facebook, tu pourras participer à un jeu concours entre les 30 meilleurs scores mensuels de ce jeu. Des dizaines de cadeaux à gagner : places de cinéma, sonneries de téléphone…</p>
                </h5>
                <div class="list_deco"></div>
            </div>
            <div id="cpt4" class="cpt_section">
<?php echo Asset::img("expos/concept4.jpg"); ?>
                <h1>TA COMMUNAUTE</h1>
                <h5>
                    <p><strong>Partage cette nouvelle expérience avec tes amis</strong> : envoie tes commentaires avec des extraits de la série sur Facebook.</p>
                    <p>Utilise l’un des personnages comme avatar ou remplace sa tête dans la série par ta photo ou ton propre avatar.</p>
                </h5>
                <div class="list_deco"></div>
            </div>
        </div>
        
        <div id="cpt_banner">
<?php echo Asset::img("cpt_banner.png"); ?>
        </div>
        
        <div id="cpt_multi">
            <h1>MULTI-SUPPORT</h1>
<?php echo Asset::img("cpt_multi.png"); ?>
            <h5>Les histoires de Season13 sont lisibles sur <strong>iPad, iPhone, et tous les appareils disposant d’un navigateur de dernière génération</strong> (Chrome, Firefox 4+, IE 9, Safari, ...)</h5>
        </div>
    </div>
    
</div>