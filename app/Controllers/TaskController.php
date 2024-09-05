<?php

namespace App\Controllers;

use Core\Controller;

class TaskController extends Controller {
 
    public function index() {
        echo "Listando todas as tarefas";
    }

    public function create() {
        echo "Formulário para criar nova tarefa";
    }

    public function store() {
        echo "Salvando nova tarefa";
    }

    public function edit($id) {
        echo "Editando a tarefa com ID: " . $id;
    }

    public function update($id) {
        echo "Atualizando a tarefa com ID: " . $id;
    }

    public function delete($id) {
        echo "Excluindo a tarefa com ID: " . $id;
    }
}
