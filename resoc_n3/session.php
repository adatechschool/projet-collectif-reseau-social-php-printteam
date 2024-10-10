<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} // Démarrer la session
if (!isset($_SESSION['connected_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header('Location: login.php');
    exit();
}
?>