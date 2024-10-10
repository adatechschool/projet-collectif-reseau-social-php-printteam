<?php
//Le nom de ce fichier est vachement bien !
require "session.php";

function isFollowing($following, $followed){ 
    include "connect.php";

    $request = "SELECT * FROM followers WHERE following_user_id = $following AND followed_user_id = $followed";
    $infoRequest = $mysqli->query($request);
    
    if ($infoRequest->num_rows<1) {
        return false;
        //le bouton doit etre follow
    } else {
        return true;
        //le bouton doit etre unfollow
    }
}

function checkLike (){
    include "connect.php";

    $checkLikeQuery = "SELECT * FROM likes WHERE user_id = $userId AND post_id = $postId";
    $infosLikes = $mysqli->query($checkLikeQuery);

    if ($infosLikes->num_rows < 1){

    } else {
        
    }
}

?>