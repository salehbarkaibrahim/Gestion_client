<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="log.css">
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>

    <form action="ajouterclient.php" method="POST">
    <div class="aj"><h1 align="center">Ajouter Client</h1></div>
        <hr>
    <div align="center">
   <input type="text" name="nom" size="20" placeholder="nom" required> <br> <br> 
    <input type="text" name="email" size="20" placeholder="email" required> <br> <br>
    <input type="number" name="tel" size="20" placeholder="tel" required> <br> <br>
    <input type="text" name="adresse" size="20" placeholder="Adress" required> <br> <br>
    <input type="text" name="sexe" size="20" placeholder="sexe" required> <br> <br>
    <input type="text" name="state" seieze="20" placeholder="status" required><br><br>
    
    <button type="submit" class="btn">S'inscrire</button> <br> <br>
   
    </div>
</form>
</body>
</html>