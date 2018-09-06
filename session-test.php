<?php 
require_once('./php/requires.php'); 

use OfficeGuru\Entities\Session;
use OfficeGuru\Repositories\SessionRepository;

$mySession = Session::newLogin(1);
$mySession2 = Session::newRecovery(1);

echo '<pre>';
print_r($mySession);
echo '<br>';
print_r($mySession->getExpirationDate());
echo '<br>';
print_r($mySession->getRemainingSeconds());
echo '<br>';
print_r($mySession2->getRemainingSeconds());
//$mySessionRepo = new SessionRepository();
//$mySessionRepo->insert($mySession);
?>