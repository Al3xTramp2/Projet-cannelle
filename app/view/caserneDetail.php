<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Caserne</title>
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
    <div class="card">
        <div class="card-header">
            <h1 class="h4 mb-0">
                Caserne de {{ $caserne->getVille() }}
            </h1>
        </div>

        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Numéro de la caserne</dt>
                <dd class="col-sm-9">{{ $caserne->getNumCaserne() }}</dd>

                <dt class="col-sm-3">Adresse</dt>
                <dd class="col-sm-9">{{ $caserne->getAdresse() }}</dd>

                <dt class="col-sm-3">Code postal</dt>
                <dd class="col-sm-9">{{ $caserne->getCP() }}</dd>

                <dt class="col-sm-3">Ville</dt>
                <dd class="col-sm-9">{{ $caserne->getVille() }}</dd>

                <dt class="col-sm-3">Type de caserne</dt>
                <dd class="col-sm-9">{{ $caserne->getType() }}</dd>
            </dl>
        </div>

        <div class="card-footer">
            <a class="btn btn-outline-secondary"
               href="/caserne/liste">Retour à la liste</a>
            <a class="btn btn-outline-primary"
               href="/caserne/modifier?numCaserne={{ $caserne->getNumCaserne() }}">Modifier</a>
        </div>
    </div>
</main>

<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
