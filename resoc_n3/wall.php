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
        <title>ReSoC - Mur</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <?php include("header.php"); ?>
        
        <div id="wrapper">
            <?php
            // Récupérer l'id de l'utilisateur via le paramètre GET
            $userId = intval($_GET['user_id']);
            
            // Connexion à la base de données
            include "connect.php";

            // Récupérer les informations de l'utilisateur
            $laQuestionEnSql = "SELECT * FROM users WHERE id='$userId'";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $user = $lesInformations->fetch_assoc();
            ?>
            
            <aside>
                <img src="img-2.jpg" alt="Portrait de l'utilisateur"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les messages de l'utilisateur : <?= $user['alias'] ?></p>
                    <form method="post" action="abo.php?user_id=<?= $userId ?>">
                        <input type="hidden" name="user_id" value="<?= $userId ?>">
                        <button type="submit" class="button-1"><?php  
                                    echo isFollowing($monId,$userId) ?"Unfollow":"Follow";
                                    ?></button>
                    </form>
                </section>
            </aside>
            
            <main>
                <form action="wall.php" method="post" class="fenetre">
                    <dl>
                        <dt><label for='message'>Message</label></dt>
                        <dd><textarea name='message'></textarea></dd>
                    </dl>
                    <input type='submit' value="Envoyer" class="button-1">

                </form> 
                
                <?php
                // Récupérer tous les messages de l'utilisateur
                $laQuestionEnSql = "
                    SELECT posts.content, 
                    posts.created, posts.id, 
                    users.alias as author_name, 
                    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist
                    FROM posts
                    JOIN users ON users.id = posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id
                    LEFT JOIN tags ON posts_tags.tag_id = tags.id
                    LEFT JOIN likes ON likes.post_id = posts.id
                    WHERE posts.user_id = '$userId'
                    GROUP BY posts.id
                    ORDER BY posts.created DESC";
                    
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if (!$lesInformations) {
                    echo("Échec de la requête : " . $mysqli->error);
                }
                
                // Parcourir les messages et afficher
                while ($post = $lesInformations->fetch_assoc()) { 
                    ?>
                    <article>
                        <h3>
                            <time datetime="<?= $post['created'] ?>"><?= $post['created'] ?></time>
                        </h3>
                        <address><?= $post['author_name'] ?></address>
                        <div>
                            <p><?= $post['content'] ?></p>
                        </div>
                        <footer>
                            <!-- &action=ajoutelike" -->
                            <form method="post" action="like.php?user_id=<?= $userId ?>"> 
                                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                <button type="submit" class="button-1">♥ <?= $post['like_number'] ?></button>
                            </form>
                            <a href="" class="tags">#<?= $post['taglist'] ?></a>
                        </footer>
                    </article>
                <?php } ?>
                
                <?php
                // Gestion de l'envoi d'un message
                if (isset($_POST['message'])) {
                    $postContent = $mysqli->real_escape_string($_POST['message']);
                    
                    // Construction et exécution de la requête d'insertion
                    $lInstructionSql = "
                        INSERT INTO posts (id, user_id, content, created, parent_id)
                        VALUES (NULL, {$_SESSION['connected_id']}, '$postContent', NOW(), NULL)";
                    
                    if (!$mysqli->query($lInstructionSql)) {
                        echo "Impossible d'ajouter le message: " . $mysqli->error;
                    } else {
                        echo "Message posté.";
                        header('Location: wall.php?user_id=' . $_SESSION['connected_id']);
                        exit();
                    }
                }
                ?>
            </main>
        </div>
    </body>
</html>
