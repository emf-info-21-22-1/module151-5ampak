<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=mydb', 'root', 'emf123');
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Exemple de requête SQL (sélectionnez tous les enregistrements de maTable)
$requete = $bdd->query('SELECT * FROM maTable');

// Traitement des résultats
while ($donnees = $requete->fetch()) {
    // Utilisez $donnees pour accéder aux colonnes de chaque ligne
    echo 'Colonne1 : ' . $donnees['colonne1'] . '<br>';
}

// Fermer la requête
$requete->closeCursor();
?>