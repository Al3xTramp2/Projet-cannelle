<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pompiers</title>
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
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Pompiers ({{ $total }})</h1>
        <a class="btn btn-danger" href="/pompier/ajouter">Nouveau pompier</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead>
            <tr>
                <th>Matricule</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Grade</th>
                <th>Caserne</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($pompiers as $pompier)
            <tr>
                <td>{{ $pompier->getMatricule() }}</td>
                <td>{{ $pompier->getPrenom() }}</td>
                <td>{{ $pompier->getNom() }}</td>
                <td>{{ $pompier->getGrade() }}</td>
                <td>{{ $pompier->getNumCaserne() }}</td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-secondary" href="/pompier/matricule/{{ $pompier->getMatricule() }}">Détail</a>
                    <a class="btn btn-sm btn-outline-primary" href="/pompier/modifier/{{ $pompier->getMatricule() }}">Modifier</a>
                    <a class="btn btn-sm btn-outline-danger" href="/pompier/supprimer/{{ $pompier->getMatricule() }}">Supprimer</a>
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
