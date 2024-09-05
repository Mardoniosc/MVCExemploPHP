<h1>Lista de Tarefas</h1>

<a href="/my_task_list/task/create">Criar Nova Tarefa</a>

<ul>
    <?php if (!empty($tasks)) : ?>
        <?php foreach ($tasks as $task) : ?>
            <li>
                <strong><?php echo $task->title; ?></strong>
                <p><?php echo $task->description; ?></p>
                <a href="/my_task_list/task/edit/<?php echo $task->id; ?>">Editar</a>
                <a href="/my_task_list/task/delete/<?php echo $task->id; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
            </li>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Nenhuma tarefa encontrada.</p>
    <?php endif; ?>
</ul>
