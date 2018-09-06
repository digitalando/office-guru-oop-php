<?php
namespace OfficeGuru\Controllers;

use OfficeGuru\Entities\User;
use OfficeGuru\Entities\Session;
use OfficeGuru\Forms\UserLoginForm;
use OfficeGuru\Forms\UserRegisterForm;
use OfficeGuru\Forms\UserProfileForm;
use OfficeGuru\Repositories\UserRepository;
use OfficeGuru\Repositories\SessionRepository;

class UserController
{
	public function registerAction($post)
	{
		$myUserForm = new UserRegisterForm($post);
		if ($myUserForm->isValid()) 
		{

			$myUserRepo = new UserRepository();
            if ($myUserRepo->fetchByField('email', $myUserForm->getEmail())) {
                $myUserForm->addMessage(array('email' => 'El mail ya se encuentra registrado'));
            }
            else
            {
				$myUser = new User($post['first_name'], $post['last_name'], $post['email']);
				$myUser->setPassword($post['password']);
            	
				$myUserRepo->insert($myUser);
        		
        		$this->_login($myUser);

				header('location: welcome.php');
				exit;
            }
		}
		/* Set view messages */
		$GLOBALS['view']['messages'] = $myUserForm->getMessages();
	}

	public function profileAction($post, $files)
	{
		$myUserForm = new UserProfileForm($post, $files);
		if ($myUserForm->isValid()) 
		{

		    if (isset($post['image'])) {
		        $user['image'] = $post['image'];
		    }

		    // TODO ¿Esto está bien?
		    if (isset($files['image'])
		        && $files['image']['size'] != 0 
		        && $image = fileUpload($files['image'], USERS_IMAGES_DIR)) 
		    {
		        $user['image'] = $image;
		    }
    
			$myUser = new User($post['first_name'], $post['last_name'], $post['email'], $imagePath);

			$myUserRepo = new UserRepository();
			$myUserRepo->update($myUser);

			header('location: profile.php');
			exit;
		}

		/* Set view messages */
		$GLOBALS['view']['messages'] = $myUserForm->getMessages();
	}

	/* Tal vez esto deba ir en una clase de autentiación */
	public function loginAction($post)
	{
		$myLoginForm = new UserLoginForm($post);
		if ($myLoginForm->isValid())
		{
        	$myUserRepo = new UserRepository;
        	$myUser = $myUserRepo->fetchByField('email', $myLoginForm->getEmail());

            if (!$myUser) {
                $myLoginForm->addMessage(
                	array('email' => 'El mail no se encuentra registrado en el sitio')
            	);
            }
            else
            {
            	if (!$myUser->verifyPassword($myLoginForm->getPassword())) 
            	{
	                $myLoginForm->addMessage(
	                	array('password' => 'El password es incorrecto')
	            	);	
            	}
            	else
            	{
            		$this->_login($myUser);
    				if($myLoginForm->getRememberMe())
					{
						$mySession = Session::newLogin($myUser->getId());
						$mySession->setCookie();

						$mySessionRepo = new SessionRepository();
						$mySessionRepo->insert($mySession);
					}

		            // @todo Save destination URL if existent and redirect
					header('location: index.php');
					exit;
            	}
            }

		}

		/* Set view messages */
		$GLOBALS['view']['messages'] = $myLoginForm->getMessages();
	}

	public function logoutAction()
	{
	    unset($_SESSION['og_user']);
	    session_destroy();
	    
	    $token = $_COOKIE['og_login'] ?? null;

	    if ($token) {
		    setcookie('og_login', 0, time() * -1);

			$mySessionRepo = new SessionRepository();
			$mySessionRepo->deleteByToken($token);
	    }

	    header('location: index.php');
		exit;
	}

	/**
	 * @return bool
	 */
	public function isLoggedIn(): bool
	{
	    return isset($_SESSION['og_user']);
	}

	/**
	 * @return void
	 */
	public function autoLogin()
	{
	    //chequear si ya esta logueado
	    if(!$this->isLoggedIn() && isset($_COOKIE['og_login']))
	    {
	        //leer cookie
	        $token = $_COOKIE['og_login'];

	        if($token) 
	        {
				$mySessionRepo = new SessionRepository();
				$mySession = $mySessionRepo->fetchByField('token', $token);

	        	$myUserRepo = new UserRepository;
	        	$myUser = $myUserRepo->fetchByField('user_id', $mySession->getUserId());

		        if($myUser)
		        {
		            $this->_login($myUser);
		        }
	        }

	    }

	}

	/**
	* @param User $user
	*/
	private function _login(User $user)
	{
		$user->setPassword('');
		$_SESSION['og_user'] = $user;
	}

}