<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Supprimer un pompier</title>
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
                    <a class="nav-link active" aria-current="page" href="/pompier/liste">Pompiers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/caserne/liste">Casernes</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="container my-4">
    <div class="card border-danger">
        <div class="card-header bg-danger text-white">
            <h1 class="h5 mb-0">Supprimer {{ $pompier->getPrenom() }} {{ $pompier->getNom() }} ?</h1>
        </div>
        <div class="card-body">
            <p class="mb-3">Le pompier {{ $pompier->getMatricule() }} sera marqué comme supprimé.</p>
            <form method="post" action="/pompier/delete">
                <input type="hidden" name="matricule" value="{{ $pompier->getMatricule() }}">
                <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
                <a class="btn btn-outline-secondary" href="/pompier/liste">Annuler</a>
            </form>
        </div>
    </div>
</main>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
