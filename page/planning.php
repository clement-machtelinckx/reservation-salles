

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style_profil-modif.css" media="screen">

    <title>Planning</title>
</head>

<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "Clement2203$";
$dbname = "reservationsalles";


// Définition des jours de la semaine et des horaires
$joursSemaine = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
$horaires = ['9h-10h', '10h-11h', '11h-12h', '14h-15h', '15h-16h'];

// Connexion à la base de données


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Récupération des réservations depuis la table 'reservations'
$sql = "SELECT * FROM reservations";
$result = $conn->query($sql);

// Génération du tableau HTML
echo "<table>
        <tr>
            <th></th>"; // Cellule vide pour l'en-tête
foreach ($joursSemaine as $jour) {
    echo "<th>$jour</th>";
}
echo "</tr>";

foreach ($horaires as $horaire) {
    echo "<tr>
            <th>$horaire</th>"; // Cellule pour l'horaire
    foreach ($joursSemaine as $jour) {
        // Cellule vide pour chaque horaire et jour de la semaine
        echo "<td></td>";
    }
    echo "</tr>";
}

echo "</table>";

// Fermeture de la connexion à la base de données
$conn->close();
?>
