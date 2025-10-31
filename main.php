<?php

if(isset($_GET['api'])) { include 'api.php'; exit; }

$DB = json_decode(file_get_contents(__DIR__ . '/data.json'), true);
if(!$DB){ $DB = array("services"=>array(), "users"=>array(), "bookings"=>array()); }

$CURRENT_EMAIL = $_COOKIE['email'] ?? ($_POST['mail'] ?? null);
if(isset($_POST['mail'])) { setcookie('email', $_POST['mail']); };


function role(){
  global $DB,$CURRENT_EMAIL;
  foreach($DB['users'] as $u){ if($u['email']==$CURRENT_EMAIL) return $u['role']; }
  return "anon";
}

function saveDB($d){
  file_put_contents(__DIR__ . '/data.json', json_encode($d, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
}

function getServices(){ global $DB; return $DB['services']; }
function getAllServices(){ global $DB; return $DB['services']; } 

if(isset($_POST['act'])){
  $a = $_POST['act']; 
  if($a=="addservice"){ 
    $n = $_POST['name'] ?? ("Service" . rand(1,9));
    $t = $_POST['type'] ?? "misc";
    $id = count($DB['services'])+1;
    $DB['services'][] = array("id"=>$id,"name"=>$n,"type"=>$t,"slots"=>array());
    saveDB($DB);
    header("Location: index.php?ok=1"); die();
  } else if($a=="addslot"){
    $sid = (int)($_POST['sid'] ?? 0);
    $slt = $_POST['slot'] ?? date('Y-m-d H:i');
    foreach($DB['services'] as &$sv){ if($sv['id']==$sid){ $sv['slots'][]=$slt; } }
    saveDB($DB);
  } else if($a=="book"){
    $email = $CURRENT_EMAIL;
    $sid   = (int)($_POST['sid'] ?? 0);
    $slot  = $_POST['slot'] ?? "";
    $DB['bookings'][] = array("id"=>count($DB['bookings'])+1,"email"=>$email,"service"=>$sid,"slot"=>$slot);
    saveDB($DB);
  } else if($a=="cancel"){
    $bid = (int)($_POST['bid'] ?? 0);
    foreach($DB['bookings'] as $k=>$b){ if($b['id']==$bid){ unset($DB['bookings'][$k]); } }
    saveDB($DB);
  } else {
    echo "unknown action";
  }
}
