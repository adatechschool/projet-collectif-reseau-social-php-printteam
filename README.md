# projet-collectif-reseau-social-php-printteam

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
while ($tag = $lesInformations->fetch_assoc()){
   ```<h3><?php echo $tag['alias'] ?></h3>```
}

