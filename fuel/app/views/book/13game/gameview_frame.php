<html>
<head>
    <title>Single Game</title>        
    <link href='http://fonts.googleapis.com/css?family=Gudea:400,700,400italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    <?php 
        echo Asset::css('dialog_auth_msg.css');
        echo Asset::css('story.css');
        echo Asset::css('BebasNeue.css');
     ?>

    <script type="text/javascript">
        if(typeof jQuery == 'undefined') 
            document.write('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" />');
    </script>

    <?php 

        echo Asset::js('lib/fbapi.js');    
        echo Asset::js('lib/jquery.form.js');    
        echo Asset::js('lib/BrowserDetect.js');
        echo Asset::js('lib/Tools.js');
        echo Asset::js('lib/Interaction.js');
        echo Asset::js('config.js');
        // echo Asset::js('story/gui.js');    




        if(Fuel::$env == Fuel::DEVELOPMENT) {
            // echo Asset::js('story/scriber.js');
            echo Asset::js('story/events.js');
            echo Asset::js('story/mse.js');
            echo Asset::js('story/effet_mini.js');
            echo Asset::js('story/mdj.js');
        }
        else {
            echo Asset::js('story/scriber.js');
            echo Asset::js('story/events.min.js');
            echo Asset::js('story/mse.min.js');
            echo Asset::js('story/effet_mini.js');
            echo Asset::js('story/mdj.min.js');
        }

    ?>
    <script src="<?php echo Uri::base(false)."$path/games/$fileName"; ?>"></script>

    <style type="text/css">
        img#close_game_icon {
            position: absolute;
            top: -60px;
            right: -30px;
            cursor: pointer;
        }
    </style>

</head>
<body>
    <div id="game_container" class="dialog">
        <h1></h1>
        <div class="sep_line"></div>
        <?php echo Asset::img('season13/ui/btn_close.png', array('id'=> 'close_game_icon')) ?>        
        <canvas id="gameCanvas" class='game' width=50 height=50></canvas>
        
        <div id="game_center">
            <div id="game_result">
                <?php echo Asset::img('season13/fb_btn.jpg', array('alt' => 'Partager ton score sur Facebook')); ?>
                <h2>GAGNÉ !</h2>
                <h5>Ton score : <span>240</span> pts</h5>
                <ul>
                    <li id="game_restart">REJOUER</li>
                    <li id="game_quit">QUITTER</li>
                </ul>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function(){
            $('#game_quit, #close_game_icon').click(window.parent.gameNotifier.quit);
        });

        window.initMseConfig();
        mse.init();
        mse.currTimeline.start();
        $('.bookroot').hide();
        mse.configs.srcPath='<?php echo Uri::base(false) . "$path/" ?>';
        var game = new <?php echo $className ?>();
        game.config.indep = true;
        game.start();
    </script>
</body>
</html>



