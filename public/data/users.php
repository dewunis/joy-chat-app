<?php
session_start();
require __DIR__ . '/../../database/config.php';

$pdo = pdo();

if (!isset($_SESSION['unique_id'])) {
    header('location:/');
    die();
}

$outgoing_id = $_SESSION['unique_id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE unique_id != ?");
$stmt->execute([$_SESSION['unique_id']]);
$users = $stmt->fetchAll(PDO::FETCH_OBJ);


$output = "";

if ($users and sizeof($users) < 2) {
    $output .= "Aucun utilisateur pour discuter avec.Oups!";
} else {

    foreach ($users as $user) {


        $stmt1 = $pdo->prepare("SELECT * FROM messages WHERE(incoming_msg_id=?  OR outgoing_msg_id = ?) AND (outgoing_msg_id =? OR incoming_msg_id = ?) ORDER BY msg_id DESC LIMIT 1");
        $stmt1->execute([$user->unique_id, $user->unique_id, $outgoing_id, $outgoing_id]);
        $message = $stmt1->fetch(PDO::FETCH_OBJ);
        if ($message) {
            $response = $message->msg;
            //format message
            strlen($response) > 17 ? $msg = substr($response, 0, 20) . '...' : $msg = $response;
            ($outgoing_id == $message->outgoing_msg_id) ? $you = "" : $you = "Vous : ";
        } else {
            $msg = 'Aucune discussion.';
            $you = "";
        }


        $output .= '
                <a href="/message.php?user_id=' . $user->unique_id . '" class="hover:bg-gray-100 flex items-center justify-between py-4 hover:rounded-lg pl-2" style="page-break-after:10px;">
                    <div class="flex w-full">
                        <img class="w-10 h-10 object-cover rounded-full" src="/images/' . $user->image . '" alt="">
                        <div id="detail" class="ml-4">
                            <span class="font-medium text-sm">' . $user->name . '</span>
                            <p class="text-gray-600 text-xs">' .  $you . $msg . '</p>
                        </div>
                    </div>

                    <div id="status" class="mr-2 text-green-600 w-12 h-12 flex items-center justify-center __offline">
                        <i class="fa-solid fa-circle text-xs"></i>
                    </div>
                </a>
        ';
    }
}

echo $output;
