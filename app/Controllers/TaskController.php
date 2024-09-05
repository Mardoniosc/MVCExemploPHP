<?php

namespace App\Controllers;

use App\Model\Task;
use Core\Controller;
use App\Repository\TaskRepository;

class TaskController extends Controller {
    private $taskRepository;

    public function __construct() {
        $this->taskRepository = new TaskRepository();
    }

    public function index() {
        $tasks = $this->taskRepository->list();
        $this->render('Tasks/index', ['tasks' => $tasks]);
    }

    public function create() {
        $this->render('Tasks/form');
    }

    public function store() {
        $task = new Task();
        $task->title = $_POST['title'] ?? '';
        $task->description = $_POST['description'] ?? '';

        $errors = $this->validateForm($task);

        if (empty($errors)) {
            if ($this->taskRepository->insert($task)) {
                header('Location: /task');
                exit;
            } else {
                echo "Erro ao criar a tarefa.";
            }
        } else {
            $this->render('Tasks/form', ['errors' => $errors]);
        }
    }

    public function edit($id) {
        $task = $this->taskRepository->listById($id);
        if ($task) {
            $this->render('Tasks/form', ['task' => $task]);
        } else {
            echo "Tarefa não encontrada.";
        }
    }

    public function update($id) {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';

        $task = new Task();
        $task->title = $_POST['title'] ?? '';
        $task->description = $_POST['description'] ?? '';
        $task->id = $id;

        $errors = $this->validateForm($task);

        if (empty($errors)) {


            if ($this->taskRepository->update($task)) {
                header('Location: /task');
                exit;
            } else {
                echo "Erro ao atualizar a tarefa.";
            }
        } else {
            $task = $this->taskRepository->listById($id);
            $this->render('Tasks/form', ['task' => $task, 'errors' => $errors]);
        }
    }

    public function delete($id) {
        if ($this->taskRepository->delete($id)) {
            header('Location: /task');
            exit;
        } else {
            echo "Erro ao excluir a tarefa.";
        }
    }

    private function validateForm(Task $task) {
        $errors = [];

        if (empty($task->title)) {
            $errors[] = 'O título é obrigatório.';
        } elseif (strlen($task->title) < 3) {
            $errors[] = 'O título deve ter pelo menos 3 caracteres.';
        }

        if (empty($task->description)) {
            $errors[] = 'A descrição é obrigatória.';
        } elseif (strlen($task->description) < 5) {
            $errors[] = 'A descrição deve ter pelo menos 5 caracteres.';
        }

        return $errors;
    }

    private function render($view, $data = []) {
        extract($data);
        require_once "../app/Views/$view.php";
    }
}
