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

        $errors = $this->validateForm($title, $description);

        if (empty($errors)) {
            if ($this->taskModel->createTask($title, $description)) {
                header('Location: /my_task_list/task');
                exit;
            } else {
                echo "Erro ao criar a tarefa.";
            }
        } else {
            $this->render('Tasks/form', ['errors' => $errors]);
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

        $errors = $this->validateForm($title, $description);

        if (empty($errors)) {
            if ($this->taskModel->updateTask($id, $title, $description)) {
                header('Location: /my_task_list/task');
                exit;
            } else {
                echo "Erro ao atualizar a tarefa.";
            }
        } else {
            $task = $this->taskModel->getTaskById($id);
            $this->render('Tasks/form', ['task' => $task, 'errors' => $errors]);
        }
    }

    public function delete($id) {
        if ($this->taskModel->deleteTask($id)) {
            header('Location: /my_task_list/task');
            exit;
        } else {
            echo "Erro ao excluir a tarefa.";
        }
    }

    private function validateForm($title, $description) {
        $errors = [];

        if (empty($title)) {
            $errors[] = 'O título é obrigatório.';
        } elseif (strlen($title) < 3) {
            $errors[] = 'O título deve ter pelo menos 3 caracteres.';
        }

        if (empty($description)) {
            $errors[] = 'A descrição é obrigatória.';
        } elseif (strlen($description) < 5) {
            $errors[] = 'A descrição deve ter pelo menos 5 caracteres.';
        }

        return $errors;
    }

    private function render($view, $data = []) {
        extract($data);
        require_once "../app/Views/$view.php";
    }
}
