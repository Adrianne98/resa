<?php
session_start();
header('Content-Type: application/json'); 

$DB_FILE = __DIR__ . '/data.json';
$DB = json_decode(file_get_contents($DB_FILE), true);
if(!$DB) $DB = ["services"=>[], "users"=>[], "bookings"=>[]];

$email = $_SESSION['email'] ?? null;
$act = $_GET['a'] ?? 'list';

if($act==='list_services'){
    echo json_encode($DB['services']);
} elseif($act==='list_bookings'){
    if(!$email){ echo json_encode([]); exit; }
    $out = [];
    foreach($DB['bookings'] as $b){
        if($b['email']==$email) $out[] = $b;
    }
    echo json_encode($out);
} else {
    echo json_encode(["status"=>"error","msg"=>"unknown action"]);
}
exit;
?>
