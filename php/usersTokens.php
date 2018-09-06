<?php
require_once('token.php');

Class UsersTokens {
	const USERS_TOKENS_FILE = __DIR__ . '/../data/usersTokens.json';

	/* @var string - relative date/time format */
	const DEFAULT_EXPIRATION_TIME = '+5 minutes';
	
	/** @var int */
	private $userId;
	/** @var string */
	private $token;
	/** @var string */
	private $expitationDate;

	public function __construct(int $userId) 
	{
		$this->userId = $userId;
	}

	/**
	 * @return string
	 */
	public function generate() :string
	{
		$token = new Token;
		$this->token = $token->getValue();

		$date = new DateTime("now");
		$date->modify(self::DEFAULT_EXPIRATION_TIME);
		$this->expitationDate = $date->format('Y-m-d H:i:s');

		$this->save();

		return $this->token;
	}

	/**
	 * @return void
	 */
	private function save()
	{
		// Sólo puede haber un token activo por usuario
		$this->deleteByUserId($this->userId);

        $newToken = [
        	'userId' => $this->userId,
			'token' => $this->token,
			'expitationDate' => $this->expitationDate,
        ];

	    // @var array $tokens
	    $tokens = $this->list();

	    $tokens[] = $newToken;

        $this->saveUsersTokenFile($tokens);
	}

	/**
	 * @param string $field
	 * @param mixed $value
	 * @return array
	 */
	public static function findByField(string $field, $value): array
	{
	    /* @var array $users */
	    $tokens = self::list();

	    foreach ($tokens as $token) 
	    {
	        if ($token[$field] == $value) {
	            return $token;
	        }
	    }

	    return false;
	}

	/**
	 * @param int $userId
	 * @return void
	 */
	private function deleteByUserId(int $userId)
	{
	    // @var array $tokens
	    $tokens = $this->list();

	    foreach ($tokens as $key => $token) {
	        if ($token['userId'] == $userId) {
	            unset($tokens[$key]);
	            $this->saveUsersTokenFile($tokens);
	        }
	    }
	}

	/**
	 * @return array
	 */
	private function list(): array
	{

	    if (!file_exists(self::USERS_TOKENS_FILE))
	    {
	        $this->saveUsersTokenFile();
	    }

	    $tokens = file_get_contents(self::USERS_TOKENS_FILE);

	    $tokens = json_decode($tokens, true);

	    return $tokens['tokens'];
	}


	/**
	 * @param array $tokens
	 * @return void
	 */	
	private	function saveUsersTokenFile(array $tokens = [])
	{
	    $content = [
	        'tokens' => $tokens
	    ];

	    file_put_contents(self::USERS_TOKENS_FILE, json_encode($content));
	}
}