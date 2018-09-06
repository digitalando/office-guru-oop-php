<?php

namespace OfficeGuru\Forms;

use OfficeGuru\Repositories\UserRepository;

class UserLoginForm extends Form
{
	/** @var string */
	private $email;
	/** @var string */
	private $password;
	/** @var bool */
	private $rememberMe;

	public function __construct($post)
	{
        $this->email = $post['email'] ?? '';
        $this->password = $post['password'] ?? '';
        $this->rememberMe = false;
        if (isset($post['remember_me']) && $post['remember_me'] == 'on')
        {
        	$this->rememberMe = true;
        }
	}

    /**
     * @return bool
     */
	public function isValid(): bool
	{        
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            $this->addMessage(array('email' => 'Debe ingresar un email válido'));
        }

        return empty($this->getMessages());
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function getRememberMe(): bool
	{
		return $this->rememberMe;
	}
}