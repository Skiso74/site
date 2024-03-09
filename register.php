<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set("display_errors", 1);

require('./class/connexionDB.php');

if (isset($_SESSION['id'])){
    header('Location: /accueil');
    exit;
}

if(!empty($_POST)){
    extract($_POST);
    $valid = true;


// On se place sur le bon formulaire grâce au "name" de la balise "input"

    if (isset($_POST['Enregistrer'])) {
        $mail = htmlentities(strtolower(trim($mail))); // On récup ère le mail
        $mdp = sha1(trim($password)); // On récupère le mot de passe
        $username = htmlentities(trim($username)); // On récup le nom d'utilisatteur

        if(empty($username)){
            $valid = false;
            $er_username = ("Veuillez saisir un nom d'utilisateur");
        }else{
            $req_username = $db->query("SELECT username FROM user WHERE username = ?",
            array($username));
            $req_username = $req_username->fetch();
        if ($req_username['username'] <> ""){
            $valid = false;
            $er_username = "Ce nom d'utilisateur est déjà utilisé pour un autre compte";
        }
        }

        if(empty($mail)){
            $valid = false;
            $er_mail = ("Veuillez rentrer un email.");
        }elseif(!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $mail)) {
            $valid = false;
            $er_mail = "Le mail n'est pas valide";
        }else{
            // On vérifit que le mail est disponible
            $req_mail = $db->query("SELECT mail FROM user WHERE mail = ?",
                array($mail));

            $req_mail = $req_mail->fetch();

            if ($req_mail['mail'] <> ""){
                $valid = false;
                $er_mail = "Ce mail existe déjà";
            }
        }

        if(empty($mdp)){
            $valid = false;
            $er_mdp = ("Veuillez rentrer un mot de passe.");
        }

        if($valid){

            // On insert nos données dans la table utilisateur
            $db->insert("INSERT INTO user (mail, password, username) VALUES 
                    (?, ?, ?)",
                array($mail, $mdp, $username));

            header("Location: /accueil");
        }
    }
}
?>



<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=0.9"/>
        <title>Le site du plus beau</title>
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" type="image/ico" href="favicon.ico"/>
    </head>

    <body>
        <h1 class="box-title">S'inscrire</h1>

        <form class="box" method="post">

        <input type="username" class="box-input" name="username" placeholder="Nom d'utilisateur" />
        <input type="mail" class="box-input" name="mail" placeholder="Email" />
        <input type="password" class="box-input" name="password" placeholder="Mot de passe" />
        
        <div class="milieu">
        <input type="submit" name="Enregistrer" value="S'inscrire" class="box-button" />
        </div>
        
        <div class="error">
        <p>
        <p>
        <?php if(isset($er_mail)){ echo $er_mail;} ?>
        <?php if(isset($er_mdp)){ echo $er_mdp;} ?>
        <?php if(isset($er_username)){ echo $er_username;} ?>
        
        </div>
        
        <p class="box-register">Déjà inscrit? <a href="login">Connectez-vous ici</a></p>

        </form>
    </body>
</html>
