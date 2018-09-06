<?php 

namespace OfficeGuru\Repositories;

use OfficeGuru\Entities\User;
use \PDO;

class UserRepository extends Repository
{
    protected static $table = 'user';

    /**
     * @param array $row
     * @return User
     */
    protected function rowToEntity(array $row): User
    {
        $entity = new User(
            $row['first_name'],
            $row['last_name'],
            $row['email']
        );

        /** @doubt ¿Acá van todos los campos de la base? */
        $entity->setId($row['user_id']);
        $entity->setPassword($row['password']);
        if($row['image'])
        {
            $entity->setImage($row['image']);
        }

        return $entity;
    }

    /**
     * @param User $user
     * @return bool
     */
    function insert(User $user)
    {
        $this->conn->beginTransaction();
        try 
        {
            $stmt = $this->conn->prepare("
                INSERT INTO " . static::$table . " (
                    first_name, last_name, email, password, image
                ) VALUES (
                    :first_name, :last_name, :email, :password, :image
                );
            ");

            $stmt->bindValue(':first_name', $user->getFirstName(), PDO::PARAM_STR);
            $stmt->bindValue(':last_name', $user->getLastName(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
            $stmt->bindValue(
                ':image',
                $user->getImage() ?? null,
                $user->getImage() ? PDO::PARAM_STR : PDO::PARAM_NULL
            );

            $stmt->execute();
            $this->conn->commit();

            return true;
        } 
        catch(PDOException $e) 
        {
            $this->conn->rollBack();

            return false;
        }
    }

    /**
     * @param User $user
     * @return bool
     */
    function update(User $user)
    {
        $this->conn->beginTransaction();
        try 
        {
            $stmt = $this->conn->prepare("
                UPDATE " . static::$table . " SET
                    first_name = ':first_name',
                    last_name = ':last_name',
                    email = ':email',
                    image = ':image'
                WHERE
                    user_id = {$user->getId}
                );
            ");

            $stmt->bindValue(':first_name', $user->getFirstName(), PDO::PARAM_STR);
            $stmt->bindValue(':last_name', $user->getLastName(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(
                ':image',
                $user->getImage() ?? null,
                $user->getImage() ? PDO::PARAM_STR : PDO::PARAM_NULL
            );

            $stmt->execute();
            $this->conn->commit();

            return true;
        } 
        catch(PDOException $e) 
        {
            $this->conn->rollBack();

            return false;
        }
    }
}