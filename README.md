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

Ajout d'une approche "variable d'environnement" pour la connexion à nos serveurs SQL sous la forme "password.php" qui est dans gitignore, et connect.php qui inclus password.php.
Debug des fichiers login.php, registration.php & userpedpost.php
Notion de super variable comme $_SESSION qui nous permet de stocker l'id de l'tilisateur actuellement connecté