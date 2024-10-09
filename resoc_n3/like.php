<?php 
include "connect.php";



if(isset($_POST["post_id"]) && isset($_SESSION["connected_id"])){
    $userId= $_SESSION["connect_id"];
   

    // Vérifier si l'utilisateur à déjà aimé ce post
    $checkLikeQuery ="SELECT * FROM likes WHERE user_id = $userId AND post_id=$postId";
    $result=$mysqli->query($$checkLikeQuery);




}else{
    echo "pwet";
}
 ; ?>