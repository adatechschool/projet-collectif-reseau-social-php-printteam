<?php
require "session.php";
include "utilesFonctions.php";
include "connect.php";

// Fonction pour extraire l'ID de la vidéo
function extractVideoId($url) {
    parse_str(parse_url($url, PHP_URL_QUERY), $vars);
    return $vars['v'] ?? ''; // Retourne l'ID ou une chaîne vide
}

// Gestion de l'envoi d'un message
if (isset($_POST['message'])) {
    $postContent = $mysqli->real_escape_string($_POST['message']);
    $videoUrl = isset($_POST['video_url']) ? $mysqli->real_escape_string($_POST['video_url']) : null;

    // Construction et exécution de la requête d'insertion
    $lInstructionSql = "
        INSERT INTO posts (id, user_id, content, created, parent_id, video_url)
        VALUES (NULL, {$_SESSION['connected_id']}, '$postContent', NOW(), NULL, '$videoUrl')";
    
    if (!$mysqli->query($lInstructionSql)) {
        echo "Impossible d'ajouter le message: " . $mysqli->error;
    } else {
        // Redirection après l'envoi du message
        header('Location: wall.php?user_id=' . $_SESSION['connected_id']);
        exit(); // Toujours utiliser exit après une redirection
    }
}

// Récupérer l'id de l'utilisateur via le paramètre GET
$userId = intval($_GET['user_id']);
$monId = $_SESSION['connected_id'];
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
        // Récupérer les informations de l'utilisateur
        $laQuestionEnSql = "SELECT * FROM users WHERE id='$userId'";
        $lesInformations = $mysqli->query($laQuestionEnSql);
        $user = $lesInformations->fetch_assoc();
        ?>

        <aside>
            <img src=<?= showProfilPicture($user['picture']) ; ?> alt="blason"/>
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
        
        <!-- <aside>
            <img src="img-2.jpg" alt="Portrait de l'utilisateur"/>
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez tous les messages de l'utilisateur : <?= $user['alias'] ?></p>
                <form method="post" action="abo.php?user_id=<?= $userId ?>">
                    <input type="hidden" name="user_id" value="<?= $userId ?>">
                    <button type="submit" class="button-1"><?php  
                                echo isFollowing($monId,$userId) ? "Unfollow" : "Follow";
                                ?></button>
                </form>
            </section>
        </aside> -->
        
        <main>
            <form action="wall.php" method="post" class="fenetre">
                <dl>
                    <dt><label for='message'>Message</label></dt>
                    <dd><textarea required name='message'></textarea></dd>
                    <dt><label for='video_url'>URL de la vidéo youtube</label></dt>
                    <dd><input type='url' name='video_url' placeholder='https://www.youtube.com/watch?v=VIDEO_ID'></dd>
                </dl>
                <input type='submit' value="Envoyer" class="button-1">
            </form> 
            
            <?php
            // Récupérer tous les messages de l'utilisateur
            $laQuestionEnSql = "
                SELECT posts.content, 
                posts.created, posts.id, 
                users.alias as author_name, 
                posts.video_url,
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
                    <div class="post-content">
                        <p class="message-text"><?= $post['content'] ?></p> <!-- Classe pour le message -->
                        <?php if (!empty($post['video_url'])): ?>
                            <iframe class="post-video" width="560" height="315" src="https://www.youtube.com/embed/<?= extractVideoId($post['video_url']); ?>" frameborder="0" allowfullscreen></iframe> <!-- Classe pour la vidéo -->
                        <?php endif; ?>
                    </div>
                    <footer>
                        <form method="post" action="like.php?user_id=<?= $userId ?>"> 
                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                            <button type="submit" class="button-1">♥ <?= $post['like_number'] ?></button>
                        </form>
                        <a href="" class="tags">#<?= $post['taglist'] ?></a>
                    </footer>
                </article>

            <?php } ?>
        </main>
    </div>
</body>
</html>
