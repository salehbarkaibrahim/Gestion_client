<?php
     include('connexion.php');
     $sqlQuery="UPDATE clients SET nom = :nom, email = :email, tel = :tel, adresse= :adresse, sexe = :sexe, state = :state WHERE id =:id;";
     $mod=$db->prepare($sqlQuery);
     $mod->execute(
        array(
            'nom'=>$_POST['nom'],
            'email'=>$_POST['email'],
            'tel'=>$_POST['tel'],
            'adresse'=>$_POST['adresse'],
            'sexe'=>$_POST['sexe'],
            'state'=>$_POST['state'],
            'id'=>$_POST['id'],
        )
        );
        header('Location:utilisateur.php');
?>