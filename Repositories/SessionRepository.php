<?php 

namespace OfficeGuru\Repositories;

use OfficeGuru\Entities\Session;
use \PDO;

class SessionRepository extends Repository
{
    protected static $table = 'session';

    /**
     * @param array $row
     * @return User
     */
    protected function rowToEntity(array $row): Session
    {
        $entity = new User(
            $row['user_id'],
            $row['type'],
            $row['token'],
            $row['expiration_date']
        );

        return $entity;
    }

    /**
     * @param Session $session
     * @return bool
     */
    function insert(Session $session)
    {
        $this->conn->beginTransaction();
        try 
        {
            $currentDate = new \DateTime("now");
            
            $stmt = $this->conn->prepare("
                INSERT INTO " . static::$table . " (
                    user_id, type, token, creation_date, expiration_date
                ) VALUES (
                    :user_id, :type, :token, :creation_date, :expiration_date
                );
            ");

            $stmt->bindValue(':user_id', $session->getIdUser(), PDO::PARAM_INT);
            $stmt->bindValue(':type', $session->getType(), PDO::PARAM_STR);
            $stmt->bindValue(':token', $session->getToken(), PDO::PARAM_STR);
            $stmt->bindValue(':creation_date', $currentDate->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':expiration_date', $session->getExpirationDate(), PDO::PARAM_STR);

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
     * @param string $token
     * @return bool
     */
    function deleteByToken(string $token)
    {
        $this->conn->beginTransaction();
        try 
        {       
            $stmt = $this->conn->prepare("
                DELETE FROM " . static::$table . " WHERE token = ':token';
            ");

            $stmt->bindValue(':token', $token, PDO::PARAM_STR);

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