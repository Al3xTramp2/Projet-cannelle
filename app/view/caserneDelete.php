<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Supprimer une caserne</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>

<body>
<nav class="navbar navbar-expand-lg bg-danger" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand" href="/default/home">Cannelle</a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#menu"
                aria-controls="menu" aria-expanded="false"
                aria-label="Afficher le menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/pompier/liste">Pompiers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"
                       href="/caserne/liste">Casernes</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container my-4">
    <div class="card border-danger">
        <div class="card-header bg-danger text-white">
            <h1 class="h5 mb-0">
                Supprimer la caserne de {{ $caserne->getVille() }} ?
            </h1>
        </div>

        <div class="card-body">
            <p class="mb-3">
                La caserne n° {{ $caserne->getNumCaserne() }} sera marquée comme supprimée.
            </p>
            <p class="mb-3">
                Les pompiers affectés à cette caserne seront détachés de celle-ci.
            </p>

            <form method="post" action="/caserne/delete/{{ $caserne->getNumCaserne() }}">

                <button type="submit" class="btn btn-danger">
                    Confirmer la suppression
                </button>
                <a class="btn btn-outline-secondary"
                   href="/caserne/liste">Annuler</a>
            </form>
        </div>
    </div>
</main>

<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
