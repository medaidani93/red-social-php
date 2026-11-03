<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?= htmlspecialchars($targetUser['username']) ?> - Red Social</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

    <header class="navbar">
        <div class="nav-container">
            <a href="index.php?c=post&action=feed" class="nav-logo">📸 RedSocial</a>
            <nav class="nav-links">
                <a href="index.php?c=post&action=feed">← Volver al Muro</a>
                <a href="index.php?c=user&action=friends">Mis amigos</a>
                <a href="index.php?c=user&action=search">Buscar amigos</a>
                <a href="index.php?c=auth&action=logout" class="logout">Salir</a>
            </nav>
        </div>
    </header>

    <main class="feed-container" style="max-width: 800px;">
        
        <!-- Cabecera de información del perfil -->
        <section class="profile-header-card">
            <div class="profile-avatar-circle">
                👤
            </div>
            <div class="profile-info">
                <h2><?= htmlspecialchars($targetUser['username']) ?></h2>
                <div class="profile-stats">
                    <span><strong><?= count($userPosts) ?></strong> publicaciones</span>
                    <span><strong><?= count($userFriends) ?></strong> amigos</span>
                </div>
            </div>
        </section>

        <!-- Cuadrícula de fotos subidas -->
        <section>
            <?php if (empty($userPosts)): ?>
                <div style="background: #fff; border: 1px solid #dbdbdb; border-radius: 8px; padding: 40px; text-align: center; color: #8e8e8e;">
                    <p>Este usuario aún no ha compartido ninguna foto.</p>
                </div>
            <?php else: ?>
                <div class="photo-grid">
                    <?php foreach ($userPosts as $p): ?>
                        <div class="photo-grid-item">
                            <?php if (!empty($p['foto'])): ?>
                                <img src="<?= htmlspecialchars($p['foto']) ?>" alt="Foto de <?= htmlspecialchars($targetUser['username']) ?>">
                            <?php endif; ?>
                            <?php if (!empty($p['texto'])): ?>
                                <div class="photo-grid-caption" title="<?= htmlspecialchars($p['texto']) ?>">
                                    <?= htmlspecialchars($p['texto']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

    </main>

</body>
</html>