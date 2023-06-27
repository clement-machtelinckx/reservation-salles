<?php
session_start();

$serveur = 'localhost';
$nomUtilisateur = 'root';
$motDePasse = 'Clement2203$';
$nomBaseDeDonnees = 'reservationsalles';

$bdd = new PDO("mysql:host=$serveur;dbname=$nomBaseDeDonnees;charset=utf8", $nomUtilisateur, $motDePasse);
if (isset($_GET['id']) AND $_GET['id'] > 0){
    $getid = intval($_GET['id']);
    $requser = $bdd -> prepare('SELECT * FROM utilisateurs WHERE id =?');
    $requser -> execute(array($getid));
    $userinfos = $requser -> fetch();
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style_profil.css" media="screen">

    <title>Profil</title>
</head>
<body>
<div class="profil">
<h2>Profil de <?php echo $userinfos['login'];?></h2>
<br /><br />
Login = <?php echo $userinfos['login'];?><br>


</div>
<div class="profil2">
        <?php
        if (isset($_SESSION['id']) AND $userinfos['id'] == $_SESSION['id']){
            ?>
            <a class="modif" href="profil-modif.php">editer le profil</a><br>
            <a class="plan" href="planning.php">Planning</a><br>
            <a class="deco" href="deconnexion.php">se déconnecter</a>
        <?php
        }
        ?>

    <?php
        if(isset($erreur)){
            echo $erreur ;
        }
    }
    ?>
</div>
</body>