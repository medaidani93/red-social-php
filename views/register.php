<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Red Social</title>
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        .auth-container {
            max-width: 380px;
            margin: 60px auto;
            padding: 0 15px;
        }

        .auth-card {
            background: #ffffff;
            border: 1px solid #dbdbdb;
            border-radius: 8px;
            padding: 30px 25px;
            text-align: center;
        }

        .auth-logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: #262626;
            margin-bottom: 8px;
            text-decoration: none;
            display: inline-block;
        }

        .auth-subtitle {
            color: #8e8e8e;
            font-size: 0.95rem;
            margin-bottom: 24px;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            background: #fafafa;
            border: 1px solid #dbdbdb;
            border-radius: 6px;
            font-size: 0.9rem;
            outline: none;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #a8a8a8;
            background: #ffffff;
        }

        .btn-auth {
            width: 100%;
            padding: 9px;
            margin-top: 6px;
            font-size: 0.95rem;
        }

        .alert-error {
            background: #fde8e8;
            border: 1px solid #f8b4b4;
            color: #c81e1e;
            padding: 10px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            margin-bottom: 16px;
            text-align: left;
        }

        .auth-switch-card {
            background: #ffffff;
            border: 1px solid #dbdbdb;
            border-radius: 8px;
            padding: 18px;
            text-align: center;
            margin-top: 15px;
            font-size: 0.9rem;
            color: #262626;
        }

        .auth-switch-card a {
            color: #0095f6;
            text-decoration: none;
            font-weight: 600;
        }

        .auth-switch-card a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <main class="auth-container">
        <section class="auth-card">
            <h1 class="auth-logo">📸 RedSocial</h1>
            <p class="auth-subtitle">Regístrate para conectar con tus amigos.</p>

            <?php if (!empty($error)): ?>
                <div class="alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="index.php?c=auth&action=register" method="POST" class="auth-form">
                <div>
                    <input type="text" 
                           name="username" 
                           class="form-control" 
                           placeholder="Nombre de usuario" 
                           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" 
                           required 
                           autofocus>
                </div>
                <div>
                    <input type="password" 
                           name="password" 
                           class="form-control" 
                           placeholder="Contraseña" 
                           required>
                </div>
                <button type="submit" class="btn-primary btn-auth">Registrarse</button>
            </form>
        </section>

        <aside class="auth-switch-card">
            ¿Ya tienes una cuenta? <a href="index.php?c=auth&action=login">Inicia sesión</a>
        </aside>
    </main>

</body>
</html>