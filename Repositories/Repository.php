<?php 

namespace OfficeGuru\Repositories;

use \PDO;

abstract class Repository extends MySQL
{
	/** 
	 * @doubt ¿Está bien declarar $table como static? El objetivo es luego poder asignarle
	 * un valor en las clases que hereden de Repository.
	 */
    protected static $table;

    protected abstract function rowToEntity(array $row);

    /**
     * @param array $rows
     * @return array
     */
    protected function rowsToEntities(array $rows)
    {
        $entities = [];
        foreach($rows as $row)
        {
            $entities[] = $this->rowToEntity($row);
        }

        return $entities;
    }

    /**
     * @param string $field
     * @param mixed $value
     * @todo como documento lo de abajo
     * @return Entity | null
     */
    public function fetchByField(string $field, $value)
    {
		/** 
		 * @doubt ¿Está bien usar static::$table acá? El objetivo es que tome el valor
		 * de $table de la clase que herede de Repository.
		 */
        $stmt = $this->conn->prepare("
            SELECT " . static::$table . ".*
            FROM " . static::$table . "
            WHERE LOWER(" . static::$table . ".$field) = LOWER(:value)
            LIMIT 1
        ");

        $stmt->bindValue(':value', trim($value), PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $this->rowToEntity($result) : null;
    }
}