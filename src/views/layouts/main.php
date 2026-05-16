<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Focus - Organizador de Tarefas' ?></title>
    <link rel="stylesheet" href="<?= url('public/assets/css/style.css') ?>">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <h1 class="logo">
                <a href="<?= url('tasks') ?>">📋 Focus</a>
            </h1>
            <nav class="nav">
                <a href="<?= url('tasks') ?>" class="nav-link">Todas</a>
                <a href="<?= url('tasks?filter=pending') ?>" class="nav-link">Pendentes</a>
                <a href="<?= url('tasks?filter=completed') ?>" class="nav-link">Concluídas</a>
                <a href="<?= url('tasks/create') ?>" class="btn btn-primary">+ Nova Tarefa</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main">
        <div class="container">
            <!-- Mensagens Flash -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= e($_SESSION['success']) ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?= e($_SESSION['error']) ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Conteúdo da Página -->
            <?php require __DIR__ . "/../{$content}.php"; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> Focus - Organize sua rotina com eficiência</p>
        </div>
    </footer>

    <script src="<?= url('public/assets/js/app.js') ?>"></script>
</body>
</html>