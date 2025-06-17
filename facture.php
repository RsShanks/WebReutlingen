<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header2.css">
    <link rel="stylesheet" href="css/facture.css">
    <title>Votre Facture</title>
    <script src="https://kit.fontawesome.com/82e270d318.js" crossorigin="anonymous"></script>
</head>

<body>

        <?php include('php/header2.php') ?>
        <div class="facture">
            <h2>Votre facture</h2>
            <table>
                <tr>
                    <th>Produit</th>
                    <th>Nom</th>
                    <th>Quantité</th>
                    <th>Référence</th>
                    <th>Prix HT</th>
                    <th>Prix TTC</th>
                    <th>TOTAL</th>
                </tr>

                <?php

                $recup_commande = $bdd->prepare("SELECT img,code,quantite,nom,prix,reference from produit inner join commande on produit.code=commande.code_produit where id_user='{$_SESSION['id_user']}' and payer = 1;");
                $recup_commande->execute();
                $commande = $recup_commande->fetchAll(PDO::FETCH_ASSOC);
                if($recup_commande->rowCount()>0){
                    for($i=0;$i<$recup_commande->rowCount();$i++){

                    echo '<tr class="produit">';
                    echo '<td><img src="' . $commande[$i]['img'] . '" width="200" height="200"></img></td>';
                    echo '<td>' . $commande[$i]['nom'] . '</td>';
                    echo
                    '<td>
                                        <div class="quantite">
                                            <input type="text" size="5" id="text_' . $commande[$i]["code"] . '" readonly="readonly" class="input_btn" value="' . $commande[$i]["quantite"] . '"/>
                                        </div>
                                    </td>';
                    echo '<td>' . $commande[$i]["code"] . '</td>';
                    echo '<td>' . $commande[$i]["prix"] * (1 - 20 / 100) . ' €</td>';
                    echo '<td>' . (string) $commande[$i]['prix'] . ' €</td>';
                    echo '<td class="totalprix"><b>' . $commande[$i]["prix"] * $commande[$i]['quantite'] . ' €<b/></td>';
                    echo '</tr>';
                    $prixtotHT += $commande[$i]["prix"] * $commande[$i]['quantite'] * (1 - 20 / 100);
                    $prixtot += $commande[$i]["prix"] * $commande[$i]['quantite'];
                    }
                    echo '<tr>
                        <td colspan = 6></td>';
                    echo '<td class="total">';

                    echo $prixtotHT . ' € HT</td></tr> <hr>';

                    echo '<tr><td colspan=6></td>';
                    echo '<td class="total"><b>';
  
                    echo $prixtot . ' € TTC</b></td></tr>';
                    echo '</table>';
                ?>
                <div class="validation">
                    <button id="annuler">Annuler</button>
                    <button id="envoyer">Envoyer</button>
                </div>
                <div class="message_info"></div>
        </div>
        </div>

        <?php include('php/footer.php') ?>

    <?php
    } else {
        echo '<h2> Panier vide veuillez quitter cette page</h2>';
    }
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/facture.js"></script>
</body>

</html>