<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Red Social</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p style="color: green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form action="index.php?c=auth&action=login" method="POST">
        <div>
            <label for="username">Usuario:</label><br>
            <input type="text" name="username" id="username" required>
        </div>
        <br>
        <div>
            <label for="password">Contraseña:</label><br>
            <input type="password" name="password" id="password" required>
        </div>
        <br>
        <button type="submit">Entrar</button>
    </form>

    <p>¿No tienes cuenta todavía? <a href="index.php?c=auth&action=register">Regístrate aquí</a></p>
</body>
</html>