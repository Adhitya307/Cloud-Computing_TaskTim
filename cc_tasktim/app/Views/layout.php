<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'TaskTim' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/dash.css">
</head>
<body class="bg-gray-50">
    <?= $this->include('partials/navbar') ?>
    
    <main class="main-content">
        <?= $this->renderSection('content') ?>
    </main>

    <script src="/js/main.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>