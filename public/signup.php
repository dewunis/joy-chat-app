<?php
session_start();
require __DIR__.'/../database/config.php';

$pdo = pdo(); 

$name = htmlspecialchars($_POST['username']);
$password1  = htmlspecialchars($_POST['password1']);
$passsword2 = htmlspecialchars($_POST['password2']);

if(empty($name)  or empty($password1) or empty($passsword2)){
    echo "Tout les champs sont requis.";
    die();
}

if(strlen($name) > 12){
    echo "Nom d'utilisateur trop long.(max - 15)";
    die();
}

if($passsword2 != $password1){
    echo "Mot de passe non identique.";
    die();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE name=?");
$stmt->execute([$name]); 
$user = $stmt->fetch(PDO::FETCH_OBJ);

if($user){
    echo "Ce nom d'utilisateur est deja choisie.";
    die();
}

if(!isset($_FILES['file'])){
    echo "Veuillez choisir une image.";
    die();
}

if(empty($_FILES['file']['name']) or empty($_FILES['file']['tmp_name']) or $_FILES['file']['error'] != UPLOAD_ERR_OK ){
    echo "Veuillez choisir une image valide.";
    die();
}
 

$file_name = $_FILES['file']['name'];
$file_type = $_FILES['file']['type'];
$file_tmp_name = $_FILES['file']['tmp_name'];

$explode = explode('.',$file_name);
$extension = end($explode);

$extensions = ['png','jpeg','jpg']; //Valide extension
if(!in_array($extension,$extensions)){
    echo "Format de l'image non valide.";
    die();
}

$time = time();
$new_file_name = $time.$file_name;

if(!move_uploaded_file($file_tmp_name,'images/'.$new_file_name)){
    echo "Oups! Une erreur s'est produit.";
    die();
}

$status = 'En ligne';
$random_id = rand(time(),1000000);

$sql = "INSERT INTO users (unique_id ,name,password,image,status) VALUES (?,?,?,?,?)";
$stmt= $pdo->prepare($sql);
$response = $stmt->execute([$random_id,$name,password_hash($password1,PASSWORD_DEFAULT),$new_file_name,$status]);

if(!$response){
    echo "Oups! Une erreur s'est produit.";
    die();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE name=?");
$stmt->execute([$name]); 
$user = $stmt->fetch(PDO::FETCH_OBJ);

$_SESSION['unique_id'] = $user->unique_id;

echo 'Okay'; //This message for ajax 