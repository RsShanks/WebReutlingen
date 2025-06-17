<?php
session_start();
//fait
$nom=htmlentities($_POST['nom']);
$prenom=htmlentities($_POST['prenom']);
$mail=htmlentities($_POST['mail']);
$password=htmlentities($_POST['mot_de_passe']);
$sexe=htmlentities($_POST['sexe']);
$naissance=htmlentities($_POST['naissance']);
$adresse=htmlentities($_POST['adresse']);
$metier=htmlentities($_POST['metier']);
//encoder le mdp
$mdp=MD5($password);

$servname="localhost";
$key_cryptage='la securite avant tout';//clé de cryptage
$pass=openssl_decrypt(base64_decode("QUpZdVg3QVh2NU5Va29ZdnhEeDNPQT09"),"AES-128-ECB",$key_cryptage);
$user=openssl_decrypt("5UfEC4F+32Kr6EtKpwtz8A==","AES-128-ECB",$key_cryptage);

$bdd= new PDO("mysql:host=$servname;dbname=boulangerie",$user,$pass); //connexion base de données
$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
try{
    $recup_user = $bdd->prepare("SELECT * from  user WHERE mail = '{$mail}' ;");
    $recup_user->execute();
    if( $recup_user->rowCount() > 0){
        $response='Cette adresse mail est déjà utilisée ';
    }
    else if (empty($prenom) || !preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ ]+$/', $prenom) || !preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ ]+$/', $nom) ) {
        $response = 'Le prénom, le nom et l adresse, ne doivent contenir que des caractères normaux sans caractères spéciaux.';

    }   
    else{
        $new = $bdd->prepare("INSERT INTO user (prenom, nom, mail, mot_de_passe, sexe, date_naissance, adresse, metier) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        // Liez les valeurs aux paramètres de la requête
        $new->bindParam(1, $prenom);
        $new->bindParam(2, $nom);
        $new->bindParam(3, $mail);
        $new->bindParam(4, $mdp);
        $new->bindParam(5, $sexe);
        $new->bindParam(6, $naissance);
        $new->bindParam(7, $adresse);
        $new->bindParam(8, $metier);
        
        // Exécutez la requête préparée
        $new->execute();

        $_SESSION['connecte']=1;
        $_SESSION['nom']= $nom.' '.$prenom;
        $_SESSION['utilisateur']=$mail;

        $recup_user = $bdd->prepare("SELECT max(id) as id from  user;");
        $recup_user->execute();
        $users=$recup_user->fetch(PDO::FETCH_ASSOC);

        $_SESSION['id_user']=$users['id'];

        $response="ok";
    }
}
catch(PDOException $e){
    $response="ERREUR : ". $e->getMessage();
}
echo json_encode(['response' => $response]);
?>
