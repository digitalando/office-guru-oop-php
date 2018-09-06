<?php

namespace OfficeGuru\Forms;

abstract class Form
{
    /** @var array */
    private $messages;

    public function __construct()
    {
    	$this->messages = [];
    }

    /**
     * @return array 
     */
    public function getMessages() 
    {
        return $this->messages;
    }

    /**
     * @param array $message
     * @return Form 
     */
    public function addMessage($message): Form
    {
    	$this->messages[key($message)] = current($message);
        return $this;
    }

	public abstract function isValid();
}