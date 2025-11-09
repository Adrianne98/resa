<?php
session_start();

// Chargement DB
$DB_FILE = __DIR__ . '/data.json';
$DB = json_decode(file_get_contents($DB_FILE), true);
if(!$DB) $DB = ["services"=>[], "users"=>[], "bookings"=>[]];

// Connexion
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['mail'], $_POST['password'])){
    $email = filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL);
    $pass = $_POST['password'];
    foreach($DB['users'] as $u){
        if($u['email']==$email && password_verify($pass, $u['password'])){
            $_SESSION['email'] = $email;
            break;
        }
    }
}
$CURRENT_EMAIL = $_SESSION['email'] ?? null;

// Rôle
function role(){
    global $DB, $CURRENT_EMAIL;
    foreach($DB['users'] as $u){
        if($u['email'] === $CURRENT_EMAIL) return $u['role'];
    }
    return 'anon';
}

// Sauvegarde DB
function saveDB($d){
    global $DB_FILE;
    file_put_contents($DB_FILE, json_encode($d, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
}

// Actions POST sécurisées
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['act'])){
    $a = $_POST['act'];
    $r = role();

    if($a === "addservice" && $r==='admin'){
        $name = htmlspecialchars(trim($_POST['name'] ?? 'Service'));
        $type = htmlspecialchars(trim($_POST['type'] ?? 'misc'));
        $id = count($DB['services']) + 1;
        $DB['services'][] = ["id"=>$id, "name"=>$name, "type"=>$type, "slots"=>[]];
        saveDB($DB);
        header("Location: index.php?ok=1"); die();
    } elseif($a === "addslot" && $r==='admin'){
        $sid = (int)($_POST['sid'] ?? 0);
        $slot = htmlspecialchars(trim($_POST['slot'] ?? date('Y-m-d H:i')));
        foreach($DB['services'] as &$sv){
            if($sv['id']==$sid){ $sv['slots'][] = $slot; }
        }
        saveDB($DB);
    } elseif($a === "book" && $r!=='anon'){
        $sid = (int)($_POST['sid'] ?? 0);
        $slot = htmlspecialchars(trim($_POST['slot'] ?? ''));
        $DB['bookings'][] = ["id"=>count($DB['bookings'])+1, "email"=>$CURRENT_EMAIL, "service"=>$sid, "slot"=>$slot];
        saveDB($DB);
    } elseif($a === "cancel" && $r!=='anon'){
        $bid = (int)($_POST['bid'] ?? 0);
        foreach($DB['bookings'] as $k=>$b){
            if($b['id']==$bid && $b['email']==$CURRENT_EMAIL){
                unset($DB['bookings'][$k]);
            }
        }
        $DB['bookings'] = array_values($DB['bookings']);
        saveDB($DB);
    }
}

// Inclure interface HTML
include 'main.html';
?>
