<?php
require "session.php";
include "connect.php";
var_dump($_SERVER);

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['connected_id'])) {
    echo "Erreur : Vous devez être connecté pour liker un post.";
    exit();
}

if (isset($_POST['page']) == 'wall') {
    $redirection = "wall.php?user_id=" . $_GET['user_id'];
} elseif (isset($_POST['page'])== 'news') {
    $redirection = "news.php";
}
// Vérifier si un post_id est fourni
if (isset($_POST['post_id'])) {
    $connectionId = $_SESSION["connected_id"]; // id de l'utilisateur connecté
    $postId = intval($_POST['post_id']); // id du post

    // Vérifier si j'ai déjà liké ce post
    $checkLikeQuery = "SELECT * FROM likes WHERE user_id = $connectionId AND post_id = $postId";
    $infosLikes = $mysqli->query($checkLikeQuery);

    if ($infosLikes->num_rows < 1) {
        
        // Si pas encore liké, ajouter un like
        $mysqli->query("INSERT INTO likes (id, user_id, post_id) VALUES (NULL, $connectionId, $postId)");
    } else {
        // Sinon, retirer le like
        $mysqli->query("DELETE FROM likes WHERE user_id = $connectionId AND post_id = $postId");
    }

    // Redirection vers le mur actuel après l'action
    header('Location:' . $redirection);
    exit();

} else {
    echo "Erreur : Aucun post sélectionné pour être liké.";
}
?>



<!-- 'http://localhost/reseau_social/resoc_n3/wall.php?user_id=8' -->