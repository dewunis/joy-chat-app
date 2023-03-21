<?php 
session_start();
require __DIR__.'/../database/config.php';

$pdo = pdo(); 

if(!isset($_SESSION['unique_id'] )){
    header('location:/');
    die();
}

if(isset($_GET['user_id'])){
    $unique_id = htmlspecialchars($_GET['user_id']);
}else{
    header('location:/users.php');
    die();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE unique_id=?");
$stmt->execute([$unique_id]); 
$user = $stmt->fetch(PDO::FETCH_OBJ);

if(!$user){
    echo 'NOT FOUND';
    header( "HTTP/1.1 404 Not Found" );
    die();
}

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=*, initial-scale=1.0">
        <link rel="stylesheet" href="/dist/output.css">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
            integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>JoyChat - Message</title>
        <style>
            #chat-box::-webkit-scrollbar{
                width:0px;
            }
        </style>
    </head>
    <body class="font-poppins overflow-hidden">
        <div id="modal" class="fixed w-screen h-screen left-0 top-0 z-50
            bg-black
            bg-opacity-50 flex items-center justify-center min-h-screen">

            <div  class="relative max-w-lg pt-6
                w-full bg-white border border-gray-50 rounded-lg mx-1">
                <section id="chat-area" class="overflow-hidden">

                    <header class="flex items-center justify-between pb-4 px-4" style="max-height: 120px;">

                        <div id="content" class="flex items-center">
                            <a href="/users.php">
                                <i class="fa-solid fa-arrow-left text-gray-800 mr-2" ></i>
                            </a>
                            <img class="w-12 h-12 object-cover rounded-full" src="/images/<?= $user->image ?>" alt="profil">
                            <div id="detail" class="ml-4">
                                <span class="font-medium text-sm"><?= $user->name ?></span>
                                <p class="text-gray-700 text-xs"><?= $user->status ?></p>
                            </div>
                        </div>

                        <div class="ml-1 transition flex items-center justify-center w-8 h-8 hover:bg-gray-200 cursor-pointer rounded-full">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </div>
                        
                    </header>

                    <div id="chat-box" class="overflow-hidden overflow-y-auto py-4 px-4 bg-gray-100 rounded-b-lg" style="height:calc(80vh - 120px);">
                        
                       
                        <!-- <div class="__chat __chat_outgoing flex mb-5">
                            <div style="max-width: calc(100% - 130px);" class="ml-auto">
                                <p style="border-radius: 18px 18px 0 18px;" class="bg-black text-xs  text-white px-2 py-4">Lorem ipsum dolor sit amet, consectetur ffdkjjf fsghuisd qsdguid</p>
                            </div>
                        </div>
                        <div class="__chat __chat_outcomming flex mb-5">
                            <img class="w-10 h-10 object-cover rounded-full mr-3 relative -top-4" src="/images/me.png" alt="profil">
                            <div class="flex items-start mr-auto" style="max-width: calc(100% - 130px);" >
                                <p style="border-radius: 0px 18px 18px 18px;" class="bg-white px-2 py-4 text-xs text-gray-900">Lorem ipsum dolor sit amet, consectetur ffdkjjf fsghuisd qsdguid</p>
                            </div>
                        </div> -->


                    </div>

                    <form autocomplete="off" class="flex items-center py-4 px-2 justify-between relative" action="#" id="type-area">
                        <div id="emoji" class="mx-4">
                            <i class="fa-regular fa-face-smile text-gray-700 text-lg"></i>

                        </div>
                        <input name="outgoing-id" type="text" value="<?= $_SESSION['unique_id'] ?>" hidden>
                        <input name="incoming-id" type="text" value="<?= $_GET['user_id'] ?>" hidden>
                        <input id="input-message" type="text" class="h-12 px-3 text-sm rounded-l-lg border border-gray-200 outline-none focus:border-gray-500" style="width:calc(100% - 58px)" name="message"  placeholder="Taper votre message">
                        <button id="send-message" class="flex hover:bg-opacity-90 items-center justify-center bg-black text-white h-12 rounded-r-lg" style="width: 58px;"><i class="fa-solid fa-paper-plane"></i></button>
                    </form>

                </section>
            </div>

        </div>
        <script src="/js/message.js"></script>
    </body>
</html>