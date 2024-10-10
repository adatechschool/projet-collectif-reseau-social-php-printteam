<?php
require "session.php";
include "connect.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['connected_id'])) {
    echo "Erreur : Vous devez être connecté pour liker un post.";
    exit();
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

    // Redirection vers la page actuelle après l'action
    header('Location:' . $_SERVER["HTTP_REFERER"]);
    exit();

} else {
    echo "Erreur : Aucun post sélectionné pour être liké.";
}
?>



<!-- 'http://localhost/reseau_social/resoc_n3/wall.php?user_id=8' -->