<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Task;

class TaskController extends Controller {
    private $taskModel;

    public function __construct() {
        $this->taskModel = new Task();
    }

    public function index() {
        $tasks = $this->taskModel->getAllTasks();
        foreach ($tasks as $task) {
            echo "ID: $task->id | $task->title | $task->description <br>";
        }
    }

    public function create() {
        echo "Formulário para criar nova tarefa";
        // Aqui você pode renderizar uma view com o formulário de criação
    }

    public function store() {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';

        if ($this->taskModel->createTask($title, $description)) {
            echo "Tarefa criada com sucesso!";
        } else {
            echo "Erro ao criar a tarefa.";
        }
    }

    public function edit($id) {
        $task = $this->taskModel->getTaskById($id);
        if ($task) {
            echo "Editando a tarefa: " . $task->title;
            // Aqui você pode renderizar uma view com o formulário de edição
        } else {
            echo "Tarefa não encontrada.";
        }
    }

    public function update($id) {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';

        if ($this->taskModel->updateTask($id, $title, $description)) {
            echo "Tarefa atualizada com sucesso!";
        } else {
            echo "Erro ao atualizar a tarefa.";
        }
    }

    public function delete($id) {
        if ($this->taskModel->deleteTask($id)) {
            echo "Tarefa excluída com sucesso!";
        } else {
            echo "Erro ao excluir a tarefa.";
        }
    }
}
