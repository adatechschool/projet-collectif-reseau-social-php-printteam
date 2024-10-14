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
    <a href='admin.php'><img src="img-1.jpg" alt="Logo de notre réseau social"/></a>
    <nav id="menu">
        <a href="news.php">Actualités</a>
        <a href="wall.php?user_id=<?= $user_id?>">Mur</a>
        <a href="feed.php?user_id=<?= $user_id?>">Flux</a>
        <a href="tags.php?tag_id=1">Mots-clés</a>
    </nav>
    <nav id="user">
        <img src="img-3.jpg" alt="" srcset="">
        <a href="#">Profil</a>
        <ul>
            <li><a href="settings.php?user_id=<?= $user_id?>">Paramètres</a></li>
            <li><a href="followers.php?user_id=<?= $user_id?>">Mes suiveurs</a></li>
            <li><a href="subscriptions.php?user_id=<?= $user_id?>">Mes abonnements</a></li>
            <li><a href="logout.php?user_id=<?= $user_id?>">Se déconnecter</a></li>
        </ul>
    </nav>
</header>

<div class="scrolling-message-container">
    <p id="scrolling-message">Le réseau social des Printeurs ! Print ! Print <strong>Elodie</strong> ! Print <strong>Thomas</strong> ! Print <strong>Driss</strong> ! Print <strong>Ruth</strong> ! Print <strong>Nathan</strong> ! Print <strong>Queen Mumu</strong> ! Print <strong>Julien</strong> ! Print <strong>Yennie</strong> ! Print <strong>Stéphane</strong> ! Print <strong>Olivia</strong> ! Print <strong>Solena</strong> ! Print <strong>Fiona</strong> ! </p>
</div>
