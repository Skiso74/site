<?php
session_start();
ini_set("display_errors", 1);
ini_set("display_startup_error", 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require('./class/connexionDB.php');

extract($_POST);
if(isset($_POST['login'])) {
    $mailconnect = htmlentities(strtolower(trim($mailconnect)));
    $mdpconnect = sha1($mdpconnect);
    if(!empty($mailconnect) AND !empty($mdpconnect)) {
        $requser = $db->query("SELECT * FROM user WHERE mail = ? AND password = ?", array($mailconnect, $mdpconnect));
        $requser = $requser->fetch();
        if($requser['id'] != "") {
            $_SESSION['id'] = $requser['id'];
            $_SESSION['mail'] = $requser['mail'];
            header('Location: /accueil');
        } else {
            $erreur = "Mauvais mail ou mot de passe !";
        }
    } else {
        $erreur = "Tous les champs doivent être complétés !";
    }
}
?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=0.9"/>
    <title>Le site le plus beau</title>
    <!-- importer le fichier de style -->
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="image/ico" href="favicon.ico"/>
</head>
<body>
<h1 class="box-title">Connexion</h1>
<!-- zone de connexion -->

<form class="box" method="post">
    
    <input type="mail" class="box-input" placeholder="Entrer une adresse mail" name="mailconnect">

    
    <input type="password"class="box-input" placeholder="Entrer le mot de passe" name="mdpconnect">
    
    <div class="milieu">
    <input type="submit" name="login" class="box-button" value='Connexion' >
    </div>
    
    <p>
    <p>
    
    <div class="error">
    <?php if(isset($erreur)) echo $erreur ?>
    </div>
    
    <p class="box-register">Pas inscrit? <a href="register">Inscrivez-vous ici</a></p>

</form>
</body>
</html>