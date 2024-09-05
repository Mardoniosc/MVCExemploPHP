<h1><?php echo isset($task) ? 'Editar Tarefa' : 'Criar Nova Tarefa'; ?></h1>

<?php if (isset($errors) && !empty($errors)) : ?>
    <div style="color: red;">
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?php echo isset($task) ? '/my_task_list/task/update/' . $task->id : '/my_task_list/task/store'; ?>" method="POST">
    <div>
        <label for="title">Título:</label>
        <input type="text" id="title" name="title" value="<?php echo isset($task) ? htmlspecialchars($task->title, ENT_QUOTES, 'UTF-8') : ''; ?>" required>
    </div>
    <div>
        <label for="description">Descrição:</label>
        <textarea id="description" name="description" required><?php echo isset($task) ? htmlspecialchars($task->description, ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
    </div>
    <button type="submit"><?php echo isset($task) ? 'Atualizar' : 'Criar'; ?></button>
</form>

<a href="/my_task_list/task">Voltar à Lista de Tarefas</a>
