<html>

<head>
    <meta charset="utf-8">

    <title>Paiement échoué - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5</title>
</head>

<body>
    <h1>Paiement échoué</h1>
    <h5>Le paiement a été refusé, rafraîchis la page de commande ou recommande si tu veux</h5>
    
    <h5>
        <?php echo $vads_result; ?><br/>
        <?php echo $vads_trans_status; ?><br/>
        <?php echo $vads_auth_result; ?><br/>
        <?php echo $vads_auth_mode; ?><br/>
        <?php echo $vads_trans_id; ?><br/>
        <?php echo $signature; ?><br/>
    </h5>
</body>

</html>