<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Utilisateurs</title>
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
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/user/liste">Utilisateurs</a>
                </li>
            </ul>
            <a class="btn btn-outline-light me-2" href="/compte/motdepasse">Mot de passe</a>
            <a class="btn btn-outline-light" href="/auth/logout">Déconnexion</a>
        </div>
    </div>
</nav>
<main class="container my-4">
    <div class="card">
        <div class="card-header">
            <h1 class="h4 mb-0">{{ $user->getPrenom() }} {{ $user->getNom() }}</h1>
        </div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Identifiant</dt>
                <dd class="col-sm-9">{{ $user->getIdUser() }}</dd>
                <dt class="col-sm-3">Login</dt>
                <dd class="col-sm-9">{{ $user->getLogin() }}</dd>
                <dt class="col-sm-3">Mail</dt>
                <dd class="col-sm-9">{{ $user->getMail() }}</dd>
                <dt class="col-sm-3">Rôle</dt>
                <dd class="col-sm-9">{{ $user->getRoleName() }}</dd>
                <dt class="col-sm-3">Pompier</dt>
                <dd class="col-sm-9">{{ $user->getMatriculePompier() ?? '' }}</dd>
            </dl>
        </div>
        <div class="card-footer">
            <a class="btn btn-outline-secondary" href="/user/liste">Retour à la liste</a>
            @if(\Supalta\Cannelle\utils\Auth::can('user', 'update'))
            <a class="btn btn-outline-primary" href="/user/modifier?idUser={{ $user->getIdUser() }}">Modifier</a>
            @endif
        </div>
    </div>
</main>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
