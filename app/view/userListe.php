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
            <a class="btn btn-outline-light" href="/auth/logout">Déconnexion</a>
        </div>
    </div>
</nav>
<main class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Utilisateurs ({{ $total }})</h1>
        @if(\Supalta\Cannelle\utils\Auth::can('user', 'create'))
        <a class="btn btn-danger" href="/user/ajouter">Nouvel utilisateur</a>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead>
            <tr>
                <th>#</th>
                <th>Login</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Mail</th>
                <th>Rôle</th>
                <th>Pompier</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->getLogin() }}</td>
                <td>{{ $user->getPrenom() }}</td>
                <td>{{ $user->getNom() }}</td>
                <td>{{ $user->getMail() }}</td>
                <td>{{ $user->getRoleName() }}</td>
                <td>{{ $user->getMatriculePompier() ?? '' }}</td>
                <td class="text-end">
                    @if(\Supalta\Cannelle\utils\Auth::can('user', 'detail'))
                    <a class="btn btn-sm btn-outline-secondary" href="/user/detail?idUser={{ $user->getIdUser() }}">Détail</a>
                    @endif
                    @if(\Supalta\Cannelle\utils\Auth::can('user', 'update'))
                    <a class="btn btn-sm btn-outline-primary" href="/user/modifier?idUser={{ $user->getIdUser() }}">Modifier</a>
                    @endif
                    @if(\Supalta\Cannelle\utils\Auth::can('user', 'delete'))
                    <a class="btn btn-sm btn-outline-danger" href="/user/supprimer?idUser={{ $user->getIdUser() }}">Supprimer</a>
                    @endif
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
