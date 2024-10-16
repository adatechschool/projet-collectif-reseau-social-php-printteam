<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Inscription</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <?php include 'header.php';?>

        <div id="wrapper" >

            <aside>
                <h2>Présentation</h2>
                <p>Bienvenu sur notre réseau social.</p>
            </aside>
            <main>
                <article>
                    <h2>Inscription</h2>
                    <?php
                        $enCoursDeTraitement = isset($_POST['email']);
                        if ($enCoursDeTraitement) {
                            // Récupérer les données du formulaire
                            $new_email = $_POST['email'];
                            $new_alias = $_POST['pseudo'];
                            $new_passwd = $_POST['motpasse'];
                            $new_passwd = md5($new_passwd);  // Hash du mot de passe
                            
                            if (isset($_FILES['profil-picture']) && $_FILES['profil-picture']['error'] === UPLOAD_ERR_OK) {
                                $fileTmpPath = $_FILES['profil-picture']['tmp_name'];
                                $fileName = $_FILES['profil-picture']['name'];
                                $fileSize = $_FILES['profil-picture']['size'];
                                $fileType = $_FILES['profil-picture']['type'];
                                $fileNameCmps = explode(".", $fileName);
                                $fileExtension = strtolower(end($fileNameCmps));

                                $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
                                if (in_array($fileExtension, $allowedfileExtensions)) {
                                    $uploadFileDir = './uploads/';
                                    $dest_path = $uploadFileDir . $fileName;

                                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                                        echo 'Le fichier a été téléchargé avec succès.';
                                        
                                        include("connect.php");
                                        $new_email = $mysqli->real_escape_string($new_email);
                                        $new_alias = $mysqli->real_escape_string($new_alias);
                                        $new_picture = $mysqli->real_escape_string($fileName);
                                        $lInstructionSql = "INSERT INTO users (email, password, alias, picture) "
                                                . "VALUES ('" . $new_email . "', '" . $new_passwd . "', '" . $new_alias . "', '" . $new_picture . "');";
                                        $ok = $mysqli->query($lInstructionSql);
                                        if ($ok) {
                                            echo "Votre inscription est un succès : " . $new_alias;
                                                header('Location: login.php');
                                                exit();
                                        } else {
                                            echo "Erreur lors de l'inscription : " . $mysqli->error;
                                        }
                                    } else {
                                        echo 'Erreur lors du déplacement du fichier.';
                                    }
                                } else {
                                    echo 'Type de fichier non autorisé.';
                                }
                            } else {
                                echo 'Erreur lors de l\'envoi de l\'image.';
                            }
                        }
                    ?>  

                    <form action="registration.php" method="post" enctype="multipart/form-data">
                        <dl>
                            <dt><label  for='pseudo'>Pseudo</label></dt>
                            <dd><input aria-describedby="la chaaaaaatte pseudo" type='text'name='pseudo'></dd>
                            <dt><label  for='email'>E-Mail</label></dt>
                            <dd><input aria-describedby="la chaaaaaatte email" type='email'name='email'></dd>
                            <dt><label  for='motpasse'>Mot de passe</label></dt>
                            <dd><input aria-describedby="la chaaaaatte motpasse" type='password'name='motpasse'></dd>
                            <dt><label  for='profil-picture'>Ajouter une photo de profil</label></dt>
                            <dd><input aria-describedby="image" type='file' name='profil-picture'></dd>
                        </dl>
                        <input type='submit' class="button-1">
                        <p>Nous collectons vos données personnelles pour vous offrir un service personnalisé. En acceptant, vous consentez à ce que nous stockions et traitions ces données conformément à notre <a href="/privacy-policy">politique de confidentialité</a>.</p>
                        <label>
                            <input type="checkbox" required /> J'accepte que mes données soient stockées et traitées.
                        </label>
                        <p>Conformément à la réglementation, vous disposez des droits suivants sur vos données personnelles :</p>
                        <ul>
                            <li>Accéder à vos données</li>
                            <li>Rectifier vos informations personnelles</li>
                            <li>Demander l'effacement de vos données</li>
                            <li>Retirer votre consentement à tout moment</li>
                        </ul>
                    </form>
                </article>
            </main>
        </div>
    </body>
</html>
