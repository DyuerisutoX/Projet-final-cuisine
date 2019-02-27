<?php
$hostname ='localhost';
$dbname = 'cuisine';
$username='root';
$password ='';

try{
$bdd = New PDO("mysql:host=$hostname;dbname=$dbname;charset=utf8", $username, $password ,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
?> 