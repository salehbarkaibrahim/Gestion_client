<?php
// Include the PDF library
require("fpdf/fpdf.php");

class ClientExporter
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    // Function to export data to CSV
    public function exportToCSV($filename)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename . '.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Nom', 'Email', 'Téléphone', 'Adresse', 'Sexe', 'État'));
        foreach ($this->data as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
    }

    // Function to export data to PDF
    public function exportToPDF($filename)
    {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(40, 10, 'Liste des clients');

        $pdf->Ln(); // Go to the next line

        foreach ($this->data as $row) {
            foreach ($row as $cell) {
                $pdf->Cell(40, 10, $cell, 1);
            }
            $pdf->Ln(); // Go to the next line after each data row
        }

        $pdf->Output('D', $filename . '.pdf');
    }
}

// Récupérer les données des clients depuis la base de données 
include('connexion.php');
$sqlQuery = 'SELECT nom, email, tel, adresse, sexe, state FROM clients';
$stmt = $db->query($sqlQuery);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$exporter = new ClientExporter($data);

// Exporter au format CSV lorsque l'utilisateur clique sur le bouton "Exporter CSV"
if (isset($_GET['export_csv'])) {
    $exporter->exportToCSV('liste_clients');
    exit;
}

// Exporter au format PDF lorsque l'utilisateur clique sur le bouton "Exporter PDF"
if (isset($_GET['export_pdf'])) {
    $exporter->exportToPDF('liste_clients');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        include('connexion.php');
        $sqlQuery = 'SELECT * FROM clients';
        $AdSte = $db->prepare($sqlQuery);
        $AdSte->execute();
        $tabAss=$AdSte->fetchAll();
        $taille=count($tabAss);
    ?>
</head>
<body>
  
    <form action=<?php echo "'scriptclient.php?nb=".$taille."'"; ?> method="post">
    <tr>
      <button ><a href="inscription.php" role="button">Nouveau Client</a></button>
    </tr>
  <br>
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

        <label for="sort_field">Trier par :</label>
        <select name="sort_field" id="sort_field">
            <option value="nom">Nom</option>
            <option value="email">Email</option>
            <option value="tel">Téléphone</option>
            <option value="adresse">Adresse</option>
            <option value="sexe">Sexe</option>
            <option value="state">État</option>
        </select>

        
        <input type="submit" value="Trier">
  
        <table align="center" border="1">
          <tr>
            <td>Nom</td>
            <td>email</td>
            <td>tel</td>
            <td>adresse</td>
            <td>sexe</td>
            <td>status</td>
            <td>Action</td>
            <td>action</td>
          </tr>
        <?php
        $i=0;
          foreach ($tabAss as $cli) {
          $i++;
          echo "<tr>";
               echo "<td><input size='20' readonly value='".$cli['nom']."' name='nom".$i."'</td>";
               echo "<td><input size='20' readonly value='".$cli['email']."' name='email".$i."'>
                     <input hidden value='".$cli['id']."' name='id".$i."'></td>";
                echo "<td><input size='20' readonly value='".$cli['tel']."' name='tel".$i."'</td>";
               echo "<td><input size='20' readonly value='".$cli['adresse']."' name='adresse".$i."'</td>";
               echo "<td><input size='20' readonly value='".$cli['sexe']."' name='sexe".$i."'</td>";
               echo "<td><input size='20' readonly value='".$cli['state']."' name='state".$i."'</td>";
              
               echo "<td><button type='submit' name='sup".$i."'>Supprimer</button></td>"; 
               echo "<td><button type='submit' name='mod".$i."'>Modifier</button></td>";
          echo "</tr>";

        }
        ?>
        </table>
        
    </form>
    <button><a href="?export_csv=true">Exporter en CSV</a></button>
    <button><a href="?export_pdf=true">Exporter en PDF</a></button>
    <style>
      body {
  font-family: Arial, sans-serif;
  background-color: #f2f2f2;
  color: #333;
  margin: 0;
  padding: 0;
}

h1 {
  text-align: center;
  background-color: #007bff;
  color: #fff;
  padding: 20px;
  margin-bottom: 20px;
}

form {
  text-align: center;
  margin-bottom: 20px;
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

table {
  width: 80%;
  margin: 0 auto;
  border-collapse: collapse;
  text-align: center;
  margin-bottom: 20px;
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



button {
  background-color: #007bff;
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
</body>
</html>