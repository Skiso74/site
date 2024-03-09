<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set("display_errors", 1);

if (!isset($_SESSION['id'])){
    header('Location: /index');
    exit;
}
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1"/>
		<title>Le site du plus beau</title>
		<link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" type="image/ico" href="favicon.ico"/>
        <meta http-equiv="refresh" content="2; URL=http://ruru.go.yj.fr/netflax">
	</head>

	<body>
		<div class="gauche">
            <a href="logout.php"><input type="button" class="box-disconect" value="Se déconnecter" ><a/>
        </div>
        
        <div class="milieu">
            <h1>VOUS VOICI SUR LA PAGE D'ACCUEIL !!</h1>

        
	</body>
</html>