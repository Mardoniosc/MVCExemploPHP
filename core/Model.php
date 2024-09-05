<?php

namespace Core;

use PDO;
use PDOException;

class Model {
    protected $db;

    public function __construct() {
        $config = require_once '../config/config.php';

        try {
            $this->db = new PDO(
                'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'],
                $config['db']['user'],
                $config['db']['password']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }
}
