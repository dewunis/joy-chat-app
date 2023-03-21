<?php
session_start();
require __DIR__.'/../../database/config.php';

$pdo = pdo(); 

if(!isset($_SESSION['unique_id'] )){
    header('location:/');
    die();
}

$outgoing_id =  htmlspecialchars($_POST['outgoing-id']);
$incoming_id =  htmlspecialchars($_POST['incoming-id']);

$message =  htmlspecialchars($_POST['message']);

if(empty($message)){
    die();
}

$sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id ,msg) VALUES (?,?,?)";
$stmt= $pdo->prepare($sql);
$response = $stmt->execute([$outgoing_id ,$incoming_id,$message]);
