<?php
    try
    {
        $db = new PDO('mysql:host=localhost;dbname=gestion_client;charset=utf8', 'root', 'root');
    }
    catch (Exception $e)
    {
            die('Erreur de con : '. $e->getMessage());
    }
?>