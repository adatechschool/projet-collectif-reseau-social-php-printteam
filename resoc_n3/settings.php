<?php
require "session.php";
$userId = intval($_GET['user_id']);
$monId = $_SESSION['connected_id'];
include "utilesFonctions.php";
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Paramètres</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <?php
        include("header.php");
        ?>
        <div id="wrapper" class='profile'>


            <aside>
                <img src="img-2.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez les informations de l'utilisatrice
                        n° <?php echo intval($_GET['user_id']) ?></p>
                        <form method="post" action="abo.php?user_id=<?= $userId ?>">
                                <input type="hidden" name="user_id" value="<?= $userId ?>">
                                <button type="submit" class="button-1"><?php  
                                    echo isFollowing($monId,$userId) ?"Unfollow":"Follow";
                                    ?></button>
                    </form>

                </section>
            </aside>
            <main>
                <?php
                /**
                 * Etape 1: Les paramètres concernent une utilisatrice en particulier
                 * La première étape est donc de trouver quel est l'id de l'utilisatrice
                 * Celui ci est indiqué en parametre GET de la page sous la forme user_id=...
                 * Documentation : https://www.php.net/manual/fr/reserved.variables.get.php
                 * ... mais en résumé c'est une manière de passer des informations à la page en ajoutant des choses dans l'url
                 */
                $userId = intval($_GET['user_id']);

                /**
                 * Etape 2: se connecter à la base de donnée
                 */
                include "connect.php";

                /**
                 * Etape 3: récupérer le nom de l'utilisateur
                 */
                $laQuestionEnSql = "
                    SELECT users.*, 
                    count(DISTINCT posts.id) as totalpost, 
                    count(DISTINCT given.post_id) as totalgiven, 
                    count(DISTINCT recieved.user_id) as totalrecieved 
                    FROM users 
                    LEFT JOIN posts ON posts.user_id=users.id 
                    LEFT JOIN likes as given ON given.user_id=users.id 
                    LEFT JOIN likes as recieved ON recieved.post_id=posts.id 
                    WHERE users.id = '$userId' 
                    GROUP BY users.id
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }
                $user = $lesInformations->fetch_assoc();

                /**
                 * Etape 4: à vous de jouer
                 */
                //@todo: afficher le résultat de la ligne ci dessous, remplacer les valeurs ci-après puis effacer la ligne ci-dessous
                // echo "<pre>" . print_r($user, 1) . "</pre>";
                ?>                
                <article class='parameters'>
                    <h3>Mes paramètres</h3>
                    <dl>
                        <dt>Pseudo</dt>
                        <dd><?=$user["alias"]?></dd>
                        <dt>Email</dt>
                        <dd><?=$user["email"]?></dd>
                        <dt>Nombre de message</dt>
                        <dd><?=$user["totalpost"]?></dd>
                        <dt>Nombre de "J'aime" donnés </dt>
                        <dd><?=$user["totalgiven"]?></dd>
                        <dt>Nombre de "J'aime" reçus</dt>
                        <dd><?=$user["totalrecieved"]?></dd>
                    </dl>

                </article>
            </main>
        </div>
    </body>
</html>
