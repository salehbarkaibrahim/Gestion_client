<?php
include('connexion.php');

// Filtrage des clients
$filterByNom = isset($_POST['filter_nom']) ? $_POST['filter_nom'] : '';
$filterByAdresse = isset($_POST['filter_adresse']) ? $_POST['filter_adresse'] : '';
$filterByTelephone = isset($_POST['filter_tel']) ? $_POST['filter_tel'] : '';
$filterByStatut = isset($_POST['filter_statut']) ? $_POST['filter_statut'] : '';

$sqlQuery = 'SELECT * FROM clients WHERE 1';

if (!empty($filterByNom)) {
    $sqlQuery .= ' AND nom LIKE :nom';
}

if (!empty($filterByAdresse)) {
    $sqlQuery .= ' AND adresse LIKE :adresse';
}

if (!empty($filterByTelephone)) {
    $sqlQuery .= ' AND tel LIKE :tel';
}

if (!empty($filterByStatut)) {
    $sqlQuery .= ' AND state = :statut';
}

$filteredData = [];
if (!empty($filterByNom) || !empty($filterByAdresse) || !empty($filterByTelephone) || !empty($filterByStatut)) {
    $stmt = $db->prepare($sqlQuery);

    if (!empty($filterByNom)) {
        $stmt->bindValue(':nom', '%' . $filterByNom . '%');
    }

    if (!empty($filterByAdresse)) {
        $stmt->bindValue(':adresse', '%' . $filterByAdresse . '%');
    }

    if (!empty($filterByTelephone)) {
        $stmt->bindValue(':tel', '%' . $filterByTelephone . '%');
    }

    if (!empty($filterByStatut)) {
        $stmt->bindValue(':statut', $filterByStatut);
    }

    $stmt->execute();
    $filteredData = $stmt->fetchAll();
} 
// Tri des clients (par défaut, tri par id)
$sortField = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$sortOrder = isset($_GET['order']) && strtolower($_GET['order']) === 'desc' ? 'DESC' : 'ASC';

usort($filteredData, function($a, $b) use ($sortField, $sortOrder) {
    return $sortOrder === 'ASC' ? strnatcmp($a[$sortField], $b[$sortField]) : strnatcmp($b[$sortField], $a[$sortField]);
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Le reste de l'en-tête HTML -->
</head>
<body>
    <form action="" method="post">
        <label for="filter_nom">Filtrer par nom:</label>
        <input type="text" name="filter_nom" id="filter_nom">
        <label for="filter_adresse">Filtrer par adresse:</label>
        <input type="text" name="filter_adresse" id="filter_adresse">
        <label for="filter_tel">Filtrer par téléphone:</label>
        <input type="text" name="filter_tel" id="filter_tel">
        <label for="filter_statut">Filtrer par statut:</label>
        <select name="filter_statut" id="filter_statut">
            <option value="">Tous</option>
            <option value="actif">Actif</option>
            <option value="inactif">Inactif</option>
        </select>
        <input type="submit" value="Filtrer">
    </form>

    <table align="center" border="1">
        <tr>
            <td><a href="?sort=nom&order=<?php echo ($sortField === 'nom' && $sortOrder === 'ASC') ? 'desc' : 'asc'; ?>">Nom</a></td>
            <td><a href="?sort=email&order=<?php echo ($sortField === 'email' && $sortOrder === 'ASC') ? 'desc' : 'asc'; ?>">Email</a></td>
            <td><a href="?sort=adresse&order=<?php echo ($sortField === 'adresse' && $sortOrder === 'ASC') ? 'desc' : 'asc'; ?>">Adresse</a></td>
            <td><a href="?sort=tel&order=<?php echo ($sortField === 'tel' && $sortOrder === 'ASC') ? 'desc' : 'asc'; ?>">Téléphone</a></td>
            <td><a href="?sort=sexe&order=<?php echo ($sortField === 'sexe' && $sortOrder === 'ASC') ? 'desc' : 'asc'; ?>">Sexe</a></td>
            <td><a href="?sort=state&order=<?php echo ($sortField === 'state' && $sortOrder === 'ASC') ? 'desc' : 'asc'; ?>">État</a></td>
        </tr>
        <?php foreach ($filteredData as $cli) { ?>
            <tr>
                <td><?php echo $cli['nom']; ?></td>
                <td><?php echo $cli['email']; ?></td>
                <td><?php echo $cli['adresse']; ?></td>
                <td><?php echo $cli['tel']; ?></td>
                <td><?php echo $cli['sexe']; ?></td>
                <td><?php echo $cli['state']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
    for($i=1;$i<=$_GET['nb'];$i++){
        if(isset($_POST['sup'.$i])){
            include('connexion.php');
            $sqlQuery="DELETE FROM clients where id='".$_POST['id'.$i]."'";
            $sup=$db->prepare($sqlQuery);
            $sup->execute();
            header('Location:utilisateur.php');
    }
    if(isset($_POST['mod'.$i])){
        echo "<form method='POST' action='scriptmodifier.php'>";
         echo "<table>";
            echo "<tr>";
                echo "<td> <input type='text' name='nom' value='".$_POST['nom'.$i]."' > </td> ";
                echo "<td> <input type='text' name='email' value='".$_POST['email'.$i]."' > 
                <input name='id' value='".$_POST['id'.$i]."' ></td> ";
                echo "<td> <input type='text' name='tel' value='".$_POST['tel'.$i]."' > </td> ";
                echo "<td> <input type='text' name='adresse' value='".$_POST['adresse'.$i]."' > </td> ";
                echo "<td> <input type='text' name='sexe' value='".$_POST['sexe'.$i]."' > </td> ";
                echo "<td> <input type='text' name='state' value='".$_POST['state'.$i]."' > </td> ";
                echo "<td><button type='submit' name='mod".$i."'>Modifier</button></td>"; 
            "</tr>";
          "</table>";
        echo "<form/>";
    }
    

    }
    if(isset($_POST["Ajouter"])){
        include('utilisateur.html');
    }
?>
<style>
    /* Réinitialisation des marges et des rembourrages */
body, h1, h2, h3, p, ul, li {
  margin: 0;
  padding: 0;
}

/* Style de l'en-tête */
body {
  font-family: Arial, sans-serif;
  background-color: #f2f2f2;
  line-height: 1.6;
  color: #333;
}

h1 {
  text-align: center;
  padding: 20px 0;
  background-color: #007bff;
  color: #fff;
}

/* Style du formulaire de filtrage */
form {
  text-align: center;
  margin: 20px 0;
}

label, select, input[type="text"], input[type="submit"] {
  margin: 5px;
}

input[type="text"], select {
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

input[type="submit"] {
  background-color: #007bff;
  color: #fff;
  padding: 8px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

/* Style du tableau de clients */
table {
  margin: 0 auto;
  border-collapse: collapse;
  width: 80%;
  text-align: center;
}

table, th, td {
  border: 1px solid #ddd;
}

th, td {
  padding: 10px;
}

th {
  background-color: #007bff;
  color: #fff;
  cursor: pointer;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

/* Style des liens de tri */
a {
  color: #007bff;
  text-decoration: none;
  font-weight: bold;
}

/* Style des boutons */
button {
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 8px 15px;
  cursor: pointer;
  margin: 5px;
}

button:hover {
  background-color: #0056b3;
}

</style>