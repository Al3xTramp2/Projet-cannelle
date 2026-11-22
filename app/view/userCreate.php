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
    <h1 class="h3 mb-3">Nouvel utilisateur</h1>

    @if(isset($erreur))
    <div class="alert alert-danger">{{ $erreur }}</div>
    @endif

    <form method="post" action="/user/add" class="row g-3">
        <input type="hidden" name="csrf_token" value="{{ $csrfToken }}">

        <div class="col-md-6">
            <label for="login" class="form-label">Login</label>
            <input type="text" class="form-control" id="login" name="login"
                   maxlength="50" value="{{ $old['login'] ?? '' }}" required>
        </div>
        <div class="col-md-6">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password"
                   autocomplete="new-password" required>
        </div>
        <div class="col-md-6">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom"
                   maxlength="50" value="{{ $old['prenom'] ?? '' }}" required>
        </div>
        <div class="col-md-6">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom"
                   maxlength="50" value="{{ $old['nom'] ?? '' }}" required>
        </div>
        <div class="col-md-6">
            <label for="mail" class="form-label">Mail</label>
            <input type="email" class="form-control" id="mail" name="mail"
                   maxlength="100" value="{{ $old['mail'] ?? '' }}" required>
        </div>
        <div class="col-md-6">
            <label for="role" class="form-label">Rôle</label>
            <select class="form-select" id="role" name="role">
                @foreach($roles as $code => $nom)
                <option value="{{ $code }}" {{ ($old['role'] ?? '') == $code ? "selected" : "" }}>{{ $nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <label for="matriculePompier" class="form-label">Pompier lié (facultatif)</label>
            <select class="form-select" id="matriculePompier" name="matriculePompier">
                <option value="">Aucun</option>
                @foreach($pompiers as $pompier)
                <option value="{{ $pompier->getMatricule() }}"
                        {{ ($old['matriculePompier'] ?? '') === $pompier->getMatricule() ? "selected" : "" }}>
                    {{ $pompier->getMatricule() }} {{ $pompier->getPrenom() }} {{ $pompier->getNom() }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-danger">Enregistrer</button>
            <a class="btn btn-outline-secondary" href="/user/liste">Annuler</a>
        </div>
    </form>
</main>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
