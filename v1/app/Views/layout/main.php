<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'SiMoRI - Sistema de Monitoramento de Repositórios Institucionais') ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS custom -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        footer {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">
                <i class="bi bi-diagram-3"></i> SiMoRI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/repositorios') ?>">Repositórios</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/indicadores') ?>">Indicadores</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/admin') ?>">Administração</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo dinâmico -->
    <main class="container py-4">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>