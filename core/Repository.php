<?php

namespace Core;

use PDO;
use PDOException;

abstract class Repository {
    public $connectionPdo;

    protected $table;
    protected $tableRelation;
    protected $array;
    protected $tableKey;

    function __construct()
    {
        $config = require_once '../config/config.php';

        $typoBanco = $config['db']['typoBanco'];
        $host = $config['db']['host'];
        $port = $config['db']['port'];
        $dbname = $config['db']['dbname'];
        $user = $config['db']['user'];
        $password = $config['db']['password'];

        $dsn = "$typoBanco:host=$host;port=$port;dbname=$dbname";

        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            if (!isset($GLOBALS["connectionPdo"])) {
                $GLOBALS["connectionPdo"] = new PDO($dsn, $user, $password, $options);
            }

            $this->connectionPdo = $GLOBALS["connectionPdo"];
        } catch (PDOException $e) {
            echo "<pre>";
            var_dump($e);
            echo $e->getMessage();
        }
    }


    public abstract function insert($obj);

    public abstract function update($obj);

    public abstract function list();

    public abstract function listById($id);

    public function __get($value)
    {
        return $this->$value;
    }

    public function __set($attribute, $value)
    {
        $this->$attribute = $value;
    }

    public function getLastInsertId()
    {
        return $this->connectionPdo->lastInsertId();
    }

    public function findById($id)
    {
        $dados = [];

        $sql = "SELECT * FROM $this->table WHERE id = :id";

        try {
            $statement = $this->connectionPdo->prepare($sql);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            if ($statement->rowCount() > 0) {
                $dados = $statement->fetch(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            echo 'Erro: ' . $e->getMessage();
        } finally {
            return $dados;
        }
    }

    public function findAll()
    {
        $dados = [];
        $sql = "SELECT * FROM $this->table order by 2";

        try {
            $statement = $this->connectionPdo->prepare($sql);
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

    public function findAllWithLimit($limit)
    {
        $dados = [];
        $sql = "SELECT * FROM $this->table order by 2 limit $limit";

        try {
            $statement = $this->connectionPdo->prepare($sql);
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

    public function findAllOrderBy($colum, $direction="ASC")
    {
        $dados = [];
        $sql = "SELECT * FROM $this->table order by $colum $direction";

        try {
            $statement = $this->connectionPdo->prepare($sql);
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

    public function findByName($name)
    {
        $dados = [];
        $sql = "SELECT * FROM $this->table WHERE nome = :nome order by 1";

        try {
            $statement = $this->connectionPdo->prepare($sql);
            $statement->bindValue(':nome', $name);
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

    public function deleteById($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";

        try {
            $statement = $this->connectionPdo->prepare($sql);
            $statement->bindValue(':id', $id);
            $statement->execute();
            if ($statement->rowCount() > 0) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function disable($id)
    {
        $sql = "UPDATE " . $this->tabela . " set ativo = 0 WHERE id = :id ";
        try {
            $statement = $this->connectionPdo->prepare($sql);
            $statement->bindValue(':id', $id);
            $statement->execute();
            $count = $statement->rowCount();
            
            return $count;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function listObjectsEnable()
    {
        $dados = [];
        $sql = "SELECT * FROM " . $this->tabela . " WHERE ativo = 1 order by 2";
        try {
            $statement = $this->connectionPdo->prepare($sql);
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

    public function listObjectsById($id)
    {
        $dados = [];
        $sql = "SELECT * FROM " . $this->tabela . " WHERE id = $id order by 2";
        try {
            $statement = $this->connectionPdo->prepare($sql);
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

    public function showErrors()
    {
        echo "Erro no Banco de Dados: <br>";
        print_r($this->connectionPdo->errorInfo());
        $this->connectionPdo = NULL;
        exit();
    }

    public function generatyKey()
    {
        return md5(time() . "$%&" . microtime());
    }

    public function getIdsSeparatedByComma() {
        $list = "";
        $sql = "SELECT STRING_AGG(id::TEXT, ',') AS lista_ids 
                FROM (SELECT id::bigint FROM " . $this->table . " ORDER BY id) AS subquery";
        try {
            $statement = $this->connectionPdo->prepare($sql);
            $statement->execute();
            if ($statement->rowCount() > 0) {
                $list = $statement->fetchColumn();
            }
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            return $list;
        }
    }

    function __destruct()
    {
        if (isset($this->connectionPdo)) {
            $this->connectionPdo = NULL;
        }
    }

    public function getConnection()
    {
        if (isset($GLOBALS["connectionPdo"])) {
            $this->connectionPdo = $GLOBALS["connectionPdo"];
        }
    }
}
