<?php
require "session.php";
include "connect.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['connected_id'])) {
    echo "Erreur : Vous devez être connecté pour liker un post.";
    exit();
}

// Vérifier si un post_id est fourni
if (isset($_POST['user_id'])) {
    $connectionId = $_SESSION["connected_id"]; // id de l'utilisateur connecté
    $postId = intval($_POST['user_id']); // id du post

    // Vérifier si j'ai déjà liké ce post
    $checkFollowQuery = "SELECT * FROM followers WHERE following_user_id = $connectionId AND followed_user_id = $postId";
    $infosFollow = $mysqli->query($checkFollowQuery);

    if ($infosFollow->num_rows < 1) {
        
        // Si pas encore liké, ajouter un like
        $mysqli->query("INSERT INTO followers (id, followed_user_id, following_user_id) VALUES (NULL, $postId, $connectionId)");
    } else {
        // Sinon, retirer le like
        $mysqli->query("DELETE FROM followers WHERE following_user_id = $connectionId AND followed_user_id = $postId");
    }

    // Redirection vers la page actuelle après l'action
    header('Location:' . $_SERVER["HTTP_REFERER"]);
    exit();

} else {
    echo "Erreur : Aucun post sélectionné pour être liké.";
}
?>
