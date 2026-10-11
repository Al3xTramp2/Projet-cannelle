<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pompier</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-danger" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand" href="index.php?c=default&amp;a=home">Cannelle</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Afficher le menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php?c=pompier&amp;a=show">Pompiers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?c=caserne&amp;a=show">Casernes</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="container my-4">
    <div class="card">
        <div class="card-header">
            <h1 class="h4 mb-0">{{ $pompier->getPrenom() }} {{ $pompier->getNom() }}</h1>
        </div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Matricule</dt>
                <dd class="col-sm-9">{{ $pompier->getMatricule() }}</dd>
                <dt class="col-sm-3">Né le</dt>
                <dd class="col-sm-9">{{ $pompier->getDateNaissance()->format("d/m/Y") }}</dd>
                <dt class="col-sm-3">Grade</dt>
                <dd class="col-sm-9">{{ $pompier->getGrade() }}</dd>
                <dt class="col-sm-3">Chef d'agrès</dt>
                <dd class="col-sm-9">{{ $pompier->getChefAgret() === "O" ? "Oui" : "Non" }}</dd>
                <dt class="col-sm-3">Caserne</dt>
                <dd class="col-sm-9">{{ $pompier->getNumCaserne() }}</dd>
                <dt class="col-sm-3">Responsable</dt>
                <dd class="col-sm-9">{{ $pompier->getMatriculeRespo() }}</dd>
            </dl>
        </div>
        <div class="card-footer">
            <a class="btn btn-outline-secondary" href="index.php?c=pompier&amp;a=show">Retour à la liste</a>
            <a class="btn btn-outline-primary" href="index.php?c=pompier&amp;a=update&amp;matricule={{ $pompier->getMatricule() }}">Modifier</a>
        </div>
    </div>
</main>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
