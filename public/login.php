<?php 
session_start();
require __DIR__.'/../database/config.php';

$pdo = pdo(); 

$name = htmlspecialchars($_POST['username']);
$password  = htmlspecialchars($_POST['password']);

if(empty($name) or empty($password)){
    echo "Tout les champs sont requis.";
    die();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE name=?");
$stmt->execute([$name]); 
$user = $stmt->fetch(PDO::FETCH_OBJ);

if(!$user){
    echo "Veuillez vous inscrire.";
    die();
}

if(!password_verify($password,$user->password)){
    echo "Identifiants incorrect.";
    die();
}

$_SESSION['unique_id'] = $user->unique_id;

echo 'Okay';