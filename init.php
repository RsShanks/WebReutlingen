<?php 
       
       $servname="localhost";      
        $key_cryptage='la securite avant tout';//clé de cryptage
        $pass=openssl_decrypt(base64_decode("QUpZdVg3QVh2NU5Va29ZdnhEeDNPQT09"),"AES-128-ECB",$key_cryptage);
        $user=openssl_decrypt("5UfEC4F+32Kr6EtKpwtz8A==","AES-128-ECB",$key_cryptage);
       try {
    // Connexion sans DB pour créer la base
    $bdd = new PDO("mysql:host=$servname;charset=utf8", $user, $pass);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd = new PDO("mysql:host=$servname;dbname=boulangerie;charset=utf8", $user, $pass);
    $bdd->exec("CREATE DATABASE IF NOT EXISTS boulangerie");
    
    // Connexion avec DB

    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Création table
    $sql = "CREATE TABLE IF NOT EXISTS categorie (
        cate TEXT NOT NULL,
        link TEXT NOT NULL,
        reference INT PRIMARY KEY,
        icone TEXT NOT NULL,
        citation TEXT NOT NULL
    )";
    $bdd->exec($sql);

           $new_table=" CREATE TABLE user(
               id INT AUTO_INCREMENT PRIMARY KEY,
               prenom VARCHAR(30) NOT NULL,
               nom VARCHAR(30) NOT NULL,
               mail VARCHAR(50) NOT NULL UNIQUE,
               mot_de_passe TEXT NOT NULL,
               sexe VARCHAR(20),
               date_naissance DATE NOT NULL,
               adresse TEXT NOT NULL,
               metier TEXT NOT NULL,
               resolution_ecran VARCHAR(20),
               derniere_connexion DATETIME
               );";

           $bdd->exec($new_table);

           $new_table = "CREATE TABLE produit (
            nom VARCHAR(50) NOT NULL PRIMARY KEY,
            code VARCHAR(2) NOT NULL UNIQUE,
            reference INT NOT NULL,
            presentation TEXT NOT NULL,
            img VARCHAR(100) NOT NULL,
            stock INT NOT NULL,
            prix DECIMAL(10,2) NOT NULL,
            ingredients TEXT NOT NULL,
            categorie_id INT,
            FOREIGN KEY (categorie_id) REFERENCES categorie(reference)
        )";
        $bdd->exec($new_table);
        /*$new_table = "ALTER TABLE produit ADD INDEX idx_code (code);";
        $bdd->exec($new_table);*/
        
        $new_table = "CREATE TABLE commande (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            quantite INT NOT NULL,
            payer INT NOT NULL,
            code_produit VARCHAR(2) NOT NULL,
            id_user INT NOT NULL,
            FOREIGN KEY (code_produit) REFERENCES produit(code),
            FOREIGN KEY (id_user) REFERENCES user(id)
        )";

        $bdd->exec($new_table);

            $link1="\'fa fa-wheat-awn\'";
            $link2="\'fa fa-cookie-bite\'";
            $link3="\'fa fa-bread-slice\'";
            $data_cate = "INSERT INTO categorie (reference,cate,link,citation,icone) VALUES 
            (1, 'Patisserie','categorie.php?produit=1','La pâtisserie et l amour c est pareil - une question de fraîcheur <br> et que tous les ingrédients, même les plus amers, tournent au délice','<i class={$link1}></i>'),
            (2, 'Viennoiserie','categorie.php?produit=2','De nuit en nuit, le croissant de la lune prend de la brioche.','<i class={$link2}></i>'),
            (3, 'Sandwich','categorie.php?produit=3','Certains dîners gratuits sont tellement ennuyeux que un sandwich payant est,<br> de loin, préférable.','<i class={$link3}></i>');";
            $bdd->exec($data_cate);

            $data_pro = "INSERT INTO produit ( nom, reference, presentation, code, img, stock, prix, ingredients, categorie_id) VALUES 
            -- Patisserie
            ( 'Charlotte au fraises', 1, 'Gâteau composé de boudoir entourant un douce crème composé d''une mascarpone sucré melangé à la confiture de fraise.', 'P1', 'img/charlotte400-min.png', 22, 27.90, 'Boudoir, Fraises, Crème liquide, Mascarpone, Sucre glace, Confiture de fraise', 1),
            ( 'Tarte aux pommes', 2, 'Recette traditionnelle de tarte aux pommes, faite maison avec des pommes issues de l''agriculture biologique', 'P2', 'img/tartePommes400-min.jpg', 125, 18.80, 'Pâte feuilletée, Pomme, Oeufs, Sucre, Crème liquide, Cannelle, Sucre vanillé', 1),
            ( 'Profiteroles', 3, 'Une recette de profiteroles maison, des choux croquant et fondant qui feront ravir vos papilles.', 'P3', 'img/Profiteroles400-min.jpg', 119, 2.80, 'Lait, Eau, Sel, Sucre, Oeufs, Farine, Beurre, Sucre, Chocolat', 1),
            ( 'Milles feuilles', 4, 'Le mille feuilles, un classique de la patisserie qui fait toujours son effet avec sa crème vanillé et sa beauté.', 'P4', 'img/mille400-min.jpg', 95, 11.90, 'Farine, Sel, Eau, Beurre, Oeufs, Lait, Sucre', 1),
            ( 'Eclair', 5, 'Un classique dont on ne se lasse pas. Cette pâte à chou faites par nos soins va vous faire plaisir !', 'P5', 'img/Eclair400-min.jpg', 83, 2.00, 'Eau, Lait, Sel, Sucre, Beurre, Farine, Oeufs, Fécule de maïs, Cacao, Chocolat, Crème liquide', 1),
            -- Viennoiserie
            ( 'Pain au chocolat', 6, 'Pain au chocolat feuilleté avec un chocolat d''exception fait par nos meilleurs artisans.', 'V1', 'img/painchoco400-min.png', 87, 1.10, 'Beurre, Levure fraîche, Eau, Farine, Sucre, Sel, Chocolat', 2),
            ( 'Pain au raisin', 7, 'L''alliance d''une magnifique et croquante pâte brisée, de crème et de raisins parfaitement choisi.', 'V2', 'img/raisin400-min.png', 11, 1.30, 'Beurre, Levure, Eau, Sucre, Sel, Farine, Oeufs, Lait', 2),
            ( 'Pain Suisse', 8, 'Cette création suisse reprise par nos ateliers français vous feront frémir.', 'V3', 'img/suisse400-min.jpg', 148, 1.70, 'Farine, Sel, Sucre, Levure, Oeufs, Beurre, Crème pâtissière, Pépites de chocolat', 2),
            ( 'Croissant', 9, 'Le classique de la viennoiserie française fait par nos artisans.', 'V4', 'img/croissant400-min.jpg', 147, 1.05, 'Beurre, Levure fraîche, Eau, Farine, Sucre, Sel, Chocolat', 2),
            ( 'Chausson aux pommes', 10, 'Croustillant avec une compotée de pomme, parfait à déguster.', 'V5', 'img/chausson400-min.png', 98, 1.20, 'Pomme, Beurre, Oeufs, Canelle, Sucre, Pâte feuilletée', 2),
            -- Sandwich
            ( 'Sandwich de la mer', 11, 'Sandwich au thon frais accompagné de crudité et d''une mayonnaise maison.', 'S1', 'img/SandThon400-min.png', 85, 4.70, 'Pain, Salade, Tomate, Mayonnaise, Oeuf', 3),
            ( 'Sandwich Parisien', 12, 'Le sandwich le plus mangé des français amélioré par notre chef.', 'S2', 'img/SandJamb400-min.png', 90, 4.00, 'Pain, Jambon, Beurre, Fromage', 3),
            ( 'Sandwich au Bacon', 13, 'Notre sandwich plein de saveurs et unique qui va savoir vous séduire.', 'S3', 'img/sandwichBacon400-min.jpeg', 106, 4.50, 'Pain, Bacon, Fromage, Tomates, Salade', 3),
            ( 'Sandwich au Poulet', 14, 'Sandwich de poulet accompagné de crudité et d''une mayonnaise maison.', 'S4', 'img/SandPoulet400-min.jpg', 96, 5.20, 'Pain, Poulet, Mayonnaise, Salade, Tomate', 3),
            ( 'Sandwich végétarien', 15, 'Une alternative végétarienne pour le midi pour les amoureux du végétale.', 'S5', 'img/BagelVege400-min.jpeg', 92, 4.90, 'Fromage, Mozzarella, Feta, Epinard, Tomates, Oignon', 3);
            ";
            $bdd->exec($data_pro);
            $prenom="JOHN";
            $nom="DO";
            $mail="admin@95.fr";
            $mdp=MD5("motdepasse123");
            $sexe="Homme";
            $naissance="2000-04-04";
            $adresse="rue veaugirad";
            $metier="admin";
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
            header('Location: http://localhost:8080/index.php');
            exit();
        }
        catch(PDOException $e){
            echo "ERREUR : ". $e->getMessage();
        }
?>