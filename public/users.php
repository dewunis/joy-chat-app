<?php 
session_start();
require __DIR__.'/../database/config.php';

$pdo = pdo(); 

if(!isset($_SESSION['unique_id'] )){
    header('location:/');
    die();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE unique_id=?");
$stmt->execute([$_SESSION['unique_id']]); 
$user = $stmt->fetch(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=*, initial-scale=1.0">
        <link rel="stylesheet" href="/dist/output.css">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
            integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>JoyChat - Utilisateurs</title>
        <style>
            #user-list.__offline{
                color: gray;
            }
        </style>
    </head>
    <body class="font-poppins overflow-hidden">
        <div id="modal" class="fixed w-screen h-screen left-0 top-0 z-50
            bg-black
            bg-opacity-50 flex items-center justify-center min-h-screen">

            <div  class="relative max-w-lg p-4
                w-full bg-white border border-gray-50 rounded-lg mx-1">
                <section id="users" class="overflow-hidden">
                    <header class="flex items-center justify-between pb-4 border-b border-b-gray-200" style="max-height: 120px;">
                        <div id="content" class="flex">
                            <img class="w-12 h-12 object-cover rounded-full" src="/images/<?= $user->image ?>" alt="profil">
                            <div id="detail" class="ml-4">
                                <span class="font-medium text-sm"><?= $user->name ?></span>
                                <p class="text-gray-700 text-xs"><?= $user->status ?></p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <a href="/logout.php" class="bg-black transition-opacity hover:bg-opacity-90 text-white px-2 py-2 text-sm rounded-lg">
                                Deconnexion
                            </a>
                            <div class="ml-1 transition flex items-center justify-center w-8 h-8 hover:bg-gray-200 cursor-pointer rounded-full">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </div>
                        </div>
                    </header>
                    <div id="search" class="my-8 flex items-center justify-between relative">
                        <span id="text" class="opacity-0">Selectioner un utlistaeur</span>
                        <input autocomplete="off" class="h-11 outline-none border-gray-200 border w-full rounded-xl focus:border-gray-500 absolute text-sm pr-2 pl-10" type="text" name="name" id="search-bar" placeholder="Enter un nom pour rechercher un utlisateur" id="name">
                        <button class="absolute cursor-pointer text-gray-700 left-3"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>

                    <div id="user-list" class="overflow-hidden overflow-y-auto" style="max-height:calc(80vh - 120px);">

                            <!-- <a href="" class="hover:bg-gray-100 flex items-center justify-between py-4 hover:rounded-lg pl-2" style="page-break-after:10px;">
                                <div class="flex w-full">
                                    <img class="w-12 h-12 object-cover rounded-full" src="/images/" alt="profil">
                                    <div id="detail" class="ml-4">
                                        <span class="font-medium text-sm">Name</span>
                                        <p class="text-gray-600 text-xs">Message option</p>
                                    </div>
                                </div>

                                <div id="status" class="mr-2 text-green-600 w-12 h-12 flex items-center justify-center __offline">
                                    <i class="fa-solid fa-circle text-xs"></i>
                                </div>
                            </a> -->
                    </div>
                </section>
            </div>

        </div>
        <script src="/js/users.js"></script>
    </body>
</html>