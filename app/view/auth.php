<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion</title>
    <link rel="icon" href="data:,">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar bg-danger" data-bs-theme="dark">
    <div class="container">
        <span class="navbar-brand">Cannelle</span>
    </div>
</nav>
<main class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <h1 class="h3 mb-3">Connexion</h1>
            @if(isset($erreur))
            <div class="alert alert-danger" role="alert">Identifiant ou mot de passe incorrect.</div>
            @endif
            <form method="post" action="/auth/login">
                <input type="hidden" name="csrf_token" value="{{ $csrfToken }}">
                <div class="mb-3">
                    <label class="form-label" for="login">Identifiant</label>
                    <input class="form-control" type="text" id="login" name="login" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Mot de passe</label>
                    <input class="form-control" type="password" id="password" name="password" required>
                </div>
                <button class="btn btn-danger" type="submit">Se connecter</button>
            </form>
        </div>
    </div>
</main>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>