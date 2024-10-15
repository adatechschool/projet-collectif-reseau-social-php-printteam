# projet-collectif-reseau-social-php-printteam

## Track Jour 1 : 07 Octobre 2024

## Niveau 1 :

### Introduction au PHP :
Installation & démarrage des serveurs WAMP et MAMP
### Connexion à la base de données SQL : 
$mysqli = new mysqli("localhost", "root", "", "socialnetwork");
### Préparation de la requête SQL
$laQuestionEnSql = "SELECT * FROM `tags` LIMIT 50";
### Envoi de la requête SQL :
$lesInformations = $mysqli->query($laQuestionEnSql);
### Boucler pour creeer autant d'élément HTML que d'entrée dans la BDD
```
while ($tag = $lesInformations->fetch_assoc()){
   <h3><?php echo $tag['alias'] ?></h3>
}
```
## Définition des configurations pour nos machines : 
.editorconfig : configurations par défaut
.gitignore : ajout de connect.php pour nos requêtes d'authentifications à notre phpmyadmin qui sont différentes selons nos machines au sein du groupe

## Track Jour 2 : 08 Octobre 2024

- Ajout d'une approche "variable d'environnement" pour la connexion à nos serveurs SQL sous la forme "password.php" qui est dans gitignore, et connect.php qui inclus password.php.
- Debug des fichiers login.php, registration.php & userpedpost.php
- Notion de super variable comme $_SESSION qui nous permet de stocker l'id de l'tilisateur actuellement connecté.
- Refactorisation de n1 & n2, header.php et connect.php
- Création de session et super globale de session pour naviguer dans toutes les pages avec notre id de connexion
- Création du formulaire pour pouvoir créer un message qui sera publié sur notre mur (requête SQL ok)

## Track Jour 3 : 09 Octobre 2024 

- Création du fichier like.php qui permet de vérifier si on a déjà liké un post en intérogeant la base de donnée, si c'est déjà liké alors on unlike en envoyant une requête SQL pour delete la ligne du like, s'il n'y a pas de like alors on insert une ligne dans la bdd pour liker le post
- formulaire bouton like/unlike dans le fichier wall.php, la methode=post d'action like.php
- la redirection depuis like.php vers wall.php user id ne fonctionne pas à la fin de l'execution de like.php

## Track Jour 4 : 10 Octobre 2024

- Gestion du bouton like et traitement
- création du fichier abo qui gère le traitement follow/unfollow des users
- refacto du bouton follow

## Track Jour 5 : 14 Octobre 2024

- Lors de l'inscription au réseau social, le site redirige maintenant vers la page de login.
- Modification d'une erreur qui faisait que si l'user n'est pas logged, la page fux affaichait le flux de la personne d'ID n°5. Cela a été remplacé par une redirection vers login.php
- Ajout d'un bouton de déconnection de la session.
- CSS des boutons
- CSS de la nav-bar