<?php
//fait
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/plan_du_site.css">
    <script src="https://kit.fontawesome.com/82e270d318.js" crossorigin="anonymous"></script>
    <title>Breaking Bread : Viennoiserie, Pâtisserie</title>
</head>

<body>
    <?php
    include('php/header.php');
    ?>
    <div class="contenu">
        <h1><i>Plan du site</i></h1>
        <h2>Pages</h2>
        <hr>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="contact.php">Contactez-nous</a></li>
            <li><a href="connexion.php">Connexion/Inscription</a></li>
            <li><a href="mentionslegales.php">Mention légales</a></li>
            <li><a href="panier.php">Panier</a></li>
            <li><a href="plan_du_site.php">Plan du site</a></li>
            <li>Produit
                <ul>
                    <?php

                    for( $i=0;$i<$recup_categorie->rowCount();$i++){
                        if($categorie[$i]['link'] != '' && $categorie[$i]['cate']!= ''){
                            echo '<li><a href="' . $categorie[$i]['link'] . '">' . $categorie[$i]['cate'] . '</a></li>';
                        }
                        else {
                            echo 'problème avec la base sql veuillez réssayer';
                            header('Location: http://localhost:8080/index.php');
                            exit();
                        }
                    }
                    ?>
                </ul>
            </li>
        </ul>
    </div>
    </div>
    <?php
    include('php/footer.php');
    ?>
</body>

</html>