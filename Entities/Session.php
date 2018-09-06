<?php

namespace OfficeGuru\Entities;

use Lando\Token;

class Session
{
	const TYPE_LOGIN = 'login';
	const TYPE_RECOVERY = 'recovery';

	const DEFAULT_EXPIRATION_DATE = [
		self::TYPE_LOGIN => '+5 years',
		self::TYPE_RECOVERY =>'+5 minutes',
	];

	/** @var int */
	private $id_user;
	/** @var string */
	private $type;
	/** @var string */
	private $token;
	/** @var string */
	private $expirationDate;

	private function __construct(int $id_user, string $type, string $token, \DateTime $expirationDate = null)
	{
		$this->id_user = $id_user;
		$this->type = $type;
		$this->token = $token ? $token : Token::generate();
		$this->setExpirationDate($expirationDate);
	}

	static function newLogin(int $id_user, string $token = '', \DateTime $expirationDate = null) 
	{
		return new Session($id_user, self::TYPE_LOGIN, $token, $expirationDate);
	}

	static function newRecovery(int $id_user, string $token = '', \DateTime $expirationDate = null) 
	{
		return new Session($id_user, self::TYPE_RECOVERY, $token, $expirationDate);
	}

	/** @return int */
	public function getIdUser(): int
	{
		return $this->id_user;
	}

	/** @return string */
	public function getType(): string
	{
		return $this->type;
	}

	/** @return string */
	public function getToken(): string
	{
		return $this->token;
	}

	/** @return string */
	public function getExpirationDate(): string
	{
		return $this->expirationDate->format('Y-m-d H:i:s');
	}

	/** @return string */
	public function getExpirationDateInSeconds(): string
	{
		return $this->expirationDate->getTimestamp();
	}

	/** @return void */
	public function setCookie() {
		setcookie('og_' . $this->type, $this->getToken(), $this->getExpirationDateInSeconds());
	}

	/** @return void */
	public function unsetCookie() {
		setcookie('og_' + $this->type, 0, time() * -1);
	}

	private function setExpirationDate($date)
	{
		if(!$date)
		{
			$date = new \DateTime("now");
			$date->modify(self::DEFAULT_EXPIRATION_DATE[$this->type]);
		}
		$this->expirationDate = $date;	
	}
}