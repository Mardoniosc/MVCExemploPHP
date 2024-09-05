<?php

namespace App\Models;

use Core\Model;
use PDO;

class Task extends Model {
    public function getAllTasks() {
        $stmt = $this->db->query("SELECT * FROM tasks");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTaskById($id) {
        $stmt = $this->db->prepare("SELECT * FROM tasks WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function createTask($title, $description) {
        $stmt = $this->db->prepare("INSERT INTO tasks (title, description) VALUES (:title, :description)");
        return $stmt->execute(['title' => $title, 'description' => $description]);
    }

    public function updateTask($id, $title, $description) {
        $stmt = $this->db->prepare("UPDATE tasks SET title = :title, description = :description WHERE id = :id");
        return $stmt->execute(['id' => $id, 'title' => $title, 'description' => $description]);
    }

    public function deleteTask($id) {
        $stmt = $this->db->prepare("DELETE FROM tasks WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
