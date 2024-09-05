<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas</title>
    <link rel="stylesheet" href="/public/css/style.css">

</head>

<body>
    <div class="container">
        <h1>Lista de Tarefas</h1>


        <ul class="breadcrumb">
            <li><a href="/home">Home</a></li>
            <li><a href="/task/create">Criar Nova Tarefa</a></li>
        </ul>

        <ul>
            <?php if (!empty($tasks)) : ?>
                <?php foreach ($tasks as $task) : ?>
                    <li>
                        <strong><?php echo $task->title; ?></strong>
                        <p><?php echo $task->description; ?></p>
                        <a href="/task/edit/<?php echo $task->id; ?>">Editar</a>
                        <a href="#" class="delete-link" data-id="<?php echo $task->id; ?>">Excluir</a>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Nenhuma tarefa encontrada.</p>
            <?php endif; ?>
        </ul>
    </div>
    <script>
        document.querySelectorAll('.delete-link').forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                if (confirm('Tem certeza que deseja excluir esta tarefa?')) {
                    window.location.href = '/task/delete/' + this.getAttribute('data-id');
                }
            });
        });
    </script>
</body>

</html>