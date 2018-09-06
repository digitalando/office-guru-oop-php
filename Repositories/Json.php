<?php

abstract class Json
{
	const JSON_DIR = __DIR__ . '/../data/');

	/** @var string */
	var $file;
	/** @var string */
	var $entity;

	/**
	 * We asume the name of the file will allways be the same as the entity.
	 * If it's not the case anymore, this code will need refactoting.
	 */
	public function __construct($entity)
	{
		$this->file = $entity . '.json';
		$this->entity = $entity;
	}

	/** @returns array */
	protected function read() :array
	{
		if (!file_exists(JSON_DIR . $this->file))
	    {
	        $this->write();
	    }

	    $entities = file_get_contents(JSON_DIR . $this->file);

	    $entities = json_decode($entities, true);

	    return $entities[$this->entity];
	}

	/**
	 * This function will overwrite any existing contents of the file 
	 *
	 * @return void
	 */
	protected function write(array $entities = [])
	{
	    $content = [
	        $this->entity => $entities
	    ];

	    file_put_contents(JSON_DIR . $this->file, json_encode($content));
	}

    protected abstract function rowToEntity(array $row);

	/** @returns array */
    protected function rowsToEntities(array $rows): array
    {
        $entities = [];
        foreach($rows as $row)
        {
            $entities[] = $this->rowToEntity($row);
        }

        return $entities;
    }
}