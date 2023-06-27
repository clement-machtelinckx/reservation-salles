<?php

$serveur = 'localhost';
$nomUtilisateur = 'root';
$motDePasse = 'Clement2203$';
$nomBaseDeDonnees = 'reservationsalles';

$bdd = new PDO("mysql:host=$serveur;dbname=$nomBaseDeDonnees;charset=utf8", $nomUtilisateur, $motDePasse);

if (isset($_POST['submit'])){
    $login = htmlspecialchars($_POST['login']);

    $mdp = sha1($_POST['password']);
    $mdp2 = sha1($_POST['password2']);

    if (!empty($_POST['login']) AND !empty($_POST['password']) AND !empty($_POST['password2'])){


        $loginlen = strlen($login);

        if($loginlen <= 255){
            $reqlog = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?");
            $reqlog->execute(array($login));
            $logexist = $reqlog->rowcount();
            if($logexist == 0){
                if($mdp == $mdp2){
                    $insertmbr = $bdd->prepare ("INSERT INTO utilisateurs(login, password) VALUES(?, ?)");
                    $insertmbr->execute(array($login, $mdp));
                    $erreur = "(not error) : user rentré dans bdd";
                }
                else{
                    $erreur = "le mot de passe n'est pas identique au mot de passe rentré!";
                }
            }
            else{
                $erreur = "login deja utiliser";
            }
        }
        else{
            $erreur = "le login doit etre inferieur a 255 caractere";
        }
    }   
    else{
        $erreur = "tout les chanps doivent etre remplie";
    }
}
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style_inscription.css" media="screen">

    <title>inscription</title>
</head>
<body>
    <div class="inscrip">
        <form class="formu" method="post" action="">
            <table>
                <tr>
                    <td>
                        <label for="login">Login : </label>
                    </td>
                    <td>
                        <input type="text" id="login" name="login" placeholder="login">
                    </td>
                </tr>


                <tr>
                    <td>
                        <label for="password">Password : </label>
                    </td>
                    <td>
                        <input type="password" id="password" name="password" placeholder="password">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password">Confime Password : </label>
                    </td>
                    <td>
                        <input type="password" id="password2" name="password2" placeholder="confime password">
                    </td>
                </tr>

            </table>
            <input type="submit" id="submit" name="submit" value="Submit">
        </form>
        <a href="connexion.php">deja inscrit ? connect toi !!</a>
        <a href="../index.php">accueil</a>
    </div>
    <?php
        if(isset($erreur)){
            echo $erreur ;
        }
    ?>
</body>