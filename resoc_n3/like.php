<?php 
session_start();
include "connect.php";

//<bouton> id name
//$id du post qu'on doit récupérer dans la requel sql
//$lesInformations --> l'id du post

var_dump($_SESSION['connected_id']);

if(isset($_POST['post_id']) && isset($_SESSION["connected_id"])){
    $connectionId= $_SESSION["connected_id"]; //id de moi connecté
    $prout = $_POST['post_id'];
    echo $connectionId;

    // Vérifier si j'ai déjà à déjà aimé ce post
    //requete SQL pour vérifier si la ligne existe dans la BDD
    $checkLikeQuery ="SELECT * FROM likes WHERE user_id = $connectionId AND post_id=$prout";
    $infosLikes=$mysqli->query($checkLikeQuery);
    $result = $infosLikes->fetch_assoc();

    //var_dump($result);
    if ($infosLikes -> num_rows < 1){
        $result = $mysqli -> query("INSERT INTO likes (id, user_id, post_id) VALUES (NULL, $connectionId, $prout)");
        header('Location: wall.php?user_id=' . $connectionId);
        
//si $result->num_rows est <1 alors on like
//else $result->num_rows >0 alors on unlike
    } else {
        $result = $mysqli -> query("DELETE FROM likes WHERE user_id = $connectionId AND post_id=$prout");
        header('Location: wall.php?user_id=' . $connectionId);
        
    }

}else{
    echo "pwet";
}
 ; ?>