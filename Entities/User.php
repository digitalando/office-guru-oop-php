<?php

namespace OfficeGuru\Entities;

class User
{
	const IMAGE_DEFAULT_FILENAME = 'default.png';
	const IMAGE_DIR = __DIR__ . '/../data/users/images/';
	const IMAGE_PATH = './data/users/images/';

    /** @var int */
    private $id;
    /** @var string */
    private $first_name;
    /** @var string */
    private $last_name;
    /** @var string */
    private $email;
    /** @var string */
	private $password;
	/** @var string */
	private $image;

	public function __construct(string $first_name, string $last_name, string $email, $image = self::IMAGE_DEFAULT_FILENAME)
	{
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->setEmail($email);
		$this->setImage($image);
	}

	/** @return int */
	public function getId(): int
	{
		return $this->id;
	}

	/** 
	 * @param int $id
	 * @return User
	 */
	public function setId(int $id): User
	{
		$this->id = $id;

		return $this;
	}

	/** @return string */
	public function getFirstName(): string
	{
		return $this->first_name;
	}

	/** 
	 * @param string $first_name
	 * @return User
	 */
	public function setFirstName(string $first_name): User
	{
		$this->first_name = $first_name;

		return $this;
	}

	/** @return string */
	public function getLastName(): string
	{
		return $this->last_name;
	}

	/** 
	 * @param string $last_name
	 * @return User
	 */
	public function setLastName(string $last_name): User
	{
		$this->last_name = $last_name;

		return $this;
	}

	/** @return string */
	public function getEmail(): string
	{
		return $this->email;
	}

	/** 
	 * @param string $email
	 * @return User
	 */
	public function setEmail(string $email): User
	{
		$this->email = strtolower(trim($email));

		return $this;
	}

	/** @return string */
	public function getPassword(): string
	{
		return $this->password;
	}

	/** 
	 * @param string $password
	 * @return User
	 */
	public function setPassword(string $password): User
	{
		/* Don't re-hash the password if it is already a hash */
    	$passwordInfo = password_get_info($password);

    	if($passwordInfo['algo'] == 0)
    	{
			$this->password = password_hash($password, PASSWORD_DEFAULT);
    	}
    	else
    	{
    		$this->password = $password;
    	}

		return $this;
	}

	/** 
	 * @param string $password
	 * @return bool
	 */
	public function verifyPassword(string $password): bool
	{
		return password_verify($password, $this->password);;
	}

	/** @return string|null */
	public function getImage()//: ?string // Requires PHP 7.1
	{
		return $this->image;
	}

	/** 
	 * @param string $image
	 * @return User
	 */
	public function setImage(string $image): User
	{
		$this->image = $image;

		return $this;
	}
}
