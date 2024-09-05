<?php

namespace App\Repository;

use Core\Repository;
use PDOException;

class TaskRepository extends Repository
{

    public function __construct()
    {
        parent::__construct();
        parent::getConnection();
        $this->table = "tasks";
    }

    public function insert($obj)
    {
        $sql = "INSERT INTO tasks (title, description) VALUES (:title, :description)";

        try {
            $statement = $this->connectionPdo->prepare($sql);
            $statement->bindValue(':title', $obj->title);
            $statement->bindValue(':description', $obj->description);
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

        $sql = "UPDATE tasks SET title = :title, description = :description WHERE id = :id";

        try {
            $statement = $this->connectionPdo->prepare($sql);

            $statement->bindValue(':title', $obj->title);
            $statement->bindValue(':description', $obj->description);
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

    public function delete($id)
    {
        return parent::deleteById($id);
    }
}
