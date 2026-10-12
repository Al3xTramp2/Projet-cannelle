<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Casernes</title>
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
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Casernes ({{ $total }})</h1>
        <a class="btn btn-danger"
           href="/caserne/ajouter">Nouvelle caserne</a>
    </div>
    <form method="get" action="/caserne/ville" class="row g-2 mb-3">
        <div class="col-auto">
            <input type="text" class="form-control" name="ville" maxlength="20"
                   placeholder="Ville (nom exact)" aria-label="Ville" required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-secondary">Rechercher</button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead>
            <tr>
                <th>#</th>
                <th>Numéro</th>
                <th>Adresse</th>
                <th>Code postal</th>
                <th>Ville</th>
                <th>Type</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($casernes as $index => $caserne)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $caserne->getNumCaserne() }}</td>
                <td>{{ $caserne->getAdresse() }}</td>
                <td>{{ $caserne->getCP() }}</td>
                <td>{{ $caserne->getVille() }}</td>
                <td>{{ $caserne->getType() }}</td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-secondary"
                       href="/caserne/detail?numCaserne={{ $caserne->getNumCaserne() }}">Détail</a>
                    <a class="btn btn-sm btn-outline-primary"
                       href="/caserne/modifier?numCaserne={{ $caserne->getNumCaserne() }}">Modifier</a>
                    <a class="btn btn-sm btn-outline-danger"
                       href="/caserne/supprimer?numCaserne={{ $caserne->getNumCaserne() }}">Supprimer</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</main>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
