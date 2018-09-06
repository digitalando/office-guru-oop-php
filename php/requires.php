<?php

require_once('files.php');
require_once('users.php');
require_once('usersTokens.php');

/* OOP */
require_once('Controllers/UserController.php');

require_once('Entities/User.php');
require_once('Entities/Session.php');

require_once('Forms/Form.php');
require_once('Forms/UserLoginForm.php');
require_once('Forms/UserRegisterForm.php');
require_once('Forms/UserProfileForm.php');

require_once('Repositories/MySQL.php');
require_once('Repositories/Repository.php');
require_once('Repositories/UserRepository.php');
require_once('Repositories/SessionRepository.php');

require_once('Vendor/Lando/Token.php');

session_start();
$myUserCtrl = new OfficeGuru\Controllers\UserController();
$myUserCtrl->autoLogin();