<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($task) ? 'Editar Tarefa' : 'Criar Nova Tarefa'; ?></title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>

<body>
    <div class="container">
        <?php if (isset($errors) && !empty($errors)) : ?>
            <div style="color: red;">
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <h2>Login</h2>
        <form action="/login/authenticate" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>

</html>