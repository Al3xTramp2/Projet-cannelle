<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mot de passe</title>
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
                @if(\Supalta\Cannelle\utils\Auth::can('user', 'read'))
                <li class="nav-item">
                    <a class="nav-link" href="/user/liste">Utilisateurs</a>
                </li>
                @endif
            </ul>
            <a class="btn btn-outline-light me-2 active" href="/compte/motdepasse">Mot de passe</a>
            <a class="btn btn-outline-light" href="/auth/logout">Déconnexion</a>
        </div>
    </div>
</nav>
<main class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <h1 class="h3 mb-3">Changer mon mot de passe</h1>

            @if(isset($erreur))
            <div class="alert alert-danger">{{ $erreur }}</div>
            @endif
            @if(isset($succes))
            <div class="alert alert-success">Mot de passe modifié.</div>
            @endif

            <form method="post" action="/compte/motdepasse">
                <input type="hidden" name="csrf_token" value="{{ $csrfToken }}">
                <div class="mb-3">
                    <label for="oldPassword" class="form-label">Mot de passe actuel</label>
                    <input type="password" class="form-control" id="oldPassword" name="oldPassword"
                           autocomplete="current-password" required>
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label">Nouveau mot de passe</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword"
                           autocomplete="new-password" required>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirmer le nouveau mot de passe</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                           autocomplete="new-password" required>
                </div>
                <button type="submit" class="btn btn-danger">Enregistrer</button>
            </form>
        </div>
    </div>
</main>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
