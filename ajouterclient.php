<?php
include('connexion.php');


$userE = 'SELECT COUNT(*) as count FROM clients WHERE email = :email';
$utili = $db->prepare($userE);
$utili->execute(['email' => $_POST['email']]);
$Result = $utili->fetch(PDO::FETCH_ASSOC);

if ($Result['count'] > 0) {
   
    echo '<script>alert("Utilisateur déjà enregistré."); window.history.back();</script>';
    exit;
}

// L'utilisateur n'est pas enregistré, procéder à l'insertion dans la base de données
$sqlQuery = 'INSERT INTO clients(nom, email, tel, adresse, sexe, state) VALUES (:nom, :email, :tel, :adresse, :sexe, :state)';
$inser = $db->prepare($sqlQuery);

$inser->execute([
    'nom' => $_POST['nom'],
    'email' => $_POST['email'],
    'tel' => $_POST['tel'],
    'adresse' => $_POST['adresse'],
    'sexe' => $_POST['sexe'],
    'state' => $_POST['state']
]);

echo '<h1>Inscrit avec succès</h1>';
include('inscription.php');
?>
