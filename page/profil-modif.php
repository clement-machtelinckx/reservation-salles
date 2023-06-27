<?php
session_start();

$serveur = 'localhost';
$nomUtilisateur = 'root';
$motDePasse = 'Clement2203$';
$nomBaseDeDonnees = 'reservationsalles';

$bdd = new PDO("mysql:host=$serveur;dbname=$nomBaseDeDonnees;charset=utf8", $nomUtilisateur, $motDePasse);
if (isset($_SESSION['id'])){
    $requser = $bdd -> prepare('SELECT * FROM utilisateurs WHERE id =?');
    $requser -> execute(array($_SESSION['id']));
    $user = $requser->fetch();
    if(isset($_POST['newlogin']) AND !empty($_POST['newlogin']) AND $_POST['newlogin'] != $user['login']) {
        $newlogin = htmlspecialchars($_POST['newlogin']);

        $checklogin = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $checklogin->execute(array($newlogin));
        $existingLogin = $checklogin->fetch();
        if (!$existingLogin){
        $insertlogin = $bdd->prepare("UPDATE utilisateurs SET login = ? WHERE id = ?");
        $insertlogin->execute(array($newlogin, $_SESSION['id']));
        header('Location: profil.php?id='.$_SESSION['id']);
        }
        else {
            // Le nouveau login existe déjà, afficher un message d'erreur
            $erreur = "Ce login est déjà utilisé par un autre utilisateur.";
        }
     }


     if(isset($_POST['newpassword']) AND !empty($_POST['newpassword']) AND isset($_POST['newpassword2']) AND !empty($_POST['newpassword2'])) {
        $mdp1 = sha1($_POST['newpassword']);
        $mdp2 = sha1($_POST['newpassword2']);
        if($mdp1 == $mdp2) {
           $insertmdp = $bdd->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
           $insertmdp->execute(array($mdp1, $_SESSION['id']));
           header('Location: profil.php?id='.$_SESSION['id']);
        } else {
           $msg = "Vos deux mdp ne correspondent pas !";
        }
    }
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style_profil-modif.css" media="screen">

    <title>modifier - Profil</title>
</head>
<body>
<div class="profil">
<h2>Edition de mon profil</h2>
<br /><br />
<form method="post" action="">
            <table>
                <tr>
                    <td>
                        <label for="newlogin">Login : </label>
                    </td>
                    <td>
                        <input type="text" id="newlogin" name="newlogin" placeholder="login" value="<?php echo $user['login'] ?>">
                    </td>
                </tr>


                <tr>
                    <td>
                        <label for="newpassword">Password : </label>
                    </td>
                    <td>
                        <input type="password" id="newpassword" name="newpassword" placeholder="password">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="newpassword">Confime Password : </label>
                    </td>
                    <td>
                        <input type="password" id="newpassword2" name="newpassword2" placeholder="confime password">
                    </td>
                </tr>

            </table>
            <input type="submit" id="newsubmit" name="newsubmit" value="Update profil">
        </form>
</div>
<div class="msg">
    <?php
        if(isset($msg)){
            echo $msg ;
        }
    }
    else{
        header("location: connecion.php");
    }
    ?>
        <?php
        if(isset($erreur)){
            echo $erreur ;
        }
    ?>
</div>
<div class="deco">
    <a href="deconnexion.php">deconnexion</a>
</div>
</body>