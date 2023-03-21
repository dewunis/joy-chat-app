<?php
session_start();
require __DIR__ . '/../../database/config.php';

$pdo = pdo();

if (!isset($_SESSION['unique_id'])) {
    header('location:/');
    die();
}

$outgoing_id =  htmlspecialchars($_POST['outgoing-id']);
$incoming_id =  htmlspecialchars($_POST['incoming-id']);

$output = "";

$stmt = $pdo->prepare("SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.incoming_msg_id WHERE outgoing_msg_id=? AND incoming_msg_id=?
   OR (outgoing_msg_id=? AND incoming_msg_id=?) ORDER BY msg_id");

$stmt->execute([$outgoing_id, $incoming_id, $incoming_id, $outgoing_id]);
$messages = $stmt->fetchAll(PDO::FETCH_OBJ);

if ($messages) {
    foreach ($messages as $message) {
        if ($message->outgoing_msg_id  === $outgoing_id) {

            $output .= '
            <div class="__chat __chat_outcomming flex mb-5 ">
                <img class="w-8 h-8 object-cover rounded-full mr-3 relative -top-2" src="/images/' . $message->image . '"alt="profil">
                <div class="flex items-start mr-auto" style="max-width: calc(100% - 130px);" >
                    <p style="border-radius: 0px 18px 18px 18px;" class="bg-white px-2 py-4 text-xs text-gray-900">' . $message->msg . '</p>
                </div>
            </div>
            ';
        } else {

            $output .= '
            <div class="__chat __chat_outgoing flex mt-2">
                <div style="max-width: calc(100% - 130px);" class="ml-auto">
                    <p style="border-radius: 18px 18px 0 18px;" class="bg-black text-xs  text-white px-2 py-4">' . $message->msg . '</p>
                </div>
            </div>
            ';
        }
    }
}

echo $output;
