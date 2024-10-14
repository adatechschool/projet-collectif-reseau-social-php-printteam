<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["connected_id"])) {
$user_id=$_SESSION["connected_id"];
} else {
 $user_id=5;
}
?>

<header>
            <a href='admin.php'><img src="resoc.jpg" alt="Logo de notre réseau social"/></a>
            <nav id="menu">
                <a href="news.php">Actualités</a>
                <a href="wall.php?user_id=<?= $user_id?>">Mur</a>
                <a href="feed.php?user_id=<?= $user_id?>">Flux</a>
                <a href="tags.php?tag_id=1">Mots-clés</a>
            </nav>
            <nav id="user">
                <a href="#">Profil</a>
                <ul>
                    <li><a href="settings.php?user_id=<?= $user_id?>">Paramètres</a></li>
                    <li><a href="followers.php?user_id=<?= $user_id?>">Mes suiveurs</a></li>
                    <li><a href="subscriptions.php?user_id=<?= $user_id?>">Mes abonnements</a></li>
                    <li><a href="logout.php?user_id=<?= $user_id?>">Se deconnecter</a></li>
                </ul>

            </nav>
</header>