<h1><?php echo isset($task) ? 'Editar Tarefa' : 'Criar Nova Tarefa'; ?></h1>

<form action="<?php echo isset($task) ? '/my_task_list/task/update/' . $task->id : '/my_task_list/task/store'; ?>" method="POST">
    <div>
        <label for="title">Título:</label>
        <input type="text" id="title" name="title" value="<?php echo isset($task) ? $task->title : ''; ?>" required>
    </div>
    <div>
        <label for="description">Descrição:</label>
        <textarea id="description" name="description" required><?php echo isset($task) ? $task->description : ''; ?></textarea>
    </div>
    <button type="submit"><?php echo isset($task) ? 'Atualizar' : 'Criar'; ?></button>
</form>

<a href="/my_task_list/task">Voltar à Lista de Tarefas</a>
