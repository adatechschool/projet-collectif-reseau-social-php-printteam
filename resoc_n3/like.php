<?php 
include "connect.php";

//<bouton> id name
//$id du post qu'on doit récupérer dans la requel sql
//$lesInformations --> l'id du post
$prout = $post['id'];


if(isset($post['id']) && isset($_SESSION["connected_id"])){
    $connectionId= $_SESSION["connected_id"]; //id de moi connecté
    echo $connectionId;

    // Vérifier si j'ai déjà à déjà aimé ce post
    //requete SQL pour vérifier si la ligne existe dans la BDD
    $checkLikeQuery ="SELECT * FROM likes WHERE user_id = $connectionId AND post_id=$prout";
    $infosLikes=$mysqli->query($checkLikeQuery);
    $result = $infosLikes->fetch_assoc();

echo "<pre>" . print_r($result, 1) . "</pre>";

    //var_dump($result);
//si $result->num_rows est <1 alors on like
//else $result->num_rows >0 alors on unlike

}else{
    echo "pwet";
}
 ; ?>