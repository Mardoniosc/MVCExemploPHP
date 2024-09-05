<?php

namespace App\Repository;

use Core\Repository;
use PDO;
use PDOException;

class UserRepository extends Repository
{

    public function __construct()
    {
        parent::__construct();
        parent::getConnection();
        $this->table = "users";
    }

    public function insert($obj)
    {
        $sql = "INSERT INTO $this->table (username, password) VALUES (:username, :password)";

        try {
            $statement = $this->connectionPdo->prepare($sql);
            $statement->bindValue(':username', $obj->username);
            $statement->bindValue(':password', password_hash($obj->password, PASSWORD_DEFAULT));
            $statement->execute();

            if ($statement->rowCount() > 0) {
                return true;
            } else {
                parent::showErrors();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function update($obj)
    {

        $sql = "UPDATE $this->table SET username = :username, password = :password WHERE id = :id";

        try {
            $statement = $this->connectionPdo->prepare($sql);

            $statement->bindValue(':username', $obj->username);
            $statement->bindValue(':password', $obj->password);
            $statement->bindValue(':id', $obj->id);
            $statement->execute();

            if ($statement->rowCount() >= 0) {
                return true;
            } else {
                parent::showErrors();
                return false;
            }
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function list()
    {
        return parent::findAll();
    }

    public function listById($id)
    {
        return parent::findById($id);
    }

    public function listByUserName($username) {
        $dados = [];
        $sql = "SELECT * FROM $this->table WHERE username = :username order by 1";

        try {
            $statement = $this->connectionPdo->prepare($sql);
            $statement->bindValue(':username', $username);
            $statement->execute();
            if ($statement->rowCount() > 0) {
                $dados = $statement->fetchAll(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            
            return $dados;
        }
    }

    public function delete($id)
    {
        return parent::deleteById($id);
    }
}
