<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accueil</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-danger" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand" href="/default/home">Cannelle</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Afficher le menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/pompier/liste">Pompiers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/caserne/liste">Casernes</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="container my-4">
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <h1 class="display-5 fw-bold">Cannelle</h1>
        <p class="fs-5">Gestion des casernes de pompiers.</p>
        <a class="btn btn-danger btn-lg" href="/pompier/liste">Voir les pompiers</a>
        <a class="btn btn-danger btn-lg" href="/caserne/liste">Voir les casernes</a>
    </div>
</main>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
