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
        $this->render('Tasks/index', ['tasks' => $tasks]);
    }

    public function create() {
        $this->render('Tasks/form');
    }

    public function store() {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';

        if ($this->taskModel->createTask($title, $description)) {
            header('Location: /my_task_list/task');
        } else {
            echo "Erro ao criar a tarefa.";
        }
    }

    public function edit($id) {
        $task = $this->taskModel->getTaskById($id);
        if ($task) {
            $this->render('Tasks/form', ['task' => $task]);
        } else {
            echo "Tarefa não encontrada.";
        }
    }

    public function update($id) {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';

        if ($this->taskModel->updateTask($id, $title, $description)) {
            header('Location: /my_task_list/task');
        } else {
            echo "Erro ao atualizar a tarefa.";
        }
    }

    public function delete($id) {
        if ($this->taskModel->deleteTask($id)) {
            header('Location: /my_task_list/task');
        } else {
            echo "Erro ao excluir a tarefa.";
        }
    }

    private function render($view, $data = []) {
        extract($data);
        require_once "../app/Views/$view.php";
    }
}
