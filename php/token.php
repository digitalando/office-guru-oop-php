<?php
Class Token {
	/** @var string */
	private $value;

	public function __construct(int $length=32) 
	{
		$this->setValue($length);
	}

	/**
	 * @param int $length
	 * @return void
	 */
	public function setValue(int $length=32)
	{
	    $token = "";
	    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
	    $codeAlphabet.= "0123456789";
	    for($i=0;$i<$length;$i++){
	        $token .= $codeAlphabet[$this->crypto_rand_secure(0,strlen($codeAlphabet))];
	    }

	    $this->value = $token;
	}

	/**
	 * @return string
	 */
	public function getValue(): string
	{
		return $this->value;
	}

	/**
	 * https://stackoverflow.com/questions/3290283/what-is-a-good-way-to-produce-a-random-site-salt-to-be-used-in-creating-passwo/3291689#3291689
	 *
	 * @param int $min 
	 * @param int $max 
	 * @return int
	 */
	private function crypto_rand_secure(int $min, int $max): int
	{
        $range = $max - $min;
        if ($range < 0) return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do 
        {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } 
        while ($rnd >= $range);

        return $min + $rnd;
	}
}