<?php
require "session.php";
$userId = intval($_GET['user_id']);
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Mes abonnements</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <?php
        include("header.php");
        ?>
        <div id="wrapper">
            <aside>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des personnes dont
                        l'utilisatrice
                        n° <?php echo intval($_GET['user_id']) ?>
                        suit les messages
                    </p>
                    <form method="post" action="abo.php?user_id=<?= $userId ?>">
                                <input type="hidden" name="user_id" value="<?= $userId ?>">
                                <button type="submit">follow me</button>
                    </form>
                </section>
            </aside>
            <main class='contacts'>
                <?php
                // Etape 1: récupérer l'id de l'utilisateur
                $userId = intval($_GET['user_id']);
                $monId = $_SESSION['connected_id'];
                // Etape 2: se connecter à la base de donnée
                include "connect.php";
                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "
                    SELECT users.* 
                    FROM followers 
                    LEFT JOIN users ON users.id=followers.followed_user_id 
                    WHERE followers.following_user_id='$userId'
                    GROUP BY users.id
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                // Etape 4: à vous de jouer
                //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 
                include "utilesFonctions.php";

                while ($user = $lesInformations->fetch_assoc())
                {
                        //appel de la fonction GFolowOuPas() du fichier : mesFonctionsQueJeSaisPasQuoiEnFoutre.php
                        //puis générer le bouton adéquat
                ?>
                <article>
                    <img src="user.jpg" alt="blason"/>
                    <form method="post" action="abo.php?user_id=<?= $userId ?>">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <button type="submit">
                                    <?php
                                    if (isFollowing($monId,$user['id'])==false){
                                        echo "Follow";
                                    } else {
                                        echo "Unfollow";
                                    }   
                                    ?>
                                    </button>
                            </form>
                    <h3><?php echo $user["alias"] ; ?></h3>
                    <p>id:<?php echo $user["id"] ; ?></p>                    
                </article>
                <?php } ; ?>
            </main>
        </div>
    </body>
</html>
