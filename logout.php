<?php 

require_once('./php/requires.php');

$myUserCtrl = new OfficeGuru\Controllers\UserController();
$myUserCtrl->logoutAction();