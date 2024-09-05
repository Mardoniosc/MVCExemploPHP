<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($task) ? 'Editar Tarefa' : 'Criar Nova Tarefa'; ?></title>
    <link rel="stylesheet" href="/my_task_list/public/css/style.css">
</head>

<body>
    <div class="container">
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

        <form id="taskForm" action="<?php echo isset($task) ? '/my_task_list/task/update/' . $task->id : '/my_task_list/task/store'; ?>" method="POST">
            <div>
                <label for="title">Título:</label>
                <input type="text" id="title" name="title" value="<?php echo isset($task) ? htmlspecialchars($task->title, ENT_QUOTES, 'UTF-8') : ''; ?>" required>
                <small id="titleError" style="color: red;"></small>
            </div>
            <div>
                <label for="description">Descrição:</label>
                <textarea id="description" name="description" required><?php echo isset($task) ? htmlspecialchars($task->description, ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
                <small id="descriptionError" style="color: red;"></small>
            </div>
            <button type="submit"><?php echo isset($task) ? 'Atualizar' : 'Criar'; ?></button>
        </form>

        <a href="/my_task_list/task">Voltar à Lista de Tarefas</a>
    </div>


    <script>
        document.getElementById('taskForm').addEventListener('submit', function(event) {
            let valid = true;
            let title = document.getElementById('title');
            let description = document.getElementById('description');

            // Reset errors
            document.getElementById('titleError').textContent = '';
            document.getElementById('descriptionError').textContent = '';

            // Validate title
            if (title.value.trim() === '') {
                document.getElementById('titleError').textContent = 'O título é obrigatório.';
                valid = false;
            } else if (title.value.trim().length < 3) {
                document.getElementById('titleError').textContent = 'O título deve ter pelo menos 3 caracteres.';
                valid = false;
            }

            // Validate description
            if (description.value.trim() === '') {
                document.getElementById('descriptionError').textContent = 'A descrição é obrigatória.';
                valid = false;
            } else if (description.value.trim().length < 5) {
                document.getElementById('descriptionError').textContent = 'A descrição deve ter pelo menos 5 caracteres.';
                valid = false;
            }

            if (!valid) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });
    </script>
</body>

</html>