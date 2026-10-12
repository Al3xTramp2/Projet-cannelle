<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nouvelle caserne</title>
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
    <h1 class="h3 mb-3">Nouvelle caserne</h1>

    <form method="post" action="/caserne/add" class="row g-3">

        <div class="col-md-6">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" class="form-control" id="adresse"
                   name="adresse" maxlength="15" required>
        </div>

        <div class="col-md-6">
            <label for="ville" class="form-label">Ville</label>
            <input type="text" class="form-control" id="ville"
                   name="ville" maxlength="20" required>
        </div>

        <div class="col-md-6">
            <label for="cp" class="form-label">Code postal</label>
            <input type="text" class="form-control" id="cp"
                   name="cp" inputmode="numeric" maxlength="5" pattern="[0-9]{5}"
                   title="5 chiffres" required>
        </div>

        <div class="col-md-6">
            <label for="codeTypeC" class="form-label">Type de caserne</label>
            <select class="form-select" id="codeTypeC" name="codeTypeC">
                @foreach($types as $code => $nom)
                <option value="{{ $code }}">{{ $nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-danger">Enregistrer</button>
            <a class="btn btn-outline-secondary"
               href="/caserne/liste">Annuler</a>
        </div>
    </form>
</main>

<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
